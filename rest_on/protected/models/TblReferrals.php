<?php

/**
 * This is the model class for table "tbl_referrals".
 *
 * The followings are the available columns in table 'tbl_referrals':
 * @property integer $referral_id
 * @property integer $referral_consecut
 * @property string $company_id
 * @property integer $request_id
 * @property string $customer_nit
 * @property string $user_id
 * @property string $referral_date
 * @property double $referral_total
 * @property double $referral_net_worth
 * @property integer $accounts_id
 * @property string $referral_remarks
 * @property integer $referral_status
 *
 * The followings are the available model relations:
 * @property Customers $customerNit
 * @property User $user
 * @property Accounts $accounts
 * @property Requests $request
 * @property Companies $company
 * @property ReferralsDetails[] $referralsDetails
 */
class TblReferrals extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_referrals';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('referral_consecut, company_id, customer_nit, user_id, referral_date, referral_total, referral_net_worth, accounts_id, referral_status', 'required'),
			array('referral_consecut, request_id, accounts_id, referral_status', 'numerical', 'integerOnly'=>true),
			array('referral_total, referral_net_worth', 'numerical'),
			array('company_id, customer_nit, user_id', 'length', 'max'=>20),
			array('referral_remarks', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('referral_id, referral_consecut, company_id, request_id, customer_nit, user_id, referral_date, referral_total, referral_net_worth, accounts_id, referral_remarks, referral_status', 'safe', 'on'=>'search'),
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
			'customerNit' => array(self::BELONGS_TO, 'Customers', 'customer_nit'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'accounts' => array(self::BELONGS_TO, 'Accounts', 'accounts_id'),
			'request' => array(self::BELONGS_TO, 'Requests', 'request_id'),
			'company' => array(self::BELONGS_TO, 'Companies', 'company_id'),
			'referralsDetails' => array(self::HAS_MANY, 'ReferralsDetails', 'referral_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'referral_id' => 'Referral',
			'referral_consecut' => 'Referral Consecut',
			'company_id' => 'Company',
			'request_id' => 'Request',
			'customer_nit' => 'Customer Nit',
			'user_id' => 'User',
			'referral_date' => 'Referral Date',
			'referral_total' => 'Referral Total',
			'referral_net_worth' => 'Referral Net Worth',
			'accounts_id' => 'Accounts',
			'referral_remarks' => 'Referral Remarks',
			'referral_status' => 'Referral Status',
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

		$criteria->compare('referral_id',$this->referral_id);
		$criteria->compare('referral_consecut',$this->referral_consecut);
		$criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('request_id',$this->request_id);
		$criteria->compare('customer_nit',$this->customer_nit,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('referral_date',$this->referral_date,true);
		$criteria->compare('referral_total',$this->referral_total);
		$criteria->compare('referral_net_worth',$this->referral_net_worth);
		$criteria->compare('accounts_id',$this->accounts_id);
		$criteria->compare('referral_remarks',$this->referral_remarks,true);
		$criteria->compare('referral_status',$this->referral_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblReferrals the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
