<?php

/**
 * This is the model class for table "user_equipment".
 *
 * The followings are the available columns in table 'user_equipment':
 * @property integer $id
 * @property integer $user_id
 * @property integer $slot_id
 * @property integer $equipment_id
 * @property integer $equipped
 * @property integer $ext_armor
 *
 * The followings are the available model relations:
 * @property User $user
 * @property UserSlot $slot
 * @property Equipment $equipment
 */
class UserEquipment extends CActiveRecord
{
    const TAX_PERCENT = 10;
    const ARMOR_RATE = 10;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserEquipment the static model class
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
		return 'user_equipment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('slot_id, equipment_id', 'required'),
			array('user_id, slot_id, equipment_id, equipped, ext_armor', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, slot_id, equipment_id, equipped, ext_armor', 'safe', 'on'=>'search'),
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
			'slot' => array(self::BELONGS_TO, 'UserSlot', 'slot_id'),
			'equipment' => array(self::BELONGS_TO, 'Equipment', 'equipment_id'),
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
			'slot_id' => 'Slot',
			'equipment_id' => 'Equipment',
			'equipped' => 'Equipped',
			'ext_armor' => 'Ext Armor',
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
		$criteria->compare('slot_id',$this->slot_id);
		$criteria->compare('equipment_id',$this->equipment_id);
		$criteria->compare('equipped',$this->equipped);
		$criteria->compare('ext_armor',$this->ext_armor);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getPriceWithTax(){
        $tax = ($this->equipment->price * self::TAX_PERCENT) / 100;
        return $this->equipment->price - $tax;
    }

    public function equipmentOff(){


        $criteria = new CDbCriteria;
        $criteria->with = 'equipment';
        $criteria->condition = 'user_id = :user_id AND equipment.type_id = :type_id';
        $criteria->params = array(
            ':user_id'=>Yii::app()->user->id,
            ':type_id'=>$this->equipment->type_id,
        );

        $models = UserEquipment::model()->findAll($criteria);

        if($models !== null){
            foreach($models as $model){
                $model->equipped = 0;
                $model->save();
            }
        }else{
            print('null');
        }
    }
}