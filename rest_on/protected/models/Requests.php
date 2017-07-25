<?php

/**
 * This is the model class for table "tbl_requests".
 *
 * The followings are the available columns in table 'tbl_requests':
 * @property integer $request_id
 * @property integer $request_consecut
 * @property string $company_id
 * @property string $customer_nit
 * @property string $user_id
 * @property string $request_date
 * @property double $request_total
 * @property double $request_net_worth
 * @property integer $accounts_id
 * @property string $request_remarks
 * @property integer $request_status
 *
 * The followings are the available model relations:
 * @property Referrals[] $referrals
 * @property Customers $customerNit
 * @property User $user
 * @property Accounts $accounts
 * @property Companies $company
 * @property RequestsDetails[] $requestsDetails
 * @property Sales[] $sales
 */
class Requests extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_requests';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('request_consecut, company_id, customer_nit, user_id, request_date, request_total, request_net_worth, accounts_id, request_status', 'required'),
			array('request_consecut, accounts_id, request_status', 'numerical', 'integerOnly'=>true),
			array('request_total, request_net_worth', 'numerical'),
			array('company_id, customer_nit, user_id', 'length', 'max'=>20),
			array('request_remarks', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('request_id, request_consecut, company_id, customer_nit, user_id, request_date, request_total, request_net_worth, accounts_id, request_remarks, request_status', 'safe', 'on'=>'search'),
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
			'referrals' => array(self::HAS_MANY, 'Referrals', 'request_id'),
			'customerNit' => array(self::BELONGS_TO, 'Customers', 'customer_nit'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'accounts' => array(self::BELONGS_TO, 'Accounts', 'accounts_id'),
			'company' => array(self::BELONGS_TO, 'Companies', 'company_id'),
			'requestsDetails' => array(self::HAS_MANY, 'RequestsDetails', 'request_id'),
			'sales' => array(self::HAS_MANY, 'Sales', 'request_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'request_id' => 'ID',
			'request_consecut' => 'Consecutivo',
			'company_id' => 'Empresa',
			'customer_nit' => 'Cliente',
			'user_id' => 'Usuario',
			'request_date' => 'Fecha',
			'request_total' => 'Total',
			'request_net_worth' => 'Valor Neto',
			'accounts_id' => 'Cuenta Contable',
			'request_remarks' => 'Observaciones',
			'request_status' => 'Estado',
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

		$criteria->compare('request_id',$this->request_id);
		$criteria->compare('request_consecut',$this->request_consecut);
		$criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('customer_nit',$this->customer_nit,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('request_date',$this->request_date,true);
		$criteria->compare('request_total',$this->request_total);
		$criteria->compare('request_net_worth',$this->request_net_worth);
		$criteria->compare('accounts_id',$this->accounts_id);
		$criteria->compare('request_remarks',$this->request_remarks,true);
		$criteria->compare('request_status',$this->request_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Requests the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
