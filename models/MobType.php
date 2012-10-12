<?php

/**
 * This is the model class for table "mob_type".
 *
 * The followings are the available columns in table 'mob_type':
 * @property integer $id
 * @property string $name
 * @property integer $level
 * @property integer $profession_id
 * @property integer $class_id
 *
 * The followings are the available model relations:
 * @property Mob[] $mobs
 * @property Levels $level0
 * @property Profession $profession
 * @property MobClass $class
 */
class MobType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MobType the static model class
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
		return 'mob_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, level, profession_id, class_id', 'required'),
			array('level, profession_id, class_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, level, profession_id, class_id', 'safe', 'on'=>'search'),
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
			'mobs' => array(self::HAS_MANY, 'Mob', 'type_id'),
			'level0' => array(self::BELONGS_TO, 'Levels', 'level'),
			'profession' => array(self::BELONGS_TO, 'Profession', 'profession_id'),
			'class' => array(self::BELONGS_TO, 'MobClass', 'class_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'level' => 'Level',
			'profession_id' => 'Profession',
			'class_id' => 'Class',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('level',$this->level);
		$criteria->compare('profession_id',$this->profession_id);
		$criteria->compare('class_id',$this->class_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}