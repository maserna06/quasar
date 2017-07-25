<?php

/**
 * This is the model class for table "tbl_sales".
 *
 * The followings are the available columns in table 'tbl_sales':
 * @property integer $sale_id
 * @property integer $sale_consecut
 * @property string $company_id
 * @property integer $request_id
 * @property string $customer_nit
 * @property string $user_id
 * @property string $sale_date
 * @property double $sale_total
 * @property double $sale_net_worth
 * @property integer $accounts_id
 * @property string $sale_remarks
 * @property integer $sale_status
 *
 * The followings are the available model relations:
 * @property Customers $customerNit
 * @property User $user
 * @property Accounts $accounts
 * @property Requests $request
 * @property Companies $company
 * @property SalesDetails[] $salesDetails
 */
class Sales extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_sales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sale_consecut, company_id, customer_nit, user_id, sale_date, sale_total, sale_net_worth, accounts_id, sale_status', 'required'),
			array('sale_consecut, request_id, accounts_id, sale_status', 'numerical', 'integerOnly'=>true),
			array('sale_total, sale_net_worth', 'numerical'),
			array('company_id, customer_nit, user_id', 'length', 'max'=>20),
			array('sale_remarks, payment', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sale_id, sale_consecut, company_id, request_id, customer_nit, user_id, sale_date, sale_total, sale_net_worth, accounts_id, sale_remarks, sale_status, payment', 'safe', 'on'=>'search'),
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
			'salesDetails' => array(self::HAS_MANY, 'SalesDetails', 'sale_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sale_id' => 'ID',
			'sale_consecut' => 'Consecutivo',
			'company_id' => 'Empresa',
			'request_id' => 'Pedido',
			'customer_nit' => 'Cliente',
			'user_id' => 'Usuario',
			'sale_date' => 'Fecha',
			'sale_total' => 'Total',
			'sale_net_worth' => 'Valor Neto',
			'accounts_id' => 'Cuenta Contable',
			'sale_remarks' => 'Observaciones',
			'sale_status' => 'Estado',
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

		$criteria->compare('sale_id',$this->sale_id);
		$criteria->compare('sale_consecut',$this->sale_consecut);
		$criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('request_id',$this->request_id);
		$criteria->compare('customer_nit',$this->customer_nit,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('sale_date',$this->sale_date,true);
		$criteria->compare('sale_total',$this->sale_total);
		$criteria->compare('sale_net_worth',$this->sale_net_worth);
		$criteria->compare('accounts_id',$this->accounts_id);
		$criteria->compare('sale_remarks',$this->sale_remarks,true);
		$criteria->compare('sale_status',$this->sale_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sales the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
