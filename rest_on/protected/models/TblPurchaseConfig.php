<?php

/**
 * This is the model class for table "tbl_purchase_config".
 *
 * The followings are the available columns in table 'tbl_purchase_config':
 * @property integer $id
 * @property integer $purchase_id
 * @property integer $purchase_payment
 * @property integer $purchase_format
 * @property integer $accounts_id
 * @property integer $wharehouse_id
 */
class TblPurchaseConfig extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_purchase_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('purchase_id, purchase_payment, purchase_format, accounts_id, wharehouse_id', 'required'),
			array('purchase_id, purchase_payment, purchase_format, accounts_id, wharehouse_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, purchase_id, purchase_payment, purchase_format, accounts_id, wharehouse_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'purchase_id' => 'Purchase',
			'purchase_payment' => 'Purchase Payment',
			'purchase_format' => 'Purchase Format',
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
		$criteria->compare('purchase_id',$this->purchase_id);
		$criteria->compare('purchase_payment',$this->purchase_payment);
		$criteria->compare('purchase_format',$this->purchase_format);
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
	 * @return TblPurchaseConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
