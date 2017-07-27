<?php

/**
 * This is the model class for table "tbl_config".
 *
 * The followings are the available columns in table 'tbl_config':
 * @property integer $config_id
 * @property string $company_id
 * @property integer $manage_tables
 * @property integer $count_tables
 * @property integer $handle_datasheet
 *
 * The followings are the available model relations:
 * @property Companies $company
 */
class Config extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id', 'required'),
			array('manage_tables, count_tables, handle_datasheet', 'numerical', 'integerOnly'=>true),
			array('company_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('config_id, company_id, manage_tables, count_tables, handle_datasheet', 'safe', 'on'=>'search'),
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
			'company' => array(self::BELONGS_TO, 'Companies', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'config_id' => 'Config',
			'company_id' => 'Company',
			'manage_tables' => 'Manage Tables',
			'count_tables' => 'Count Tables',
			'handle_datasheet' => 'Handle Datasheet',
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

		$criteria->compare('config_id',$this->config_id);
		$criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('manage_tables',$this->manage_tables);
		$criteria->compare('count_tables',$this->count_tables);
		$criteria->compare('handle_datasheet',$this->handle_datasheet);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Config the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
