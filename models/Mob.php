<?php

/**
 * This is the model class for table "mob".
 *
 * The followings are the available columns in table 'mob':
 * @property integer $id
 * @property integer $type_id
 * @property string $name
 * @property integer $current_hp
 * @property integer $last_beaten_time
 * @property integer $last_beaten_hp
 * @property integer $last_died_time
 * @property integer $area_id
 * @property integer $alive
 *
 * The followings are the available model relations:
 * @property Area $area
 * @property MobType $type
 */
class Mob extends CActiveRecord
{

    const HP_REGEN_SPEED_PER_SEC = 0.5;
    const RESPAWN_TIME           = 60;
    const HIT_STATUS_PENDING     = 'pending';
    const HIT_STATUS_KILLED      = 'killed';
    const HIT_STATUS_WOUNDED     = 'wounded';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Mob the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mob';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_id, name, last_beaten_hp, area_id', 'required'),
			array('type_id, current_hp, last_beaten_time, last_beaten_hp, last_died_time, area_id, alive', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type_id, name, current_hp, last_beaten_time, last_beaten_hp, last_died_time, area_id, alive', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'area' => array(self::BELONGS_TO, 'Area', 'area_id'),
			'type' => array(self::BELONGS_TO, 'MobType', 'type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type_id' => 'Type',
			'name' => 'Name',
			'current_hp' => 'Current Hp',
			'last_beaten_time' => 'Last Beaten Time',
			'last_beaten_hp' => 'Last Beaten Hp',
            'last_died_time' => 'Last Died Time',
			'area_id' => 'Area',
            'alive' => 'Alive',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('current_hp',$this->current_hp);
		$criteria->compare('last_beaten_time',$this->last_beaten_time);
		$criteria->compare('last_beaten_hp',$this->last_beaten_hp);
        $criteria->compare('last_died_time',$this->last_died_time);
		$criteria->compare('area_id',$this->area_id);
        $criteria->compare('alive',$this->alive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function kill(){

        $this->last_beaten_time = time();
        $this->last_died_time   = time();
        $this->current_hp = 0;
        $this->alive = 0;

        $info = new stdClass();
        $info->victim_type = 'mob';
        $info->victim_id = $this->id;

        $increase = Yii::app()->user->upExpo($info);

        $userLog = new UserLog();
        $userLog->user_id = Yii::app()->user->id;
        $userLog->message = 'Expo +'.$increase;
        $userLog->save();

        if($this->save()){
            $result = true;
        }else{
            $result = false;
        }

        return $result;
    }

    public function hit($weapon_type){

        $result = new stdClass();
        $result->status = Mob::HIT_STATUS_PENDING;
        $result->victim = $this->name;

        $damage = Yii::app()->user->getDamage($weapon_type);

        if($damage->value == 0){
            return false;
        }elseif($damage->userArms->getShotTimeRemaining() > 0){
            return $result;
        }else{
            $damage->userArms->last_shot = time();
            $damage->userArms->save();
        }

        $result->assaulter = Yii::app()->user->nick;
        $result->hp_before = $this->getHp();

        $this->current_hp = $this->getHp() - $damage->value;
        $this->last_beaten_time = time();
        $this->last_beaten_hp = $this->current_hp;
        $this->save();



        if($this->current_hp <= 0){
            if($this->kill()){
                $result->hp_after = 0;
                $result->status = Mob::HIT_STATUS_KILLED;
            }
        }else{
            $result->status = Mob::HIT_STATUS_WOUNDED;
            $result->hp_after = $this->getHp();
            $result->damage = $result->hp_before - $result->hp_after;
        }

        return $result;
    }

    public function getHp(){
        $this->refreshHp();

        return $this->current_hp;
    }

    public function refreshHp(){

        $beaten_ago = time() - $this->last_beaten_time;

        $regen = ceil($beaten_ago * Mob::HP_REGEN_SPEED_PER_SEC);

        if(($this->current_hp + $regen) >= $this->type->level_->hp){
            $this->flushHp();
        }else{
            $this->current_hp = $this->last_beaten_hp + $regen;
            if($this->current_hp < 0){$this->current_hp = 0;}
            $this->save();
        }
    }

    public function flushHp(){
        $this->current_hp = $this->type->level_->hp;
        $this->save();
    }

    static public function respawn($area_id){
        $criteria = new CDbCriteria();
        $criteria->condition = 'area_id = :area_id AND (:NOW - last_died_time) >= :respawn_time AND alive = 0';
        $criteria->params = array(
            ':NOW'          => time(),
            ':area_id'      => $area_id,
            ':respawn_time' => Mob::RESPAWN_TIME,
        );

        $mobs = Mob::model()->findAll($criteria);

        if($mobs === null){
            return false;
        }

        foreach($mobs as $mob){
            $mob->alive = 1;
            $mob->current_hp = $mob->type->level_->hp;
            $mob->save();
        }
    }
}