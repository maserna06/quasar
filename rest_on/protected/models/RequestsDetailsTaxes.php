<?php

/**
 * This is the model class for table "tbl_requests_details_taxes".
 *
 * The followings are the available columns in table 'tbl_requests_details_taxes':
 * @property integer $request_details_id
 * @property integer $taxes_id
 * @property double $request_details_tax_value
 *
 * The followings are the available model relations:
 * @property RequestsDetails $requestDetails
 * @property Taxes $taxes
 */
class RequestsDetailsTaxes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_requests_details_taxes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('request_details_id, taxes_id, request_details_tax_value', 'required'),
			array('request_details_id, taxes_id', 'numerical', 'integerOnly'=>true),
			array('request_details_tax_value', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('request_details_id, taxes_id, request_details_tax_value', 'safe', 'on'=>'search'),
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
			'requestDetails' => array(self::BELONGS_TO, 'RequestsDetails', 'request_details_id'),
			'taxes' => array(self::BELONGS_TO, 'Taxes', 'taxes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'request_details_id' => 'Request Details',
			'taxes_id' => 'Taxes',
			'request_details_tax_value' => 'Request Details Tax Value',
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

		$criteria->compare('request_details_id',$this->request_details_id);
		$criteria->compare('taxes_id',$this->taxes_id);
		$criteria->compare('request_details_tax_value',$this->request_details_tax_value);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RequestsDetailsTaxes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
