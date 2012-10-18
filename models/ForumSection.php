<?php

/**
 * This is the model class for table "forum_section".
 *
 * The followings are the available columns in table 'forum_section':
 * @property integer $id
 * @property integer $forum_id
 * @property integer $parent
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Forum $forum
 * @property ForumSection $parent0
 * @property ForumSection[] $forumSections
 * @property ForumTopic[] $forumTopics
 */
class ForumSection extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ForumSection the static model class
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
		return 'forum_section';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('forum_id, name', 'required'),
			array('forum_id, parent', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, forum_id, parent, name', 'safe', 'on'=>'search'),
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
			'forum' => array(self::BELONGS_TO, 'Forum', 'forum_id'),
			'parent0' => array(self::BELONGS_TO, 'ForumSection', 'parent'),
			'forumSections' => array(self::HAS_MANY, 'ForumSection', 'parent'),
			'forumTopics' => array(self::HAS_MANY, 'ForumTopic', 'section_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'forum_id' => 'Forum',
			'parent' => 'Parent',
			'name' => 'Name',
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
		$criteria->compare('forum_id',$this->forum_id);
		$criteria->compare('parent',$this->parent);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}