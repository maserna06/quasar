<?php

/**
 * This is the model class for table "tbl_finished_product_config".
 *
 * The followings are the available columns in table 'tbl_finished_product_config':
 * @property integer $id
 * @property integer $finished_product_id
 * @property integer $finished_product_format
 * @property integer $wharehouse_id
 *
 * The followings are the available model relations:
 * @property Wharehouses $wharehouse
 */
class TblFinishedProductConfig extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_finished_product_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('finished_product_id, finished_product_format, wharehouse_id', 'required'),
			array('finished_product_id, finished_product_format, wharehouse_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, finished_product_id, finished_product_format, wharehouse_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'finished_product_id' => 'Finished Product',
			'finished_product_format' => 'Finished Product Format',
			'wharehouse_id' => 'Wharehouse',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('finished_product_id',$this->finished_product_id);
		$criteria->compare('finished_product_format',$this->finished_product_format);
		$criteria->compare('wharehouse_id',$this->wharehouse_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblFinishedProductConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
