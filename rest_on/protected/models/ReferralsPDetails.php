<?php

/**
 * This is the model class for table "tbl_referralsP_details".
 *
 * The followings are the available columns in table 'tbl_referrals_details':
 * @property integer $referral_details_id
 * @property integer $referral_id
 * @property integer $product_id
 * @property integer $wharehouse_id
 * @property double $referral_details_price
 * @property double $referral_details_discount
 * @property double $referral_details_quantity
 * @property string $referral_details_remarks
 *
 * The followings are the available model relations:
 * @property Referrals $referral
 * @property Products $product
 * @property Wharehouses $wharehouse
 * @property ReferralsDetailsComponent[] $referralsDetailsComponents
 * @property ReferralsDetailsTaxes[] $referralsDetailsTaxes
 */
class ReferralsPDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_referralsP_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('referralP_id, product_id, wharehouse_id, referralP_details_price, referralP_details_discount, referralP_details_quantity', 'required'),
			array('referralP_id, product_id, wharehouse_id', 'numerical', 'integerOnly'=>true),
			array('referralP_details_price, referralP_details_discount, referralP_details_quantity', 'numerical'),
			array('referralP_details_remarks', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('referralP_details_id, referralP_id, product_id, wharehouse_id, referralP_details_price, referralP_details_discount, referralP_details_quantity, referralP_details_remarks', 'safe', 'on'=>'search'),
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
			'referralP' => array(self::BELONGS_TO, 'ReferralsP', 'referralP_id'),
			'product' => array(self::BELONGS_TO, 'Products', 'product_id'),
			'wharehouse' => array(self::BELONGS_TO, 'Wharehouses', 'wharehouse_id'),
			'referralsPDetailsComponents' => array(self::HAS_MANY, 'ReferralsPDetailsComponent', 'referralsP_details_id'),
			'referralsPDetailsTaxes' => array(self::HAS_MANY, 'ReferralsPDetailsTaxes', 'referralP_details_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'referralP_details_id' => 'ReferralP Details',
			'referralP_id' => 'ReferralP',
			'product_id' => 'Product',
			'wharehouse_id' => 'Wharehouse',
			'referralP_details_price' => 'ReferralP Details Price',
			'referralP_details_discount' => 'ReferralP Details Discount',
			'referralP_details_quantity' => 'ReferralP Details Quantity',
			'referralP_details_remarks' => 'Referral Details Remarks',
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

		$criteria->compare('referralP_details_id',$this->referralP_details_id);
		$criteria->compare('referralP_id',$this->referralP_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('wharehouse_id',$this->wharehouse_id);
		$criteria->compare('referralP_details_price',$this->referralP_details_price);
		$criteria->compare('referralP_details_discount',$this->referralP_details_discount);
		$criteria->compare('referralP_details_quantity',$this->referralP_details_quantity);
		$criteria->compare('referralP_details_remarks',$this->referralP_details_remarks,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReferralsDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
