<?php

/**
 * This is the model class for table "tbl_companies".
 *
 * The followings are the available columns in table 'tbl_companies':
 * @property string $company_id
 * @property string $company_name
 * @property string $company_phone
 * @property string $company_address
 * @property string $company_logo
 * @property string $company_url
 * @property integer $company_status
 * @property integer $deparment_id
 * @property integer $city_id
 *
 * The followings are the available model relations:
 * @property TblCities $city
 * @property TblDepartaments $deparment
 * @property TblUser[] $tblUsers
 */
class TblCompanies extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_companies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, company_name, company_phone, company_address, company_status, deparment_id, city_id', 'required'),
			array('company_status, deparment_id, city_id', 'numerical', 'integerOnly'=>true),
			array('company_id, company_phone, company_url', 'length', 'max'=>20),
			array('company_name, company_address, company_logo', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('company_id, company_name, company_phone, company_address, company_logo, company_url, company_status, deparment_id, city_id', 'safe', 'on'=>'search'),
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
			'city' => array(self::BELONGS_TO, 'TblCities', 'city_id'),
			'deparment' => array(self::BELONGS_TO, 'TblDepartaments', 'deparment_id'),
			'tblUsers' => array(self::HAS_MANY, 'TblUser', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'company_id' => 'Company',
			'company_name' => 'Company Name',
			'company_phone' => 'Company Phone',
			'company_address' => 'Company Address',
			'company_logo' => 'Company Logo',
			'company_url' => 'Company Url',
			'company_status' => 'Company Status',
			'deparment_id' => 'Deparment',
			'city_id' => 'City',
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

		$criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('company_phone',$this->company_phone,true);
		$criteria->compare('company_address',$this->company_address,true);
		$criteria->compare('company_logo',$this->company_logo,true);
		$criteria->compare('company_url',$this->company_url,true);
		$criteria->compare('company_status',$this->company_status);
		$criteria->compare('deparment_id',$this->deparment_id);
		$criteria->compare('city_id',$this->city_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblCompanies the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
