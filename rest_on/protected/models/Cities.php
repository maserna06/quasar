<?php

/**
 * This is the model class for table "tbl_cities".
 *
 * The followings are the available columns in table 'tbl_cities':
 * @property integer $city_id
 * @property string $city_cod
 * @property string $city_name
 * @property string $deparment_cod
 * @property integer $city_state
 *
 * The followings are the available model relations:
 * @property TblDepartaments $deparmentCod
 * @property TblCompanies[] $tblCompanies
 * @property TblUser[] $tblUsers
 */
class Cities extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_cities';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_cod, city_name, deparment_cod, city_state', 'required'),
			array('city_cod', 'unique'),
			array('city_state', 'numerical', 'integerOnly'=>true),
			array('city_cod, deparment_cod', 'length', 'max'=>10),
			array('city_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('city_id, city_cod, city_name, deparment_cod, city_state', 'safe', 'on'=>'search'),
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
			'deparmentCod' => array(self::BELONGS_TO, 'Departaments', 'deparment_cod'),
			'Companies' => array(self::HAS_MANY, 'Companies', 'city_id'),
			'Users' => array(self::HAS_MANY, 'User', 'city_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'city_id' => 'ID',
			'city_cod' => 'Codigo DANE',
			'city_name' => 'Nombre Ciudad',
			'deparment_cod' => 'Departamento',
			'city_state' => 'Estado',
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
		$criteria->addCondition('t.city_state in (0,1)');
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('city_cod',$this->city_cod,true);
		$criteria->compare('city_name',$this->city_name,true);
		$criteria->compare('deparment_cod',$this->deparment_cod,true);
		$criteria->compare('city_state',$this->city_state);

		$criteria->order= 'deparment_cod ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cities the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
