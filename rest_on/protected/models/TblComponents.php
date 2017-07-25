<?php

/**
 * This is the model class for table "tbl_components".
 *
 * The followings are the available columns in table 'tbl_components':
 * @property integer $component_id
 * @property integer $base_product_id
 * @property integer $product_id
 * @property integer $unit_id
 * @property double $component_amounts
 *
 * The followings are the available model relations:
 * @property TblProducts $baseProduct
 * @property TblProducts $product
 * @property TblUnit $unit
 */
class TblComponents extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_components';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('base_product_id, product_id, unit_id, component_amounts', 'required'),
			array('base_product_id, product_id, unit_id', 'numerical', 'integerOnly'=>true),
			array('component_amounts', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('component_id, base_product_id, product_id, unit_id, component_amounts', 'safe', 'on'=>'search'),
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
			'baseProduct' => array(self::BELONGS_TO, 'TblProducts', 'base_product_id'),
			'product' => array(self::BELONGS_TO, 'TblProducts', 'product_id'),
			'unit' => array(self::BELONGS_TO, 'TblUnit', 'unit_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'component_id' => 'Component',
			'base_product_id' => 'Base Product',
			'product_id' => 'Product',
			'unit_id' => 'Unit',
			'component_amounts' => 'Component Amounts',
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

		$criteria->compare('component_id',$this->component_id);
		$criteria->compare('base_product_id',$this->base_product_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('unit_id',$this->unit_id);
		$criteria->compare('component_amounts',$this->component_amounts);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblComponents the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
