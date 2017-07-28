<?php

/**
 * This is the model class for table "tbl_economic_activities".
 *
 * The followings are the available columns in table 'tbl_economic_activities':
 * @property string $economic_activity_cod
 * @property string $economic_activity_description
 * @property integer $economic_activity_status
 *
 * The followings are the available model relations:
 * @property TblTaxes[] $tblTaxes
 */
class EconomicActivities extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_economic_activities';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('economic_activity_cod, economic_activity_description, economic_activity_status', 'required'),
			array('economic_activity_cod', 'unique'),
			array('economic_activity_status', 'numerical', 'integerOnly'=>true),
			array('economic_activity_cod', 'length', 'max'=>11),
			array('economic_activity_description', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('economic_activity_cod, economic_activity_description, economic_activity_status', 'safe', 'on'=>'search'),
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
			'Taxes' => array(self::HAS_MANY, 'Taxes', 'economic_activity_cod'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'economic_activity_cod' => 'Codigo DANE',
			'economic_activity_description' => 'Actividad Economica',
			'economic_activity_status' => 'Estado',
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
		$criteria->addCondition('t.economic_activity_status in (0,1)');
		$criteria->compare('economic_activity_cod',$this->economic_activity_cod,true);
		$criteria->compare('economic_activity_description',$this->economic_activity_description,true);
		$criteria->compare('economic_activity_status',$this->economic_activity_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EconomicActivities the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
