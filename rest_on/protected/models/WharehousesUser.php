<?php

/**
 * This is the model class for table "tbl_wharehouses_user".
 *
 * The followings are the available columns in table 'tbl_wharehouses_user':
 * @property integer $wharehouse_id
 * @property string $user_id
 * @property integer $daily_close
 * @property string $date_open
 * @property string $date_close
 * @property string $cash_ip
 * @property string $cash_port
 * @property string $dataphone_ip
 * @property string $dataphone_port
 * @property string $dataphone_name
 */
class WharehousesUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_wharehouses_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wharehouse_id, user_id', 'required'),
			array('wharehouse_id, multicash, daily_close', 'numerical', 'integerOnly'=>true),
			array('user_id, cash_ip, dataphone_ip', 'length', 'max'=>20),
			array('cash_port, dataphone_port', 'length', 'max'=>4),
			array('dataphone_name', 'length', 'max'=>200),
			array('date_open, date_close', 'safe'),
			array('cash_ip, cash_port, dataphone_ip, dataphone_port, dataphone_name', 'required', 'on'=>'dataphone'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('wharehouse_id, user_id, multicash, daily_close, date_open, date_close, cash_ip, cash_port, dataphone_ip, dataphone_port, dataphone_name', 'safe', 'on'=>'search'),
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
			'wharehouses' => array(self::BELONGS_TO, 'Wharehouses', 'wharehouse_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'wharehouse_id' => 'Bodega',
			'user_id' => 'Usuario',
			'multicash' => 'Multi Caja',
			'daily_close' => 'Cierre Diario',
			'date_open' => 'Fecha Apertura',
			'date_close' => 'Fecha Cierre',
			'cash_ip' => 'Ip Caja',
			'cash_port' => 'Puerto Caja',
			'dataphone_ip' => 'Ip Datafono',
			'dataphone_port' => 'Puerto Datafono',
			'dataphone_name' => 'Nombre Datafono',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('multicash',$this->multicash);
		$criteria->compare('daily_close',$this->daily_close);
		$criteria->compare('date_open',$this->date_open,true);
		$criteria->compare('date_close',$this->date_close,true);
		$criteria->compare('cash_ip',$this->cash_ip,true);
		$criteria->compare('cash_port',$this->cash_port,true);
		$criteria->compare('dataphone_ip',$this->dataphone_ip,true);
		$criteria->compare('dataphone_port',$this->dataphone_port,true);
		$criteria->compare('dataphone_name',$this->dataphone_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WharehousesUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
