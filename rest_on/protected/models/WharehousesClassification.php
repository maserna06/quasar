<?php

/**
 * This is the model class for table "tbl_wharehouses_classification".
 *
 * The followings are the available columns in table 'tbl_wharehouses_classification':
 * @property integer $wharehouse_id
 * @property integer $classification_id
 *
 * The followings are the available model relations:
 * @property Wharehouses $wharehouse
 * @property Classification $classification
 */
class WharehousesClassification extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_wharehouses_classification';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wharehouse_id, classification_id', 'required'),
			array('wharehouse_id, classification_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('wharehouse_id, classification_id', 'safe', 'on'=>'search'),
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
			'wharehouse' => array(self::BELONGS_TO, 'Wharehouses', 'wharehouse_id'),
			'classification' => array(self::BELONGS_TO, 'Classification', 'classification_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'wharehouse_id' => 'Wharehouse',
			'classification_id' => 'Classification',
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
		$criteria->compare('classification_id',$this->classification_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WharehousesClassification the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
