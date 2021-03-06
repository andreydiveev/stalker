<?php

/**
 * This is the model class for table "user_arms".
 *
 * The followings are the available columns in table 'user_arms':
 * @property integer $id
 * @property integer $arms_id
 * @property integer $user_id
 * @property integer $armed
 * @property integer $ext_damage
 * @property integer $ext_reloading_time_less
 * @property integer $last_shot
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Arms $arms
 */
class UserArms extends CActiveRecord
{

    const TAX_PERCENT = 10;

    const KNIFE_TYPE_ID = 2;
    const PISTOL_TYPE_ID = 3;
    const MACHINE_GUN_TYPE_ID = 4;

    const MIN_RELOADING_TIME = 2;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserArms the static model class
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
		return 'user_arms';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('arms_id', 'required'),
			array('arms_id, user_id, armed, ext_damage, ext_reloading_time_less, last_shot', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, arms_id, user_id, armed, ext_damage, ext_reloading_time_less, last_shot', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'arms' => array(self::BELONGS_TO, 'Arms', 'arms_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'arms_id' => 'Arms',
			'user_id' => 'User',
			'armed' => 'Armed',
			'ext_damage' => 'Ext Damage',
            'ext_reloading_time_less' => 'Ext Reloading Time Less',
            'last_shot' => 'Last Shot',
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
		$criteria->compare('arms_id',$this->arms_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('armed',$this->armed);
		$criteria->compare('ext_damage',$this->ext_damage);
        $criteria->compare('ext_reloading_time_less',$this->ext_reloading_time_less);
        $criteria->compare('last_shot',$this->last_shot);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    public function getPriceWithTax(){
        $tax = ($this->arms->price * self::TAX_PERCENT) / 100;
        return $this->arms->price - $tax;
    }

    public function armsOff(){


        $criteria = new CDbCriteria;
        $criteria->with = 'arms';
        $criteria->condition = 'user_id = :user_id AND arms.type_id = :type_id';
        $criteria->params = array(
            ':user_id'=>Yii::app()->user->id,
            ':type_id'=>$this->arms->type_id,
        );

        $model = UserArms::model()->findAll($criteria);

        if($model !== null){
            foreach($model as $userArms){
                $userArms->armed = 0;
                $userArms->save();
            }
        }else{
            print('null');
        }
    }

    /**
     * @return int
     */
    public function getShotTimeRemaining(){

        $since = time() - $this->last_shot;
        $reloading_time = $this->arms->base_reloading_time - $this->ext_reloading_time_less;

        if($reloading_time < UserArms::MIN_RELOADING_TIME){
            $reloading_time = UserArms::MIN_RELOADING_TIME;
        }

        $time_remaining = $reloading_time - $since;

        if($time_remaining < 0){
            $result = 0;
        }else{
            $result = $time_remaining;
        }

        return $result;
    }
}