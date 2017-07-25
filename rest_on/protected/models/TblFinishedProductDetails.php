<?php

/**
 * This is the model class for table "tbl_finished_product_details".
 *
 * The followings are the available columns in table 'tbl_finished_product_details':
 * @property integer $finished_product_details_id
 * @property integer $finished_product_id
 * @property integer $product_id
 * @property integer $wharehouse_inserted
 * @property double $finished_product_details_quantity
 * @property string $finished_product_details_remarks
 *
 * The followings are the available model relations:
 * @property FinishedProduct $finishedProduct
 * @property Products $product
 * @property Wharehouses $wharehouseInserted
 */
class TblFinishedProductDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_finished_product_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('finished_product_id, product_id, wharehouse_inserted, finished_product_details_quantity', 'required'),
			array('finished_product_id, product_id, wharehouse_inserted', 'numerical', 'integerOnly'=>true),
			array('finished_product_details_quantity', 'numerical'),
			array('finished_product_details_remarks', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('finished_product_details_id, finished_product_id, product_id, wharehouse_inserted, finished_product_details_quantity, finished_product_details_remarks', 'safe', 'on'=>'search'),
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
			'finishedProduct' => array(self::BELONGS_TO, 'FinishedProduct', 'finished_product_id'),
			'product' => array(self::BELONGS_TO, 'Products', 'product_id'),
			'wharehouseInserted' => array(self::BELONGS_TO, 'Wharehouses', 'wharehouse_inserted'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'finished_product_details_id' => 'Finished Product Details',
			'finished_product_id' => 'Finished Product',
			'product_id' => 'Product',
			'wharehouse_inserted' => 'Wharehouse Inserted',
			'finished_product_details_quantity' => 'Finished Product Details Quantity',
			'finished_product_details_remarks' => 'Finished Product Details Remarks',
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

		$criteria->compare('finished_product_details_id',$this->finished_product_details_id);
		$criteria->compare('finished_product_id',$this->finished_product_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('wharehouse_inserted',$this->wharehouse_inserted);
		$criteria->compare('finished_product_details_quantity',$this->finished_product_details_quantity);
		$criteria->compare('finished_product_details_remarks',$this->finished_product_details_remarks,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblFinishedProductDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
