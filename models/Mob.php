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
 * @property integer $area_id
 *
 * The followings are the available model relations:
 * @property Area $area
 * @property MobType $type
 */
class Mob extends CActiveRecord
{
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
			array('type_id, current_hp, last_beaten_time, last_beaten_hp, area_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type_id, name, current_hp, last_beaten_time, last_beaten_hp, area_id', 'safe', 'on'=>'search'),
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
			'area_id' => 'Area',
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
		$criteria->compare('area_id',$this->area_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}