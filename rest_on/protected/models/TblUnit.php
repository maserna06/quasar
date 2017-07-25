<?php

/**
 * This is the model class for table "tbl_unit".
 *
 * The followings are the available columns in table 'tbl_unit':
 * @property integer $unit_id
 * @property string $unit_iternational_unit
 * @property string $unit_name
 * @property integer $unit_status
 *
 * The followings are the available model relations:
 * @property Tbl conversionUnit[] $tbl conversionUnits
 * @property Tbl conversionUnit[] $tbl conversionUnits1
 * @property TblComponents[] $tblComponents
 * @property TblInventories[] $tblInventories
 */
class TblUnit extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_unit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('unit_iternational_unit, unit_name, unit_status', 'required'),
			array('unit_status', 'numerical', 'integerOnly'=>true),
			array('unit_iternational_unit', 'length', 'max'=>20),
			array('unit_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('unit_id, unit_iternational_unit, unit_name, unit_status', 'safe', 'on'=>'search'),
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
			'tbl conversionUnits' => array(self::HAS_MANY, 'Tbl conversionUnit', 'convertion_destination_unit'),
			'tbl conversionUnits1' => array(self::HAS_MANY, 'Tbl conversionUnit', 'convertion_ base_unit'),
			'tblComponents' => array(self::HAS_MANY, 'TblComponents', 'unit_id'),
			'tblInventories' => array(self::HAS_MANY, 'TblInventories', 'inventory_unit'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'unit_id' => 'Unit',
			'unit_iternational_unit' => 'Unit Iternational Unit',
			'unit_name' => 'Unit Name',
			'unit_status' => 'Unit Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('unit_id',$this->unit_id);
		$criteria->compare('unit_iternational_unit',$this->unit_iternational_unit,true);
		$criteria->compare('unit_name',$this->unit_name,true);
		$criteria->compare('unit_status',$this->unit_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblUnit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
