<?php

/**
 * This is the model class for table "tbl_finished_product".
 *
 * The followings are the available columns in table 'tbl_finished_product':
 * @property integer $finished_product_id
 * @property integer $finished_product_consecut
 * @property string $user_id
 * @property string $finished_product_date
 * @property string $finished_product_remarks
 * @property integer $finished_product_status
 *
 * The followings are the available model relations:
 * @property User $user
 * @property FinishedProductDetails[] $finishedProductDetails
 */
class TblFinishedProduct extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_finished_product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('finished_product_consecut, user_id, finished_product_date, finished_product_status', 'required'),
			array('finished_product_consecut, finished_product_status', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>20),
			array('finished_product_remarks', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('finished_product_id, finished_product_consecut, user_id, finished_product_date, finished_product_remarks, finished_product_status', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'finishedProductDetails' => array(self::HAS_MANY, 'FinishedProductDetails', 'finished_product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'finished_product_id' => 'Finished Product',
			'finished_product_consecut' => 'Finished Product Consecut',
			'user_id' => 'User',
			'finished_product_date' => 'Finished Product Date',
			'finished_product_remarks' => 'Finished Product Remarks',
			'finished_product_status' => 'Finished Product Status',
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

		$criteria->compare('finished_product_id',$this->finished_product_id);
		$criteria->compare('finished_product_consecut',$this->finished_product_consecut);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('finished_product_date',$this->finished_product_date,true);
		$criteria->compare('finished_product_remarks',$this->finished_product_remarks,true);
		$criteria->compare('finished_product_status',$this->finished_product_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblFinishedProduct the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
