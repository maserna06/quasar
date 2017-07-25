<?php

/**
 * This is the model class for table "tbl_purchases".
 *
 * The followings are the available columns in table 'tbl_purchases':
 * @property integer $purchase_id
 * @property integer $order_id
 * @property integer $supplier_nit
 * @property integer $user_id
 * @property string $purchase_date
 * @property double $purchase_total
 * @property double $purchase_net_worth
 * @property integer $accounts_id
 * @property string $purchase_remarks
 * @property integer $purchase_status
 *
 * The followings are the available model relations:
 * @property TblPurchaseDetails[] $tblPurchaseDetails
 * @property TblOrder $order
 * @property TblSuppliers $supplierNit
 * @property TblUser $user
 * @property TblAccounts $accounts
 */
class TblPurchases extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_purchases';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_nit, user_id, purchase_date, purchase_total, purchase_net_worth, accounts_id, purchase_status', 'required'),
			array('order_id, supplier_nit, user_id, accounts_id, purchase_status', 'numerical', 'integerOnly'=>true),
			array('purchase_total, purchase_net_worth', 'numerical'),
			array('purchase_remarks', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('purchase_id, order_id, supplier_nit, user_id, purchase_date, purchase_total, purchase_net_worth, accounts_id, purchase_remarks, purchase_status', 'safe', 'on'=>'search'),
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
			'tblPurchaseDetails' => array(self::HAS_MANY, 'TblPurchaseDetails', 'purchase_id'),
			'order' => array(self::BELONGS_TO, 'TblOrder', 'order_id'),
			'supplierNit' => array(self::BELONGS_TO, 'TblSuppliers', 'supplier_nit'),
			'user' => array(self::BELONGS_TO, 'TblUser', 'user_id'),
			'accounts' => array(self::BELONGS_TO, 'TblAccounts', 'accounts_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'purchase_id' => 'Purchase',
			'order_id' => 'Order',
			'supplier_nit' => 'Supplier Nit',
			'user_id' => 'User',
			'purchase_date' => 'Purchase Date',
			'purchase_total' => 'Purchase Total',
			'purchase_net_worth' => 'Purchase Net Worth',
			'accounts_id' => 'Accounts',
			'purchase_remarks' => 'Purchase Remarks',
			'purchase_status' => 'Purchase Status',
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

		$criteria->compare('purchase_id',$this->purchase_id);
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('supplier_nit',$this->supplier_nit);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('purchase_date',$this->purchase_date,true);
		$criteria->compare('purchase_total',$this->purchase_total);
		$criteria->compare('purchase_net_worth',$this->purchase_net_worth);
		$criteria->compare('accounts_id',$this->accounts_id);
		$criteria->compare('purchase_remarks',$this->purchase_remarks,true);
		$criteria->compare('purchase_status',$this->purchase_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblPurchases the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
