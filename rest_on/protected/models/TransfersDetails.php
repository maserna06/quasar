<?php

/**
 * This is the model class for table "tbl_transfers_details".
 *
 * The followings are the available columns in table 'tbl_transfers_details':
 * @property integer $transfer_details_id
 * @property integer $transfer_id
 * @property integer $product_id
 * @property integer $wharehouse_in
 * @property integer $wharehouse_out
 * @property double $transfer_details_quantity
 * @property string $transfer_details_remarks
 *
 * The followings are the available model relations:
 * @property Transfers $transfer
 * @property Products $product
 * @property Wharehouses $wharehouseIn
 * @property Wharehouses $wharehouseOut
 */
class TransfersDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_transfers_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transfer_id, product_id, wharehouse_in, wharehouse_out, transfer_details_quantity', 'required'),
			array('transfer_id, product_id, wharehouse_in, wharehouse_out', 'numerical', 'integerOnly'=>true),
			array('transfer_details_quantity', 'numerical'),
			array('transfer_details_remarks', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('transfer_details_id, transfer_id, product_id, wharehouse_in, wharehouse_out, transfer_details_quantity, transfer_details_remarks', 'safe', 'on'=>'search'),
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
			'transfer' => array(self::BELONGS_TO, 'Transfers', 'transfer_id'),
			'product' => array(self::BELONGS_TO, 'Products', 'product_id'),
			'wharehouseIn' => array(self::BELONGS_TO, 'Wharehouses', 'wharehouse_in'),
			'wharehouseOut' => array(self::BELONGS_TO, 'Wharehouses', 'wharehouse_out'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'transfer_details_id' => 'Transfer Details',
			'transfer_id' => 'Transfer',
			'product_id' => 'Product',
			'wharehouse_in' => 'Wharehouse In',
			'wharehouse_out' => 'Wharehouse Out',
			'transfer_details_quantity' => 'Transfer Details Quantity',
			'transfer_details_remarks' => 'Transfer Details Remarks',
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

		$criteria->compare('transfer_details_id',$this->transfer_details_id);
		$criteria->compare('transfer_id',$this->transfer_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('wharehouse_in',$this->wharehouse_in);
		$criteria->compare('wharehouse_out',$this->wharehouse_out);
		$criteria->compare('transfer_details_quantity',$this->transfer_details_quantity);
		$criteria->compare('transfer_details_remarks',$this->transfer_details_remarks,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TransfersDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
