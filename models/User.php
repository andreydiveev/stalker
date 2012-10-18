<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $nick
 * @property integer $reg_date
 * @property integer $last_activity
 * @property integer $last_beaten
 * @property integer $last_beaten_hp
 * @property integer $total_time
 * @property integer $frag
 * @property integer $squad
 * @property integer $expo
 * @property integer $level
 * @property integer $current_hp
 * @property integer $current_area
 * @property integer $cash
 * @property integer $alive
 *
 * The followings are the available model relations:
 * @property UserArms[] $userArms
 * @property UserEquipment[] $userEquipments
 * @property UserLog[] $userLog
 * @property UserMessages[] $outgoingMessages
 * @property UserMessages[] $incomingMessages
 * @property Levels $level_
 */
class User extends CActiveRecord
{

    const HP_REGEN_SPEED_PER_SEC = 0.5;

    const HIT_STATUS_KILLED     = 'killed';
    const HIT_STATUS_PENDING    = 'pending';
    const HIT_STATUS_WOUNDED    = 'wounded';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, password, password2, nick, reg_date', 'required', 'on'=>'registration'),
            array('email, password', 'required', 'on'=>'login'),
            array('reg_date, last_activity, last_beaten, last_beaten_hp, total_time, frag, squad, expo, level, current_hp, cash, alive, current_area', 'numerical', 'integerOnly'=>true),
            array('email', 'email','checkMX'=>false),
            array('password', 'length', 'max'=>128),
            array('password', 'length', 'min'=>6),
            array('nick', 'length', 'max'=>20),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, email, password, nick, reg_date, last_activity, last_beaten, last_beaten_hp, total_time, frag, squad, expo, level, current_hp, current_area, cash, alive', 'safe', 'on'=>'search'),
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
			'userArms' => array(self::HAS_MANY, 'UserArms', 'user_id'),
			'userEquipments' => array(self::HAS_MANY, 'UserEquipment', 'user_id'),
            'userLog' => array(self::HAS_MANY, 'UserLog', 'user_id'),
            'level_' => array(self::BELONGS_TO, 'Levels', 'level'),
            'outgoingMessages' => array(self::HAS_MANY, 'UserMessage', 'to'),
            'incomingMessages' => array(self::HAS_MANY, 'UserMessage', 'from'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'password' => 'Password',
			'nick' => 'Nick',
			'reg_date' => 'Reg Date',
			'last_activity' => 'Last Activity',
            'last_beaten' => 'Last Beaten',
            'last_beaten_hp' => 'Last Beaten Hp',
			'total_time' => 'Total Time',
			'frag' => 'Frag',
			'squad' => 'Squad',
			'expo' => 'Expo',
			'level' => 'Level',
			'current_hp' => 'Current Hp',
			'current_area' => 'Current Area',
			'cash' => 'Cash',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('nick',$this->nick,true);
		$criteria->compare('reg_date',$this->reg_date);
		$criteria->compare('last_activity',$this->last_activity);
        $criteria->compare('last_beaten',$this->last_beaten);
        $criteria->compare('last_beaten_hp',$this->last_beaten_hp);
		$criteria->compare('total_time',$this->total_time);
		$criteria->compare('frag',$this->frag);
		$criteria->compare('squad',$this->squad);
		$criteria->compare('expo',$this->expo);
		$criteria->compare('level',$this->level);
		$criteria->compare('current_hp',$this->current_hp);
		$criteria->compare('current_area',$this->current_area);
		$criteria->compare('cash',$this->cash);
		$criteria->compare('alive',$this->alive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function kill(){

        $this->last_beaten = time();
        $this->current_hp = 0;
        $this->alive = 0;

        if($this->save()){
            $result = true;
        }else{
            $result = false;
        }

        return $result;
    }

    public function hit($weapon_type){

        $result = new stdClass();
        $result->status = User::HIT_STATUS_PENDING;
        $result->victim = $this->nick;

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

        $this->current_hp = ($this->getHp() + ceil($this->getArmor() / UserEquipment::ARMOR_RATE)) - $damage->value;
        $this->last_beaten = time();
        $this->last_beaten_hp = $this->current_hp;
        $this->save();



        if($this->current_hp <= 0){
            if($this->kill()){
                $result->hp_after = 0;
                $result->status = User::HIT_STATUS_KILLED;
            }
        }else{
            $result->status = User::HIT_STATUS_WOUNDED;
            $result->hp_after = $this->getHp();
            $result->damage = $result->hp_before - $result->hp_after;
        }

        $user_log = new UserLog();
        $user_log->user_id = $this->id;
        $user_log->logDamage($result);
        $user_log->save();

        return $result;
    }

    public function getArmed(){

        $result = new stdClass();

        $current_arms = $this->userArms(array('condition'=>'armed = 1'));

        if($current_arms !== null){
            $result->count = 0;
            $result->userArms = array();
            foreach($current_arms as $userArms){
                array_push($result->userArms, $userArms);
                $result->count++;
            }
        }else{
            throw new CHttpException(500,'getDamage');
        }

        return $result;
    }

    public function getDamage($type){

        $armed = $this->getArmed();

        $result = new stdClass();
        $result->value = 0;

        foreach($armed->userArms as $userArms){
            if($userArms->arms->type_id == $type){
                $result->userArms = $userArms;
                $result->value += $userArms->arms->damage + $userArms->ext_damage;
            }
        }

        return $result;
    }

    public function getArmor(){
        $current_equipment = $this->userEquipments(array('condition'=>'equipped = 1'));

        if($current_equipment !== null){
            $armor = 0;
            foreach($current_equipment as $userEquipments){
                $armor += $userEquipments->equipment->armor + $userEquipments->ext_armor;
            }
        }else{
            throw new CHttpException(500,'getDamage');
        }

        return $armor;
    }

    public function getHp(){
        $this->refreshHp();

        return $this->current_hp;
    }

    public function refreshHp(){

        $beaten_ago = time() - $this->last_beaten;

        $regen = ceil($beaten_ago * User::HP_REGEN_SPEED_PER_SEC);

        if(($this->current_hp + $regen) >= $this->getLevel()->hp){
             $this->flushHp();
        }else{
            $this->current_hp = $this->last_beaten_hp + $regen;
            if($this->current_hp < 0){$this->current_hp = 0;}
            $this->save();
        }
    }

    public function flushHp(){
        $this->current_hp = $this->getLevel()->hp;
        $this->save();
    }

    public function getLevel(){
        $level = Levels::model()->find('level = :user_level', array(':user_level'=>$this->level));

        if($level === null){
            throw new CHttpException(404, 'The requested page does not exist. getMaxHp');
        }

        return $level;
    }

    public function upExpo($info){
        $up = 1000;

        $this->expo += $up;
        $this->save();

        return $up;
    }

    public function upCash($info){
        $up = 1000;

        $this->cash += $up;
        $this->save();

        return $up;
    }
}