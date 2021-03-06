<?php

/**
 * This is the model class for table "tbl_finished_product_details_component".
 *
 * The followings are the available columns in table 'tbl_finished_product_details_component':
 * @property integer $finished_product_details_component_id
 * @property integer $finished_product_details_id
 * @property integer $product_id
 * @property integer $unit_id
 * @property integer $quantity
 *
 * The followings are the available model relations:
 * @property FinishedProductDetails $finishedProductDetails
 * @property Products $product
 * @property Unit $unit
 */
class FinishedProductDetailsComponent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_finished_product_details_component';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('finished_product_details_id, product_id, unit_id, quantity', 'required'),
			array('finished_product_details_id, product_id, unit_id, quantity', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('finished_product_details_component_id, finished_product_details_id, product_id, unit_id, quantity', 'safe', 'on'=>'search'),
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
			'finishedProductDetails' => array(self::BELONGS_TO, 'FinishedProductDetails', 'finished_product_details_id'),
			'product' => array(self::BELONGS_TO, 'Products', 'product_id'),
			'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'finished_product_details_component_id' => 'Finished Product Details Component',
			'finished_product_details_id' => 'Finished Product Details',
			'product_id' => 'Product',
			'unit_id' => 'Unit',
			'quantity' => 'Quantity',
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

		$criteria->compare('finished_product_details_component_id',$this->finished_product_details_component_id);
		$criteria->compare('finished_product_details_id',$this->finished_product_details_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('unit_id',$this->unit_id);
		$criteria->compare('quantity',$this->quantity);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FinishedProductDetailsComponent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
