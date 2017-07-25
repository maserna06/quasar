<?php

/**
 * This is the model class for table "tbl_task".
 *
 * The followings are the available columns in table 'tbl_task':
 * @property integer $task_id
 * @property string $title
 * @property string $start
 * @property string $end
 * @property string $backgroundcolor
 * @property string $bordercolor
 * @property integer $task_progress
 * @property integer $task_visible
 * @property integer $task_state
 *
 * The followings are the available model relations:
 * @property TaskUser[] $taskUsers
 */
class Task extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_task';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, start, end, backgroundcolor, bordercolor, task_progress, task_visible, task_state', 'required'),
			array('task_progress, task_visible, task_state', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>300),
			array('backgroundcolor, bordercolor', 'length', 'max'=>50),
			array('description', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('task_id, title, start, end, description, backgroundcolor, bordercolor, task_progress, task_visible, task_state', 'safe', 'on'=>'search'),
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
			'taskUsers' => array(self::HAS_MANY, 'TaskUser', 'task_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'task_id' => 'Tarea',
			'title' => 'Titulo',
			'start' => 'Inicio',
			'end' => 'Fin',
			'description' => 'Descripción',
			'backgroundcolor' => 'Backgroundcolor',
			'bordercolor' => 'Bordercolor',
			'task_progress' => 'Progreso',
			'task_visible' => 'Visible',
			'task_state' => 'Estado',
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
		$criteria->addCondition('t.task_state in (1)');
		$criteria->compare('task_id',$this->task_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('start',$this->start,true);
		$criteria->compare('end',$this->end,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('backgroundcolor',$this->backgroundcolor,true);
		$criteria->compare('bordercolor',$this->bordercolor,true);
		$criteria->compare('task_progress',$this->task_progress);
		$criteria->compare('task_visible',$this->task_visible);
		$criteria->compare('task_state',$this->task_state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Task the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
