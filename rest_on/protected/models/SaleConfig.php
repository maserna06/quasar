<?php

/**
 * This is the model class for table "tbl_sale_config".
 *
 * The followings are the available columns in table 'tbl_sale_config':
 * @property integer $id
 * @property integer $sale_id
 * @property integer $sale_payment
 * @property integer $sale_format
 * @property integer $accounts_id
 * @property integer $wharehouse_id
 *
 * The followings are the available model relations:
 * @property Wharehouses $wharehouse
 * @property Accounts $accounts
 */
class SaleConfig extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_sale_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sale_id, sale_payment, sale_format, accounts_id, wharehouse_id', 'required', 'on'=>'insert,update'),
			array('sale_id, sale_payment, sale_format, wharehouse_id', 'required', 'on'=>'company'),
			array('sale_id, sale_payment, sale_format, accounts_id, wharehouse_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sale_id, sale_payment, sale_format, accounts_id, wharehouse_id', 'safe', 'on'=>'search'),
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
			'wharehouse' => array(self::BELONGS_TO, 'Wharehouses', 'wharehouse_id'),
			'accounts' => array(self::BELONGS_TO, 'Accounts', 'accounts_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sale_id' => 'Sale',
			'sale_payment' => 'Sale Payment',
			'sale_format' => 'Sale Format',
			'accounts_id' => 'Accounts',
			'wharehouse_id' => 'Wharehouse',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('sale_id',$this->sale_id);
		$criteria->compare('sale_payment',$this->sale_payment);
		$criteria->compare('sale_format',$this->sale_format);
		$criteria->compare('accounts_id',$this->accounts_id);
		$criteria->compare('wharehouse_id',$this->wharehouse_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SaleConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
