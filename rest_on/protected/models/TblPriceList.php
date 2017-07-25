<?php

/**
 * This is the model class for table "tbl_price_list".
 *
 * The followings are the available columns in table 'tbl_price_list':
 * @property integer $price_id
 * @property integer $price_type
 * @property string $price_name
 * @property string $price_description
 * @property integer $price_status
 *
 * The followings are the available model relations:
 * @property TblCustomers[] $tblCustomers
 * @property TblProductList[] $tblProductLists
 * @property TblSuppliers[] $tblSuppliers
 */
class TblPriceList extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_price_list';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('price_type, price_name, price_status', 'required'),
			array('price_type, price_status', 'numerical', 'integerOnly'=>true),
			array('price_name, price_description', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('price_id, price_type, price_name, price_description, price_status', 'safe', 'on'=>'search'),
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
			'tblCustomers' => array(self::HAS_MANY, 'TblCustomers', 'price_list_id'),
			'tblProductLists' => array(self::HAS_MANY, 'TblProductList', 'price_id'),
			'tblSuppliers' => array(self::HAS_MANY, 'TblSuppliers', 'price_list_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'price_id' => 'Price',
			'price_type' => 'Price Type',
			'price_name' => 'Price Name',
			'price_description' => 'Price Description',
			'price_status' => 'Price Status',
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

		$criteria->compare('price_id',$this->price_id);
		$criteria->compare('price_type',$this->price_type);
		$criteria->compare('price_name',$this->price_name,true);
		$criteria->compare('price_description',$this->price_description,true);
		$criteria->compare('price_status',$this->price_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblPriceList the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
