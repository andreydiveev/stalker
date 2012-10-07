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
 */
class User extends CActiveRecord
{
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
            array('reg_date, last_activity, last_struck, total_time, frag, squad, expo, level, current_hp, cash, alive, current_area', 'numerical', 'integerOnly'=>true),
            array('email', 'email','checkMX'=>false),
            array('password', 'length', 'max'=>128),
            array('password', 'length', 'min'=>6),
            array('nick', 'length', 'max'=>20),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, email, password, nick, reg_date, last_activity, last_struck, total_time, frag, squad, expo, level, current_hp, current_area, cash, alive', 'safe', 'on'=>'search'),
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
            'userLogs' => array(self::HAS_MANY, 'UserLog', 'user_id'),
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
            'last_struck' => 'Last Struck',
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
        $criteria->compare('last_struck',$this->last_struck);
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
        $this->alive = 0;
    }

    public function refreshHp(){

    }

    public function hit($damage){

        $this->current_hp = ($this->current_hp + ceil($this->getArmor() / UserEquipment::ARMOR_RATE)) - $damage;

        if($this->current_hp <= 0){
            $this->kill();
        }
    }

    public function getDamage(){
        $current_arms = $this->userArms(array('condition'=>'armed = 1'));

        if($current_arms !== null){
            $damage = 0;
            foreach($current_arms as $userArms){
                $damage += $userArms->arms->damage + $userArms->ext_damage;
            }
        }else{
            throw new CHttpException(500,'getDamage');
        }

        return $damage;
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
}