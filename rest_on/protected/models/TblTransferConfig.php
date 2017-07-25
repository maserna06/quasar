<?php

/**
 * This is the model class for table "tbl_transfer_config".
 *
 * The followings are the available columns in table 'tbl_transfer_config':
 * @property integer $id
 * @property integer $transfer_id
 * @property integer $transfer_format
 * @property integer $wharehouse_in
 * @property integer $wharehouse_out
 *
 * The followings are the available model relations:
 * @property Wharehouses $wharehouseIn
 * @property Wharehouses $wharehouseOut
 */
class TblTransferConfig extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_transfer_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transfer_id, transfer_format, wharehouse_in, wharehouse_out', 'required'),
			array('transfer_id, transfer_format, wharehouse_in, wharehouse_out', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, transfer_id, transfer_format, wharehouse_in, wharehouse_out', 'safe', 'on'=>'search'),
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
			'wharehouseIn' => array(self::BELONGS_TO, 'Wharehouses', 'wharehouse_in'),
			'wharehouseOut' => array(self::BELONGS_TO, 'Wharehouses', 'wharehouse_out'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'transfer_id' => 'Transfer',
			'transfer_format' => 'Transfer Format',
			'wharehouse_in' => 'Wharehouse In',
			'wharehouse_out' => 'Wharehouse Out',
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
		$criteria->compare('transfer_id',$this->transfer_id);
		$criteria->compare('transfer_format',$this->transfer_format);
		$criteria->compare('wharehouse_in',$this->wharehouse_in);
		$criteria->compare('wharehouse_out',$this->wharehouse_out);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblTransferConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
