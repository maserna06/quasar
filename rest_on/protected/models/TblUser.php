<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $user_id
 * @property string $user_name
 * @property string $user_firtsname
 * @property string $user_lastname
 * @property string $user_phone
 * @property string $user_address
 * @property string $user_photo
 * @property string $user_email
 * @property integer $user_emailconfirmed
 * @property string $user_phonenumber
 * @property integer $user_phonenumberconfirmed
 * @property string $user_passwordhash
 * @property string $user_lockoutenddateutc
 * @property integer $user_lockoutenabled
 * @property integer $user_accessfailcount
 * @property integer $deparment_id
 * @property integer $city_id
 * @property string $company_id
 * @property integer $user_status
 *
 * The followings are the available model relations:
 * @property AuthItem[] $authItems
 * @property TblCompanies $company
 * @property TblDepartaments $deparment
 * @property TblCities $city
 * @property TblWharehousesUser[] $tblWharehousesUsers
 */
class TblUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, user_name, user_firtsname, user_passwordhash, deparment_id, city_id, user_status', 'required'),
			array('user_id, user_emailconfirmed, user_phonenumberconfirmed, user_lockoutenabled, user_accessfailcount, deparment_id, city_id, user_status', 'numerical', 'integerOnly'=>true),
			array('user_name, user_firtsname, user_lastname, user_address, user_email, user_photo', 'length', 'max'=>50),
			array('user_phone', 'length', 'max'=>30),
			array('user_phonenumber, company_id', 'length', 'max'=>20),
			array('user_passwordhash', 'length', 'max'=>60),
			array('user_lockoutenddateutc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, user_name, user_firtsname, user_lastname, user_phone, user_address, user_photo, user_email, user_emailconfirmed, user_phonenumber, user_phonenumberconfirmed, user_passwordhash, user_lockoutenddateutc, user_lockoutenabled, user_accessfailcount, deparment_id, city_id, company_id, user_status', 'safe', 'on'=>'search'),
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
			'authItems' => array(self::MANY_MANY, 'AuthItem', 'AuthAssignment(userid, itemname)'),
			'company' => array(self::BELONGS_TO, 'TblCompanies', 'company_id'),
			'deparment' => array(self::BELONGS_TO, 'TblDepartaments', 'deparment_id'),
			'city' => array(self::BELONGS_TO, 'TblCities', 'city_id'),
			'tblWharehousesUsers' => array(self::HAS_MANY, 'TblWharehousesUser', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'user_name' => 'User Name',
			'user_firtsname' => 'User Firtsname',
			'user_lastname' => 'User Lastname',
			'user_phone' => 'User Phone',
			'user_address' => 'User Address',
			'user_photo' => 'User Photo',
			'user_email' => 'User Email',
			'user_emailconfirmed' => 'User Emailconfirmed',
			'user_phonenumber' => 'User Phonenumber',
			'user_phonenumberconfirmed' => 'User Phonenumberconfirmed',
			'user_passwordhash' => 'User Passwordhash',
			'user_lockoutenddateutc' => 'User Lockoutenddateutc',
			'user_lockoutenabled' => 'User Lockoutenabled',
			'user_accessfailcount' => 'User Accessfailcount',
			'deparment_id' => 'Deparment',
			'city_id' => 'City',
			'company_id' => 'Company',
			'user_status' => 'User Status',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('user_firtsname',$this->user_firtsname,true);
		$criteria->compare('user_lastname',$this->user_lastname,true);
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('user_address',$this->user_address,true);
		$criteria->compare('user_photo',$this->user_photo,true);
		$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('user_emailconfirmed',$this->user_emailconfirmed);
		$criteria->compare('user_phonenumber',$this->user_phonenumber,true);
		$criteria->compare('user_phonenumberconfirmed',$this->user_phonenumberconfirmed);
		$criteria->compare('user_passwordhash',$this->user_passwordhash,true);
		$criteria->compare('user_lockoutenddateutc',$this->user_lockoutenddateutc,true);
		$criteria->compare('user_lockoutenabled',$this->user_lockoutenabled);
		$criteria->compare('user_accessfailcount',$this->user_accessfailcount);
		$criteria->compare('deparment_id',$this->deparment_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('user_status',$this->user_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
