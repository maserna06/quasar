<?php

/**
 * This is the model class for table "tbl_customers".
 *
 * The followings are the available columns in table 'tbl_customers':
 * @property integer $customer_nit
 * @property integer $customer_document_type
 * @property string $customer_firtsname
 * @property string $customer_lastname
 * @property string $customer_email
 * @property string $customer_phone
 * @property string $customer_address
 * @property string $customer_phonenumber
 * @property integer $bank_nit
 * @property integer $price_list_id
 * @property double $customer_credit_quota
 * @property double $customer_discount
 * @property integer $city_id
 * @property integer $deparment_id
 * @property integer $customer_status
 *
 * The followings are the available model relations:
 * @property TblDepartaments $deparment
 * @property TblCities $city
 * @property TblBanks $bankNit
 * @property TblDocumentType $customerDocumentType
 * @property TblPriceList $priceList
 * @property TblTaxesCustomer[] $tblTaxesCustomers
 */
class TblCustomers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_customers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_nit, customer_document_type, customer_firtsname, customer_discount, city_id, deparment_id, customer_status', 'required'),
			array('customer_nit, customer_document_type, bank_nit, price_list_id, city_id, deparment_id, customer_status', 'numerical', 'integerOnly'=>true),
			array('customer_credit_quota, customer_discount', 'numerical'),
			array('customer_firtsname, customer_lastname, customer_email, customer_address', 'length', 'max'=>50),
			array('customer_phone', 'length', 'max'=>30),
			array('customer_phonenumber', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('customer_nit, customer_document_type, customer_firtsname, customer_lastname, customer_email, customer_phone, customer_address, customer_phonenumber, bank_nit, price_list_id, customer_credit_quota, customer_discount, city_id, deparment_id, customer_status', 'safe', 'on'=>'search'),
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
			'deparment' => array(self::BELONGS_TO, 'TblDepartaments', 'deparment_id'),
			'city' => array(self::BELONGS_TO, 'TblCities', 'city_id'),
			'bankNit' => array(self::BELONGS_TO, 'TblBanks', 'bank_nit'),
			'customerDocumentType' => array(self::BELONGS_TO, 'TblDocumentType', 'customer_document_type'),
			'priceList' => array(self::BELONGS_TO, 'TblPriceList', 'price_list_id'),
			'tblTaxesCustomers' => array(self::HAS_MANY, 'TblTaxesCustomer', 'customer_nit'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'customer_nit' => 'Customer Nit',
			'customer_document_type' => 'Customer Document Type',
			'customer_firtsname' => 'Customer Firtsname',
			'customer_lastname' => 'Customer Lastname',
			'customer_email' => 'Customer Email',
			'customer_phone' => 'Customer Phone',
			'customer_address' => 'Customer Address',
			'customer_phonenumber' => 'Customer Phonenumber',
			'bank_nit' => 'Bank Nit',
			'price_list_id' => 'Price List',
			'customer_credit_quota' => 'Customer Credit Quota',
			'customer_discount' => 'Customer Discount',
			'city_id' => 'City',
			'deparment_id' => 'Deparment',
			'customer_status' => 'Customer Status',
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

		$criteria->compare('customer_nit',$this->customer_nit);
		$criteria->compare('customer_document_type',$this->customer_document_type);
		$criteria->compare('customer_firtsname',$this->customer_firtsname,true);
		$criteria->compare('customer_lastname',$this->customer_lastname,true);
		$criteria->compare('customer_email',$this->customer_email,true);
		$criteria->compare('customer_phone',$this->customer_phone,true);
		$criteria->compare('customer_address',$this->customer_address,true);
		$criteria->compare('customer_phonenumber',$this->customer_phonenumber,true);
		$criteria->compare('bank_nit',$this->bank_nit);
		$criteria->compare('price_list_id',$this->price_list_id);
		$criteria->compare('customer_credit_quota',$this->customer_credit_quota);
		$criteria->compare('customer_discount',$this->customer_discount);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('deparment_id',$this->deparment_id);
		$criteria->compare('customer_status',$this->customer_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblCustomers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
