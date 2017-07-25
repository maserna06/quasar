<?php

/**
 * This is the model class for table "tbl_daily_close".
 *
 * The followings are the available columns in table 'tbl_daily_close':
 * @property string $user_id
 * @property integer $wharehouse_id
 * @property string $date
 * @property double $value
 * @property string $movement_type
 * @property string $creation_date
 *
 * The followings are the available model relations:
 * @property Wharehouses $wharehouse
 * @property User $user
 */
class DailyClose extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_daily_close';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, wharehouse_id, date, value, movement_type, creation_date', 'required'),
			array('wharehouse_id', 'numerical', 'integerOnly'=>true),
			array('value', 'numerical'),
			array('user_id', 'length', 'max'=>20),
			array('movement_type', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, wharehouse_id, date, value, movement_type, creation_date', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'Usuario',
			'wharehouse_id' => 'Bodega',
			'date' => 'Fecha',
			'value' => 'Valor',
			'movement_type' => 'Tipo de Movimiento',
			'creation_date' => 'Fecha de Creación',
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('wharehouse_id',$this->wharehouse_id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('value',$this->value);
		$criteria->compare('movement_type',$this->movement_type,true);
		$criteria->compare('creation_date',$this->creation_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DailyClose the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
