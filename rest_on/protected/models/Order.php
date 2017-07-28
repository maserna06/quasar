<?php

/**
 * This is the model class for table "tbl_order".
 *
 * The followings are the available columns in table 'tbl_order':
 * @property integer $order_id
 * @property integer $supplier_nit
 * @property integer $user_id
 * @property string $order_date
 * @property double $order_total
 * @property double $order_net_worth
 * @property integer $accounts_id
 * @property string $order_remarks
 * @property integer $order_status
 *
 * The followings are the available model relations:
 * @property TblSuppliers $supplierNit
 * @property TblUser $user
 * @property TblAccounts $accounts
 * @property TblOrderDetails[] $tblOrderDetails
 * @property TblPurchases[] $tblPurchases
 */
class Order extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_nit, user_id, order_date, order_total, order_net_worth, accounts_id, order_status', 'required'),
			array('supplier_nit, user_id, accounts_id, order_status', 'numerical', 'integerOnly'=>true),
			array('order_total, order_net_worth', 'numerical'),
			array('order_remarks', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('order_id, supplier_nit, user_id, order_date, order_total, order_net_worth, accounts_id, order_remarks, order_status', 'safe', 'on'=>'search'),
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
			'supplierNit' => array(self::BELONGS_TO, 'Suppliers', 'supplier_nit'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'accounts' => array(self::BELONGS_TO, 'Accounts', 'accounts_id'),
			'OrderDetails' => array(self::HAS_MANY, 'OrderDetails', 'order_id'),
			'Purchases' => array(self::HAS_MANY, 'Purchases', 'order_id'),
			'ReferralsP' => array(self::HAS_MANY, 'ReferralsP', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'order_id' => 'ID',
			'supplier_nit' => 'Proveedor',
			'user_id' => 'Usuario',
			'order_date' => 'Fecha Venta',
			'order_total' => 'Total',
			'order_net_worth' => 'Valor Neto',
			'accounts_id' => 'Cuenta',
			'order_remarks' => 'Observaciones',
			'order_status' => 'Estado',
			'order_consecut' => 'Consecutivo',
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
		$criteria->addCondition('t.order_status <> 3');
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('supplier_nit',$this->supplier_nit);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('order_date',$this->order_date,true);
		$criteria->compare('order_total',$this->order_total);
		$criteria->compare('order_net_worth',$this->order_net_worth);
		$criteria->compare('accounts_id',$this->accounts_id);
		$criteria->compare('order_remarks',$this->order_remarks,true);
		$criteria->compare('order_status',$this->order_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Order the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
