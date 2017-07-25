<?php

/**
 * This is the model class for table "tbl_sales_details_component".
 *
 * The followings are the available columns in table 'tbl_sales_details_component':
 * @property integer $sales_details_component_id
 * @property integer $sales_details_id
 * @property integer $product_id
 * @property integer $unit_id
 * @property double $sales_details_component_quantity
 *
 * The followings are the available model relations:
 * @property SalesDetails $salesDetails
 * @property Products $product
 * @property Unit $unit
 */
class SalesDetailsComponent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_sales_details_component';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sales_details_id, product_id, unit_id, sales_details_component_quantity', 'required'),
			array('sales_details_id, product_id, unit_id', 'numerical', 'integerOnly'=>true),
			array('sales_details_component_quantity', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sales_details_component_id, sales_details_id, product_id, unit_id, sales_details_component_quantity', 'safe', 'on'=>'search'),
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
			'salesDetails' => array(self::BELONGS_TO, 'SalesDetails', 'sales_details_id'),
			'product' => array(self::BELONGS_TO, 'Products', 'product_id'),
			'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sales_details_component_id' => 'Sales Details Component',
			'sales_details_id' => 'Sales Details',
			'product_id' => 'Product',
			'unit_id' => 'Unit',
			'sales_details_component_quantity' => 'Sales Details Component Quantity',
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

		$criteria->compare('sales_details_component_id',$this->sales_details_component_id);
		$criteria->compare('sales_details_id',$this->sales_details_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('unit_id',$this->unit_id);
		$criteria->compare('sales_details_component_quantity',$this->sales_details_component_quantity);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SalesDetailsComponent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
