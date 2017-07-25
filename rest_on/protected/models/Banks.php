<?php

/**
 * This is the model class for table "tbl_banks".
 *
 * The followings are the available columns in table 'tbl_banks':
 * @property integer $bank_nit
 * @property string $bank_name
 * @property string $bank_address
 * @property string $bank_phone
 * @property string $bank_description
 * @property integer $bank_status
 *
 * The followings are the available model relations:
 * @property TblCustomers[] $tblCustomers
 */
class Banks extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_banks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bank_nit, bank_name, bank_status', 'required'),
			array('bank_nit, bank_name', 'unique'),
			array('bank_nit', 'numerical', 'integerOnly'=>true,'message'=>'Ingrese NIT sin digito de verificacion o guion medio ( - ).'),
			array('bank_nit', 'length', 'max'=>20),
			array('bank_status', 'numerical', 'integerOnly'=>true),
			array('bank_name, bank_address', 'length', 'max'=>50),
			array('bank_phone', 'length', 'max'=>30),
			array('bank_description', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('bank_nit, bank_name, bank_address, bank_phone, bank_description, bank_status', 'safe', 'on'=>'search'),
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
			'tblCustomers' => array(self::HAS_MANY, 'TblCustomers', 'bank_nit'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bank_nit' => 'Nit',
			'bank_name' => 'Nombre Banco',
			'bank_address' => 'Direccion',
			'bank_phone' => 'Telefono',
			'bank_description' => 'Descripcion',
			'bank_status' => 'Estado',
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
		$criteria->addCondition('t.bank_status in (0,1)');
		$criteria->compare('bank_nit',$this->bank_nit);
		$criteria->compare('bank_name',$this->bank_name,true);
		$criteria->compare('bank_address',$this->bank_address,true);
		$criteria->compare('bank_phone',$this->bank_phone,true);
		$criteria->compare('bank_description',$this->bank_description,true);
		$criteria->compare('bank_status',$this->bank_status);

		$criteria->order= 'bank_name ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Banks the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
