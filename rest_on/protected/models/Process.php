<?php

/**
 * This is the model class for table "tbl_process".
 *
 * The followings are the available columns in table 'tbl_process':
 * @property integer $process_id
 * @property string $process_cod
 * @property string $process_name
 * @property integer $unit_id
 * @property double $process_unit_value
 * @property integer $process_type_cost
 * @property integer $process_status
 *
 * The followings are the available model relations:
 * @property DirectLabor[] $directLabors
 * @property IndirectLabor[] $indirectLabors
 * @property Unit $unit
 */
class Process extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_process';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('process_cod, process_name, unit_id, process_unit_value, process_type_cost, process_status', 'required'),
			array('unit_id, process_type_cost, process_status', 'numerical', 'integerOnly'=>true),
			array('process_unit_value', 'numerical'),
			array('process_cod', 'length', 'max'=>5),
			array('process_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('process_id, process_cod, process_name, unit_id, process_unit_value, process_type_cost, process_status', 'safe', 'on'=>'search'),
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
			'directLabors' => array(self::HAS_MANY, 'DirectLabor', 'process_id'),
			'indirectLabors' => array(self::HAS_MANY, 'IndirectLabor', 'process_id'),
			'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'process_id' => 'ID',
			'process_cod' => 'Codigo',
			'process_name' => 'Nombre',
			'unit_id' => 'Unidad',
			'process_unit_value' => 'Valor Unidad',
			'process_type_cost' => 'Tipo Costo',
			'process_status' => 'Estado',
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

		$criteria->compare('process_id',$this->process_id);
		$criteria->compare('process_cod',$this->process_cod,true);
		$criteria->compare('process_name',$this->process_name,true);
		$criteria->compare('unit_id',$this->unit_id);
		$criteria->compare('process_unit_value',$this->process_unit_value);
		$criteria->compare('process_type_cost',$this->process_type_cost);
		$criteria->compare('process_status',$this->process_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Process the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
