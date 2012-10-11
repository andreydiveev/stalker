<?php

/**
 * This is the model class for table "arms".
 *
 * The followings are the available columns in table 'arms':
 * @property integer $id
 * @property integer $type_id
 * @property string $name
 * @property integer $price
 * @property integer $damage
 * @property integer $base_reloading_time
 *
 * The followings are the available model relations:
 * @property ArmsType $type
 * @property UserArms[] $userArms
 */
class Arms extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Arms the static model class
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
		return 'arms';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_id, name, price', 'required'),
			array('type_id, price, damage, base_reloading_time', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type_id, name, price, damage, base_reloading_time', 'safe', 'on'=>'search'),
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
			'type' => array(self::BELONGS_TO, 'ArmsType', 'type_id'),
			'userArms' => array(self::HAS_MANY, 'UserArms', 'arms_id'),
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
			'price' => 'Price',
			'damage' => 'Damage',
            'base_reloading_time' => 'Base Reloading Time',
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
		$criteria->compare('price',$this->price);
		$criteria->compare('damage',$this->damage);
        $criteria->compare('base_reloading_time',$this->base_reloading_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}