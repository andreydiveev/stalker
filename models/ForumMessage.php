<?php

/**
 * This is the model class for table "forum_message".
 *
 * The followings are the available columns in table 'forum_message':
 * @property integer $id
 * @property integer $topic_id
 * @property integer $user_id
 * @property string $text
 * @property integer $date
 * @property integer $deleted
 * @property integer $banned
 *
 * The followings are the available model relations:
 * @property ForumTopic $topic
 */
class ForumMessage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ForumMessage the static model class
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
		return 'forum_message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, topic_id, user_id, text, date', 'required'),
			array('id, topic_id, user_id, date, deleted, banned', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, topic_id, user_id, text, date, deleted, banned', 'safe', 'on'=>'search'),
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
			'topic' => array(self::BELONGS_TO, 'ForumTopic', 'topic_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'topic_id' => 'Topic',
			'user_id' => 'User',
			'text' => 'Text',
			'date' => 'Date',
			'deleted' => 'Deleted',
			'banned' => 'Banned',
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
		$criteria->compare('topic_id',$this->topic_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('date',$this->date);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('banned',$this->banned);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}