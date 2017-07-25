<?php

/**
 * This is the model class for table "tbl_departaments".
 *
 * The followings are the available columns in table 'tbl_departaments':
 * @property integer $deparment_id
 * @property string $deparment_cod
 * @property string $deparment_name
 * @property integer $deparment_state
 *
 * The followings are the available model relations:
 * @property TblCities[] $tblCities
 * @property TblCompanies[] $tblCompanies
 * @property TblUser[] $tblUsers
 */
class Departaments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_departaments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('deparment_cod, deparment_name, deparment_state', 'required'),
			array('deparment_cod', 'unique'),
			array('deparment_state', 'numerical', 'integerOnly'=>true),
			array('deparment_cod', 'length', 'max'=>10),
			array('deparment_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('deparment_id, deparment_cod, deparment_name, deparment_state', 'safe', 'on'=>'search'),
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
			'tblCities' => array(self::HAS_MANY, 'TblCities', 'deparment_cod'),
			'tblCompanies' => array(self::HAS_MANY, 'TblCompanies', 'deparment_id'),
			'tblUsers' => array(self::HAS_MANY, 'TblUser', 'deparment_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'deparment_id' => 'ID',
			'deparment_cod' => 'Codigo DANE',
			'deparment_name' => 'Departamento',
			'deparment_state' => 'Estado',
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
		$criteria->addCondition('t.deparment_state in (0,1)');
		$criteria->compare('deparment_id',$this->deparment_id);
		$criteria->compare('deparment_cod',$this->deparment_cod,true);
		$criteria->compare('deparment_name',$this->deparment_name,true);
		$criteria->compare('deparment_state',$this->deparment_state);

		$criteria->order= 'deparment_name ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Departaments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
