<?php

/**
 * This is the model class for table "tbl_schedule".
 *
 * The followings are the available columns in table 'tbl_schedule':
 * @property integer $schedule_id
 * @property string $title
 * @property string $start
 * @property string $end
 * @property integer $allday
 * @property string $url
 * @property string $backgroundcolor
 * @property string $bordercolor
 * @property integer $schedule_visible
 * @property integer $schedule_state
 *
 * The followings are the available model relations:
 * @property ScheduleUser[] $scheduleUsers
 */
class Schedule extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_schedule';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, schedule_visible, schedule_state', 'required'),
			array('allday, schedule_visible, schedule_state', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>300),
			array('url', 'length', 'max'=>1000),
			array('backgroundcolor, bordercolor', 'length', 'max'=>50),
			array('start, end', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('schedule_id, title, start, end, allday, url, backgroundcolor, bordercolor, schedule_visible, schedule_state', 'safe', 'on'=>'search'),
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
			'scheduleUsers' => array(self::HAS_MANY, 'ScheduleUser', 'schedule_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'schedule_id' => 'Schedule',
			'title' => 'Title',
			'start' => 'Start',
			'end' => 'End',
			'allday' => 'Allday',
			'url' => 'Url',
			'backgroundcolor' => 'Backgroundcolor',
			'bordercolor' => 'Bordercolor',
			'schedule_visible' => 'Schedule Visible',
			'schedule_state' => 'Schedule State',
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

		$criteria->compare('schedule_id',$this->schedule_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('start',$this->start,true);
		$criteria->compare('end',$this->end,true);
		$criteria->compare('allday',$this->allday);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('backgroundcolor',$this->backgroundcolor,true);
		$criteria->compare('bordercolor',$this->bordercolor,true);
		$criteria->compare('schedule_visible',$this->schedule_visible);
		$criteria->compare('schedule_state',$this->schedule_state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Schedule the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
