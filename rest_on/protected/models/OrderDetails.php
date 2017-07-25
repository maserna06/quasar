<?php

/**
 * This is the model class for table "tbl_order_details".
 *
 * The followings are the available columns in table 'tbl_order_details':
 * @property integer $order_details_id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $wharehouse_id
 * @property double $order_details_price
 * @property double $order_details_discount
 * @property double $order_details_quantity
 * @property string $order_details_remarks
 *
 * The followings are the available model relations:
 * @property TblOrder $order
 * @property TblProducts $product
 * @property TblWharehouses $wharehouse
 * @property TblOrderDetailsTaxes[] $tblOrderDetailsTaxes
 */
class OrderDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_order_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, product_id, wharehouse_id, order_details_price, order_details_discount, order_details_quantity', 'required'),
			array('order_id, product_id, wharehouse_id', 'numerical', 'integerOnly'=>true),
			array('order_details_price, order_details_discount, order_details_quantity', 'numerical'),
			array('order_details_remarks', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('order_details_id, order_id, product_id, wharehouse_id, order_details_price, order_details_discount, order_details_quantity, order_details_remarks', 'safe', 'on'=>'search'),
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
			'order' => array(self::BELONGS_TO, 'TblOrder', 'order_id'),
			'unit' => array(self::BELONGS_TO, 'TblUnit', 'unit_id'),
			'product' => array(self::BELONGS_TO, 'TblProducts', 'product_id'),
			'wharehouse' => array(self::BELONGS_TO, 'TblWharehouses', 'wharehouse_id'),
			'tblOrderDetailsTaxes' => array(self::HAS_MANY, 'TblOrderDetailsTaxes', 'order_details_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'order_details_id' => 'Order Details',
			'order_id' => 'Order',
			'product_id' => 'Product',
			'wharehouse_id' => 'Wharehouse',
			'order_details_price' => 'Order Details Price',
			'order_details_discount' => 'Order Details Discount',
			'order_details_quantity' => 'Order Details Quantity',
			'order_details_remarks' => 'Order Details Remarks',
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

		$criteria->compare('order_details_id',$this->order_details_id);
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('wharehouse_id',$this->wharehouse_id);
		$criteria->compare('order_details_price',$this->order_details_price);
		$criteria->compare('order_details_discount',$this->order_details_discount);
		$criteria->compare('order_details_quantity',$this->order_details_quantity);
		$criteria->compare('order_details_remarks',$this->order_details_remarks,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
