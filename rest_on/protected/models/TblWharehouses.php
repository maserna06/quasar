<?php

/**
 * This is the model class for table "tbl_wharehouses".
 *
 * The followings are the available columns in table 'tbl_wharehouses':
 * @property integer $wharehouse_id
 * @property string $company_id
 * @property string $wharehouse_name
 * @property string $wharehouse_phone
 * @property string $wharehouse_address
 * @property integer $deparment_id
 * @property integer $city_id
 * @property integer $wharehouse_status
 */
class TblWharehouses extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_wharehouses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, wharehouse_name, deparment_id, city_id, wharehouse_status', 'required'),
			array('deparment_id, city_id, wharehouse_status', 'numerical', 'integerOnly'=>true),
			array('company_id, wharehouse_phone', 'length', 'max'=>20),
			array('wharehouse_name, wharehouse_address', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('wharehouse_id, company_id, wharehouse_name, wharehouse_phone, wharehouse_address, deparment_id, city_id, wharehouse_status', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'wharehouse_id' => 'Wharehouse',
			'company_id' => 'Company',
			'wharehouse_name' => 'Wharehouse Name',
			'wharehouse_phone' => 'Wharehouse Phone',
			'wharehouse_address' => 'Wharehouse Address',
			'deparment_id' => 'Deparment',
			'city_id' => 'City',
			'wharehouse_status' => 'Wharehouse Status',
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

		$criteria->compare('wharehouse_id',$this->wharehouse_id);
		$criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('wharehouse_name',$this->wharehouse_name,true);
		$criteria->compare('wharehouse_phone',$this->wharehouse_phone,true);
		$criteria->compare('wharehouse_address',$this->wharehouse_address,true);
		$criteria->compare('deparment_id',$this->deparment_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('wharehouse_status',$this->wharehouse_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblWharehouses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
