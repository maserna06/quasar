<?php

/**
 * This is the model class for table "tbl_products".
 *
 * The followings are the available columns in table 'tbl_products':
 * @property integer $product_id
 * @property string $company_id
 * @property string $product_description
 * @property string $product_barCode
 * @property integer $category_id
 * @property double $product_iva
 * @property double $product_price
 * @property integer $unit_id
 * @property double $product_min_stock
 * @property double $product_max_stock
 * @property integer $product_inventory_max_days
 * @property string $product_image
 * @property integer $product_iscomponent
 * @property integer $product_enable
 * @property string $product_remarks
 * @property integer $product_status
 *
 * The followings are the available model relations:
 * @property TblComponents[] $tblComponents
 * @property TblInventories[] $tblInventories
 * @property TblProductList[] $tblProductLists
 * @property TblCategories $category
 * @property TblCompanies $company
 * @property TblUnit $unit
 * @property TblTaxProduct[] $tblTaxProducts
 */
class TblProducts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, product_description, category_id, product_price, unit_id, product_enable, product_status', 'required'),
			array('category_id, unit_id, product_inventory_max_days, product_iscomponent, product_enable, product_status', 'numerical', 'integerOnly'=>true),
			array('product_iva, product_price, product_min_stock, product_max_stock', 'numerical'),
			array('company_id', 'length', 'max'=>20),
			array('product_description, product_image', 'length', 'max'=>50),
			array('product_barCode', 'length', 'max'=>12),
			array('product_remarks', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('product_id, company_id, product_description, product_barCode, category_id, product_iva, product_price, unit_id, product_min_stock, product_max_stock, product_inventory_max_days, product_image, product_iscomponent, product_enable, product_remarks, product_status', 'safe', 'on'=>'search'),
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
			'tblComponents' => array(self::HAS_MANY, 'TblComponents', 'product_id'),
			'tblInventories' => array(self::HAS_MANY, 'TblInventories', 'product_id'),
			'tblProductLists' => array(self::HAS_MANY, 'TblProductList', 'product_id'),
			'category' => array(self::BELONGS_TO, 'TblCategories', 'category_id'),
			'company' => array(self::BELONGS_TO, 'TblCompanies', 'company_id'),
			'unit' => array(self::BELONGS_TO, 'TblUnit', 'unit_id'),
			'tblTaxProducts' => array(self::HAS_MANY, 'TblTaxProduct', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'product_id' => 'Product',
			'company_id' => 'Company',
			'product_description' => 'Product Description',
			'product_barCode' => 'Product Bar Code',
			'category_id' => 'Category',
			'product_iva' => 'Product Iva',
			'product_price' => 'Product Price',
			'unit_id' => 'Unit',
			'product_min_stock' => 'Product Min Stock',
			'product_max_stock' => 'Product Max Stock',
			'product_inventory_max_days' => 'Product Inventory Max Days',
			'product_image' => 'Product Image',
			'product_iscomponent' => 'Product Iscomponent',
			'product_enable' => 'Product Enable',
			'product_remarks' => 'Product Remarks',
			'product_status' => 'Product Status',
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

		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('product_description',$this->product_description,true);
		$criteria->compare('product_barCode',$this->product_barCode,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('product_iva',$this->product_iva);
		$criteria->compare('product_price',$this->product_price);
		$criteria->compare('unit_id',$this->unit_id);
		$criteria->compare('product_min_stock',$this->product_min_stock);
		$criteria->compare('product_max_stock',$this->product_max_stock);
		$criteria->compare('product_inventory_max_days',$this->product_inventory_max_days);
		$criteria->compare('product_image',$this->product_image,true);
		$criteria->compare('product_iscomponent',$this->product_iscomponent);
		$criteria->compare('product_enable',$this->product_enable);
		$criteria->compare('product_remarks',$this->product_remarks,true);
		$criteria->compare('product_status',$this->product_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblProducts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
