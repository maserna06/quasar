<?php

/**
 * This is the model class for table "tbl_requests_details".
 *
 * The followings are the available columns in table 'tbl_requests_details':
 * @property integer $request_details_id
 * @property integer $request_id
 * @property integer $product_id
 * @property integer $wharehouse_id
 * @property double $request_details_price
 * @property double $request_details_discount
 * @property double $request_details_quantity
 * @property string $request_details_remarks
 *
 * The followings are the available model relations:
 * @property Requests $request
 * @property Products $product
 * @property Wharehouses $wharehouse
 * @property RequestsDetailsComponent[] $requestsDetailsComponents
 * @property RequestsDetailsTaxes[] $requestsDetailsTaxes
 */
class TblRequestsDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_requests_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('request_id, product_id, wharehouse_id, request_details_price, request_details_discount, request_details_quantity', 'required'),
			array('request_id, product_id, wharehouse_id', 'numerical', 'integerOnly'=>true),
			array('request_details_price, request_details_discount, request_details_quantity', 'numerical'),
			array('request_details_remarks', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('request_details_id, request_id, product_id, wharehouse_id, request_details_price, request_details_discount, request_details_quantity, request_details_remarks', 'safe', 'on'=>'search'),
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
			'request' => array(self::BELONGS_TO, 'Requests', 'request_id'),
			'product' => array(self::BELONGS_TO, 'Products', 'product_id'),
			'wharehouse' => array(self::BELONGS_TO, 'Wharehouses', 'wharehouse_id'),
			'requestsDetailsComponents' => array(self::HAS_MANY, 'RequestsDetailsComponent', 'requests_details_id'),
			'requestsDetailsTaxes' => array(self::HAS_MANY, 'RequestsDetailsTaxes', 'request_details_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'request_details_id' => 'Request Details',
			'request_id' => 'Request',
			'product_id' => 'Product',
			'wharehouse_id' => 'Wharehouse',
			'request_details_price' => 'Request Details Price',
			'request_details_discount' => 'Request Details Discount',
			'request_details_quantity' => 'Request Details Quantity',
			'request_details_remarks' => 'Request Details Remarks',
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

		$criteria->compare('request_details_id',$this->request_details_id);
		$criteria->compare('request_id',$this->request_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('wharehouse_id',$this->wharehouse_id);
		$criteria->compare('request_details_price',$this->request_details_price);
		$criteria->compare('request_details_discount',$this->request_details_discount);
		$criteria->compare('request_details_quantity',$this->request_details_quantity);
		$criteria->compare('request_details_remarks',$this->request_details_remarks,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblRequestsDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
