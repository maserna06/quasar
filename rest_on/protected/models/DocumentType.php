<?php

/**
 * This is the model class for table "tbl_document_type".
 *
 * The followings are the available columns in table 'tbl_document_type':
 * @property integer $type_id
 * @property string $type_name
 * @property integer $type_status
 *
 * The followings are the available model relations:
 * @property TblCustomers[] $tblCustomers
 * @property TblSuppliers[] $tblSuppliers
 */
class DocumentType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_document_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_name, type_status', 'required'),
			array('type_status', 'numerical', 'integerOnly'=>true),
			array('type_name', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('type_id, type_name, type_status', 'safe', 'on'=>'search'),
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
			'tblCustomers' => array(self::HAS_MANY, 'TblCustomers', 'customer_document_type'),
			'tblSuppliers' => array(self::HAS_MANY, 'TblSuppliers', 'supplier_document_type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'type_id' => 'Type',
			'type_name' => 'Type Name',
			'type_status' => 'Type Status',
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
		$criteria->addCondition('t.type_status in (0,1)');
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('type_name',$this->type_name,true);
		$criteria->compare('type_status',$this->type_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DocumentType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
