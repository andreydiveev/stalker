<?php

/**
 * This is the model class for table "user_message".
 *
 * The followings are the available columns in table 'user_message':
 * @property integer $id
 * @property integer $from
 * @property integer $to
 * @property string $text
 * @property integer $readed
 * @property integer $date
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property User $from0
 * @property User $to0
 */
class UserMessage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserMessage the static model class
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
		return 'user_message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('to, text, date', 'required'),
			array('from, to, readed, date, deleted', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, from, to, text, readed, date, deleted', 'safe', 'on'=>'search'),
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
			'from0' => array(self::BELONGS_TO, 'User', 'from'),
			'to0' => array(self::BELONGS_TO, 'User', 'to'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'from' => 'From',
			'to' => 'To',
			'text' => 'Text',
			'readed' => 'Readed',
			'date' => 'Date',
			'deleted' => 'Deleted',
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
		$criteria->compare('from',$this->from);
		$criteria->compare('to',$this->to);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('readed',$this->readed);
		$criteria->compare('date',$this->date);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function setDeleted(){
        $this->deleted = 1;
        $this->save();
    }
}