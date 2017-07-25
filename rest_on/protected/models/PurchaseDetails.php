<?php

/**
 * This is the model class for table "tbl_purchase_details".
 *
 * The followings are the available columns in table 'tbl_purchase_details':
 * @property integer $purchase_details_id
 * @property integer $purchase_id
 * @property integer $product_id
 * @property integer $wharehouse_id
 * @property double $purchase_details_price
 * @property double $purchase_details_quantity
 * @property string $purchase_details_remarks
 *
 * The followings are the available model relations:
 * @property TblWharehouses $wharehouse
 * @property TblPurchases $purchase
 * @property TblProducts $product
 * @property TblPurchaseDetailsTaxes[] $tblPurchaseDetailsTaxes
 */
class PurchaseDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_purchase_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('purchase_id, product_id, wharehouse_id, purchase_details_price, purchase_details_quantity', 'required'),
			array('purchase_id, product_id, wharehouse_id', 'numerical', 'integerOnly'=>true),
			array('purchase_details_price, purchase_details_quantity', 'numerical'),
			array('purchase_details_remarks', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('purchase_details_id, purchase_id, product_id, wharehouse_id, purchase_details_price, purchase_details_quantity, purchase_details_remarks', 'safe', 'on'=>'search'),
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
			'wharehouse' => array(self::BELONGS_TO, 'TblWharehouses', 'wharehouse_id'),
			'purchase' => array(self::BELONGS_TO, 'TblPurchases', 'purchase_id'),
			'product' => array(self::BELONGS_TO, 'TblProducts', 'product_id'),
			'tblPurchaseDetailsTaxes' => array(self::HAS_MANY, 'TblPurchaseDetailsTaxes', 'purchase_details_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'purchase_details_id' => 'Purchase Details',
			'purchase_id' => 'Purchase',
			'product_id' => 'Product',
			'wharehouse_id' => 'Wharehouse',
			'purchase_details_price' => 'Purchase Details Price',
			'purchase_details_quantity' => 'Purchase Details Quantity',
			'purchase_details_remarks' => 'Purchase Details Remarks',
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

		$criteria->compare('purchase_details_id',$this->purchase_details_id);
		$criteria->compare('purchase_id',$this->purchase_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('wharehouse_id',$this->wharehouse_id);
		$criteria->compare('purchase_details_price',$this->purchase_details_price);
		$criteria->compare('purchase_details_quantity',$this->purchase_details_quantity);
		$criteria->compare('purchase_details_remarks',$this->purchase_details_remarks,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PurchaseDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
