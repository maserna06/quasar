<?php

/**
 * This is the model class for table "tbl_notification".
 *
 * The followings are the available columns in table 'tbl_notification':
 * @property integer $notify_id
 * @property integer $schedule_id
 * @property integer $notify_type
 * @property integer $notify_time
 * @property integer $notify_period
 * @property integer $notify_state
 *
 * The followings are the available model relations:
 * @property Schedule $schedule
 */
class Notification extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_notification';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('schedule_id, notify_type, notify_time, notify_period, notify_state', 'required'),
			array('schedule_id, notify_type, notify_time, notify_period, notify_state', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('notify_id, schedule_id, notify_type, notify_time, notify_period, notify_state', 'safe', 'on'=>'search'),
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
			'schedule' => array(self::BELONGS_TO, 'Schedule', 'schedule_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'notify_id' => 'Notify',
			'schedule_id' => 'Schedule',
			'notify_type' => 'Notify Type',
			'notify_time' => 'Notify Time',
			'notify_period' => 'Notify Period',
			'notify_state' => 'Notify State',
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

		$criteria->compare('notify_id',$this->notify_id);
		$criteria->compare('schedule_id',$this->schedule_id);
		$criteria->compare('notify_type',$this->notify_type);
		$criteria->compare('notify_time',$this->notify_time);
		$criteria->compare('notify_period',$this->notify_period);
		$criteria->compare('notify_state',$this->notify_state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Notification the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
