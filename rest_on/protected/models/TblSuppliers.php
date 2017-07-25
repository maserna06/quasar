<?php

/**
 * This is the model class for table "tbl_suppliers".
 *
 * The followings are the available columns in table 'tbl_suppliers':
 * @property integer $supplier_nit
 * @property integer $supplier_document_type
 * @property string $supplier_name
 * @property string $contact_name
 * @property string $supplier_email
 * @property string $supplier_phone
 * @property string $supplier_address
 * @property string $supplier_phonenumber
 * @property integer $bank_nit
 * @property integer $price_list_id
 * @property double $supplier_credit_quota
 * @property double $supplier_discount
 * @property integer $supplier_is_simplified_regime
 * @property integer $city_id
 * @property integer $deparment_id
 * @property integer $supplier_status
 *
 * The followings are the available model relations:
 * @property TblOrder[] $tblOrders
 * @property TblPurchases[] $tblPurchases
 * @property TblDepartaments $deparment
 * @property TblCities $city
 * @property TblBanks $bankNit
 * @property TblDocumentType $supplierDocumentType
 * @property TblPriceList $priceList
 * @property TblTaxesSupplier[] $tblTaxesSuppliers
 */
class TblSuppliers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_suppliers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_nit, supplier_document_type, supplier_name, contact_name, supplier_discount, supplier_is_simplified_regime, city_id, deparment_id, supplier_status', 'required'),
			array('supplier_nit, supplier_document_type, bank_nit, price_list_id, supplier_is_simplified_regime, city_id, deparment_id, supplier_status', 'numerical', 'integerOnly'=>true),
			array('supplier_credit_quota, supplier_discount', 'numerical'),
			array('supplier_name, contact_name, supplier_email, supplier_address', 'length', 'max'=>50),
			array('supplier_phone', 'length', 'max'=>30),
			array('supplier_phonenumber', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('supplier_nit, supplier_document_type, supplier_name, contact_name, supplier_email, supplier_phone, supplier_address, supplier_phonenumber, bank_nit, price_list_id, supplier_credit_quota, supplier_discount, supplier_is_simplified_regime, city_id, deparment_id, supplier_status', 'safe', 'on'=>'search'),
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
			'tblOrders' => array(self::HAS_MANY, 'TblOrder', 'supplier_nit'),
			'tblPurchases' => array(self::HAS_MANY, 'TblPurchases', 'supplier_nit'),
			'deparment' => array(self::BELONGS_TO, 'TblDepartaments', 'deparment_id'),
			'city' => array(self::BELONGS_TO, 'TblCities', 'city_id'),
			'bankNit' => array(self::BELONGS_TO, 'TblBanks', 'bank_nit'),
			'supplierDocumentType' => array(self::BELONGS_TO, 'TblDocumentType', 'supplier_document_type'),
			'priceList' => array(self::BELONGS_TO, 'TblPriceList', 'price_list_id'),
			'tblTaxesSuppliers' => array(self::HAS_MANY, 'TblTaxesSupplier', 'supplier_nit'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'supplier_nit' => 'Supplier Nit',
			'supplier_document_type' => 'Supplier Document Type',
			'supplier_name' => 'Supplier Name',
			'contact_name' => 'Contact Name',
			'supplier_email' => 'Supplier Email',
			'supplier_phone' => 'Supplier Phone',
			'supplier_address' => 'Supplier Address',
			'supplier_phonenumber' => 'Supplier Phonenumber',
			'bank_nit' => 'Bank Nit',
			'price_list_id' => 'Price List',
			'supplier_credit_quota' => 'Supplier Credit Quota',
			'supplier_discount' => 'Supplier Discount',
			'supplier_is_simplified_regime' => 'Supplier Is Simplified Regime',
			'city_id' => 'City',
			'deparment_id' => 'Deparment',
			'supplier_status' => 'Supplier Status',
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

		$criteria->compare('supplier_nit',$this->supplier_nit);
		$criteria->compare('supplier_document_type',$this->supplier_document_type);
		$criteria->compare('supplier_name',$this->supplier_name,true);
		$criteria->compare('contact_name',$this->contact_name,true);
		$criteria->compare('supplier_email',$this->supplier_email,true);
		$criteria->compare('supplier_phone',$this->supplier_phone,true);
		$criteria->compare('supplier_address',$this->supplier_address,true);
		$criteria->compare('supplier_phonenumber',$this->supplier_phonenumber,true);
		$criteria->compare('bank_nit',$this->bank_nit);
		$criteria->compare('price_list_id',$this->price_list_id);
		$criteria->compare('supplier_credit_quota',$this->supplier_credit_quota);
		$criteria->compare('supplier_discount',$this->supplier_discount);
		$criteria->compare('supplier_is_simplified_regime',$this->supplier_is_simplified_regime);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('deparment_id',$this->deparment_id);
		$criteria->compare('supplier_status',$this->supplier_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblSuppliers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
