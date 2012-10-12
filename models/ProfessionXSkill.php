<?php

/**
 * This is the model class for table "profession_x_skill".
 *
 * The followings are the available columns in table 'profession_x_skill':
 * @property integer $id
 * @property integer $profession
 * @property integer $skill
 *
 * The followings are the available model relations:
 * @property Skill $skill0
 * @property Profession $profession0
 */
class ProfessionXSkill extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProfessionXSkill the static model class
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
		return 'profession_x_skill';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profession, skill', 'required'),
			array('profession, skill', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, profession, skill', 'safe', 'on'=>'search'),
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
			'skill0' => array(self::BELONGS_TO, 'Skill', 'skill'),
			'profession0' => array(self::BELONGS_TO, 'Profession', 'profession'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'profession' => 'Profession',
			'skill' => 'Skill',
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
		$criteria->compare('profession',$this->profession);
		$criteria->compare('skill',$this->skill);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}