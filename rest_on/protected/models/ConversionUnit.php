<?php

/**
 * This is the model class for table "tbl_conversion_unit".
 *
 * The followings are the available columns in table 'tbl_conversion_unit':
 * @property integer $convertion_id
 * @property integer $convertion_base_unit
 * @property integer $convertion_destination_unit
 * @property double $convertion_factor
 * @property integer $convertion_status
 *
 * The followings are the available model relations:
 * @property TblUnit $convertionBaseUnit
 * @property TblUnit $convertionDestinationUnit
 */
class ConversionUnit extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_conversion_unit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('convertion_base_unit, convertion_destination_unit, convertion_factor, convertion_status', 'required'),
			array('convertion_base_unit, convertion_destination_unit, convertion_status', 'numerical', 'integerOnly'=>true),
			array('convertion_factor', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('convertion_id, convertion_base_unit, convertion_destination_unit, convertion_factor, convertion_status', 'safe', 'on'=>'search'),
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
			'convertionBaseUnit' => array(self::BELONGS_TO, 'TblUnit', 'convertion_base_unit'),
			'convertionDestinationUnit' => array(self::BELONGS_TO, 'TblUnit', 'convertion_destination_unit'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'convertion_id' => 'ID',
			'convertion_base_unit' => 'Unidad Base',
			'convertion_destination_unit' => 'Unidad Destino',
			'convertion_factor' => 'Factor',
			'convertion_status' => 'Estado',
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

		$criteria->with = array('convertionBaseUnit'=>array('joinType' => 'INNER JOIN','together' => true,));

		$criteria->addCondition('t.convertion_status in (0,1)');
		$criteria->compare('convertion_id',$this->convertion_id);
		$criteria->compare('convertion_base_unit',$this->convertion_base_unit);
		$criteria->compare('convertion_destination_unit',$this->convertion_destination_unit);
		$criteria->compare('convertion_factor',$this->convertion_factor);
		$criteria->compare('convertion_status',$this->convertion_status);

		$criteria->order= 'convertionBaseUnit.unit_name ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ConversionUnit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
