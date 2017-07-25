<?php

/**
 * This is the model class for table "tbl_sales_details".
 *
 * The followings are the available columns in table 'tbl_sales_details':
 * @property integer $sale_details_id
 * @property integer $sale_id
 * @property integer $product_id
 * @property integer $wharehouse_id
 * @property double $sale_details_price
 * @property double $sale_details_discount
 * @property double $sale_details_quantity
 * @property string $sale_details_remarks
 *
 * The followings are the available model relations:
 * @property Sales $sale
 * @property Products $product
 * @property Wharehouses $wharehouse
 * @property SalesDetailsComponent[] $salesDetailsComponents
 * @property SalesDetailsTaxes[] $salesDetailsTaxes
 */
class SalesDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_sales_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sale_id, product_id, wharehouse_id, sale_details_price, sale_details_discount, sale_details_quantity', 'required'),
			array('sale_id, product_id, wharehouse_id', 'numerical', 'integerOnly'=>true),
			array('sale_details_price, sale_details_discount, sale_details_quantity', 'numerical'),
			array('sale_details_remarks', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sale_details_id, sale_id, product_id, wharehouse_id, sale_details_price, sale_details_discount, sale_details_quantity, sale_details_remarks', 'safe', 'on'=>'search'),
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
			'sale' => array(self::BELONGS_TO, 'Sales', 'sale_id'),
			'product' => array(self::BELONGS_TO, 'Products', 'product_id'),
			'wharehouse' => array(self::BELONGS_TO, 'Wharehouses', 'wharehouse_id'),
			'salesDetailsComponents' => array(self::HAS_MANY, 'SalesDetailsComponent', 'sales_details_id'),
			'salesDetailsTaxes' => array(self::HAS_MANY, 'SalesDetailsTaxes', 'sale_details_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sale_details_id' => 'Sale Details',
			'sale_id' => 'Sale',
			'product_id' => 'Product',
			'wharehouse_id' => 'Wharehouse',
			'sale_details_price' => 'Sale Details Price',
			'sale_details_discount' => 'Sale Details Discount',
			'sale_details_quantity' => 'Sale Details Quantity',
			'sale_details_remarks' => 'Sale Details Remarks',
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

		$criteria->compare('sale_details_id',$this->sale_details_id);
		$criteria->compare('sale_id',$this->sale_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('wharehouse_id',$this->wharehouse_id);
		$criteria->compare('sale_details_price',$this->sale_details_price);
		$criteria->compare('sale_details_discount',$this->sale_details_discount);
		$criteria->compare('sale_details_quantity',$this->sale_details_quantity);
		$criteria->compare('sale_details_remarks',$this->sale_details_remarks,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SalesDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
