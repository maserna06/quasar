<?php

/**
 * This is the model class for table "tbl_inventories".
 *
 * The followings are the available columns in table 'tbl_inventories':
 * @property integer $inventory_id
 * @property integer $wharehouse_id
 * @property integer $product_id
 * @property string $inventory_year
 * @property string $inventory_month
 * @property integer $inventory_unit
 * @property double $inventory_stock
 * @property string $inventory_movement_type
 * @property integer $inventory_document_number
 * @property double $inventory_amounts
 * @property integer $inventory_status
 *
 * The followings are the available model relations:
 * @property TblWharehouses $wharehouse
 * @property TblProducts $product
 * @property TblUnit $inventoryUnit
 */
class Inventories extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_inventories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wharehouse_id, product_id, inventory_year, inventory_month, inventory_unit, inventory_stock, inventory_movement_type, inventory_document_number, inventory_amounts, inventory_status', 'required'),
			array('wharehouse_id, product_id, inventory_unit, inventory_document_number, inventory_status', 'numerical', 'integerOnly'=>true),
			array('inventory_stock, inventory_amounts', 'numerical'),
			array('inventory_year', 'length', 'max'=>4),
			array('inventory_month', 'length', 'max'=>2),
			array('inventory_movement_type', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('inventory_id, wharehouse_id, product_id, inventory_year, inventory_month, inventory_unit, inventory_stock, inventory_movement_type, inventory_document_number, inventory_amounts, inventory_status', 'safe', 'on'=>'search'),
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
			'wharehouse' => array(self::BELONGS_TO, 'TblWharehouses', 'wharehouse_id'),
			'product' => array(self::BELONGS_TO, 'TblProducts', 'product_id'),
			'inventoryUnit' => array(self::BELONGS_TO, 'TblUnit', 'inventory_unit'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'inventory_id' => 'ID',
			'wharehouse_id' => 'Bodega',
			'product_id' => 'Producto',
			'inventory_year' => 'Año',
			'inventory_month' => 'Mes',
			'inventory_unit' => 'Unidad',
			'inventory_stock' => 'Stock',
			'inventory_movement_type' => 'Tipo de Movimiento',
			'inventory_document_number' => 'Numero de Documento',
			'inventory_amounts' => 'Cuenta',
			'inventory_status' => 'Estado',
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

		$criteria->compare('inventory_id',$this->inventory_id);
		$criteria->compare('wharehouse_id',$this->wharehouse_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('inventory_year',$this->inventory_year,true);
		$criteria->compare('inventory_month',$this->inventory_month,true);
		$criteria->compare('inventory_unit',$this->inventory_unit);
		$criteria->compare('inventory_stock',$this->inventory_stock);
		$criteria->compare('inventory_movement_type',$this->inventory_movement_type,true);
		$criteria->compare('inventory_document_number',$this->inventory_document_number);
		$criteria->compare('inventory_amounts',$this->inventory_amounts);
		$criteria->compare('inventory_status',$this->inventory_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Inventories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
