<?php

/**
 * This is the model class for table "tbl_transfers".
 *
 * The followings are the available columns in table 'tbl_transfers':
 * @property integer $transfer_id
 * @property integer $transfer_consecut
 * @property string $user_id
 * @property string $transfer_date
 * @property string $transfer_remarks
 * @property integer $transfer_status
 *
 * The followings are the available model relations:
 * @property User $user
 * @property TransfersDetails[] $transfersDetails
 */
class Transfers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_transfers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transfer_consecut, user_id, transfer_date, transfer_status', 'required'),
			array('transfer_consecut, transfer_status', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>20),
			array('transfer_remarks', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('transfer_id, transfer_consecut, user_id, transfer_date, transfer_remarks, transfer_status', 'safe', 'on'=>'search'),
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
			'transfersDetails' => array(self::HAS_MANY, 'TransfersDetails', 'transfer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'transfer_id' => 'ID',
			'transfer_consecut' => 'Consecutivo',
			'user_id' => 'Usuario',
			'transfer_date' => 'Fecha',
			'transfer_remarks' => 'Observaciones',
			'transfer_status' => 'Estado',
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

		$criteria->compare('transfer_id',$this->transfer_id);
		$criteria->compare('transfer_consecut',$this->transfer_consecut);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('transfer_date',$this->transfer_date,true);
		$criteria->compare('transfer_remarks',$this->transfer_remarks,true);
		$criteria->compare('transfer_status',$this->transfer_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Transfers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
