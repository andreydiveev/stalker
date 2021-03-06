<?php

/**
 * This is the model class for table "user_log".
 *
 * The followings are the available columns in table 'user_log':
 * @property integer $id
 * @property integer $user_id
 * @property string $message
 *
 * The followings are the available model relations:
 * @property User $user
 */
class UserLog extends CActiveRecord
{
    const BASE_LOG_DISPLAY_LIMIT = 5;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserLog the static model class
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
		return 'user_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, message', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('message', 'length', 'max'=>1024),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, message', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'message' => 'Message',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('message',$this->message,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function logDamage($result){

        switch(true){

            case $result->status == User::HIT_STATUS_KILLED:
                $this->message = 'You killed by ['.$result->assaulter.']';
            break;

            case $result->status == User::HIT_STATUS_WOUNDED:
                $this->message = 'You wounded ['.$result->assaulter.'] by '.$result->damage;
            break;
        }

    }

    public function logHit($result){

        switch(true){

            case $result->status == User::HIT_STATUS_KILLED:
                $this->message = 'You kill ['.$result->victim.']';
                break;

            case $result->status == User::HIT_STATUS_WOUNDED:
                $this->message = 'You wound ['.$result->victim.'] by '.$result->damage;
                break;
        }

    }
}