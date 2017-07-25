<?php

/**
 * This is the model class for table "tbl_classification".
 *
 * The followings are the available columns in table 'tbl_classification':
 * @property integer $classification_id
 * @property string $classification_name
 * @property string $classification_description
 * @property integer $classification_status
 *
 * The followings are the available model relations:
 * @property TblClassificationProduct[] $tblClassificationProducts
 */
class Classification extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_classification';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('classification_name, classification_status', 'required'),
			array('classification_name', 'unique'),
			array('classification_status', 'numerical', 'integerOnly'=>true),
			array('classification_name', 'length', 'max'=>50),
			array('classification_description', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('classification_id, classification_name, classification_description, classification_status', 'safe', 'on'=>'search'),
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
			'tblClassificationProducts' => array(self::HAS_MANY, 'TblClassificationProduct', 'classification_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'classification_id' => 'ID',
			'classification_name' => 'Nombre Clasificaciòn',
			'classification_description' => 'Descripciòn',
			'classification_status' => 'Estado',
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
		$criteria->addCondition('t.classification_status in (0,1)');
		$criteria->compare('classification_id',$this->classification_id);
		$criteria->compare('classification_name',$this->classification_name,true);
		$criteria->compare('classification_description',$this->classification_description,true);
		$criteria->compare('classification_status',$this->classification_status);

		$criteria->order= 'classification_name ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Classification the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
