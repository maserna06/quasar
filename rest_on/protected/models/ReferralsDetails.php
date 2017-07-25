<?php

/**
 * This is the model class for table "tbl_referrals_details".
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
class ReferralsDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_referrals_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('referral_id, product_id, wharehouse_id, referral_details_price, referral_details_discount, referral_details_quantity', 'required'),
			array('referral_id, product_id, wharehouse_id', 'numerical', 'integerOnly'=>true),
			array('referral_details_price, referral_details_discount, referral_details_quantity', 'numerical'),
			array('referral_details_remarks', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('referral_details_id, referral_id, product_id, wharehouse_id, referral_details_price, referral_details_discount, referral_details_quantity, referral_details_remarks', 'safe', 'on'=>'search'),
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
			'referral' => array(self::BELONGS_TO, 'Referrals', 'referral_id'),
			'product' => array(self::BELONGS_TO, 'Products', 'product_id'),
			'wharehouse' => array(self::BELONGS_TO, 'Wharehouses', 'wharehouse_id'),
			'referralsDetailsComponents' => array(self::HAS_MANY, 'ReferralsDetailsComponent', 'referrals_details_id'),
			'referralsDetailsTaxes' => array(self::HAS_MANY, 'ReferralsDetailsTaxes', 'referral_details_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'referral_details_id' => 'Referral Details',
			'referral_id' => 'Referral',
			'product_id' => 'Product',
			'wharehouse_id' => 'Wharehouse',
			'referral_details_price' => 'Referral Details Price',
			'referral_details_discount' => 'Referral Details Discount',
			'referral_details_quantity' => 'Referral Details Quantity',
			'referral_details_remarks' => 'Referral Details Remarks',
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

		$criteria->compare('referral_details_id',$this->referral_details_id);
		$criteria->compare('referral_id',$this->referral_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('wharehouse_id',$this->wharehouse_id);
		$criteria->compare('referral_details_price',$this->referral_details_price);
		$criteria->compare('referral_details_discount',$this->referral_details_discount);
		$criteria->compare('referral_details_quantity',$this->referral_details_quantity);
		$criteria->compare('referral_details_remarks',$this->referral_details_remarks,true);

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
