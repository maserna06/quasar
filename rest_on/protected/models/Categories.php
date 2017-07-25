<?php

/**
 * This is the model class for table "tbl_categories".
 *
 * The followings are the available columns in table 'tbl_categories':
 * @property integer $category_id
 * @property string $category_description
 * @property integer $category_status
 *
 * The followings are the available model relations:
 * @property TblProducts[] $tblProducts
 */
class Categories extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_categories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_description, category_status', 'required'),
			array('category_description', 'unique'),
			array('category_status', 'numerical', 'integerOnly'=>true),
			array('category_description', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('category_id, category_description, category_status', 'safe', 'on'=>'search'),
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
			'tblProducts' => array(self::HAS_MANY, 'TblProducts', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'category_id' => 'ID',
			'category_description' => 'Descripcion',
			'category_status' => 'Estado',
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
		$criteria->addCondition('t.category_status in (0,1)');
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('category_description',$this->category_description,true);
		$criteria->compare('category_status',$this->category_status);

		$criteria->order= 'category_description ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Categories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
