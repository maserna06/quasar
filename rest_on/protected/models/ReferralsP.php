<?php

/**
 * This is the model class for table "tbl_referralsP".
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
class ReferralsP extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_referralsP';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('referralP_consecut, company_id, customer_nit, user_id, referralP_date, referralP_total, referralP_net_worth, accounts_id, referralP_status', 'required'),
			array('referralP_consecut, request_id, accounts_id, referralP_status', 'numerical', 'integerOnly'=>true),
			array('referralP_total, referralP_net_worth', 'numerical'),
			array('company_id, customer_nit, user_id', 'length', 'max'=>20),
			array('referralP_remarks, payment', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('referralP_id, referralP_consecut, company_id, request_id, customer_nit, user_id, referralP_date, referralP_total, referralP_net_worth, accounts_id, referralP_remarks, referralP_status, payment', 'safe', 'on'=>'search'),
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
			'customerNit' => array(self::BELONGS_TO, 'Suppliers', 'customer_nit'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'accounts' => array(self::BELONGS_TO, 'Accounts', 'accounts_id'),
			'request' => array(self::BELONGS_TO, 'Order', 'request_id'),
			'company' => array(self::BELONGS_TO, 'Companies', 'company_id'),
			'referralsPDetails' => array(self::HAS_MANY, 'ReferralsPDetails', 'referralP_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'referralP_id' => 'ID',
			'referralP_consecut' => 'Consecutivo',
			'company_id' => 'Empresa',
			'request_id' => 'Orden',
			'customer_nit' => 'Proveedor',
			'user_id' => 'Usuario',
			'referralP_date' => 'Fecha',
			'referralP_total' => 'Total',
			'referralP_net_worth' => 'Valor Neto',
			'accounts_id' => 'Cuenta Contable',
			'referralP_remarks' => 'Observaciones',
			'referralP_status' => 'Estado',
			'payment' => 'Medios de Pago',
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

		$criteria->compare('referralP_id',$this->referralP_id);
		$criteria->compare('referralP_consecut',$this->referralP_consecut);
		$criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('request_id',$this->request_id);
		$criteria->compare('customer_nit',$this->customer_nit,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('referralP_date',$this->referralP_date,true);
		$criteria->compare('referralP_total',$this->referralP_total);
		$criteria->compare('referralP_net_worth',$this->referralP_net_worth);
		$criteria->compare('accounts_id',$this->accounts_id);
		$criteria->compare('referralP_remarks',$this->referralP_remarks,true);
		$criteria->compare('referralP_status',$this->referralP_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Referrals the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
