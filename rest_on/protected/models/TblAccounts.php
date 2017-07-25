<?php

/**
 * This is the model class for table "tbl_accounts".
 *
 * The followings are the available columns in table 'tbl_accounts':
 * @property integer $account_id
 * @property integer $account_type
 * @property string $account_name
 * @property string $account_number
 * @property string $account_description
 * @property integer $account_status
 */
class TblAccounts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_accounts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_type, account_name, account_number, account_status', 'required'),
			array('account_type, account_status', 'numerical', 'integerOnly'=>true),
			array('account_name', 'length', 'max'=>50),
			array('account_number', 'length', 'max'=>20),
			array('account_description', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('account_id, account_type, account_name, account_number, account_description, account_status', 'safe', 'on'=>'search'),
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
			'accountType' => array(self::BELONGS_TO, 'TblTypeAccounts', 'account_type'),
			'tblTaxes' => array(self::HAS_MANY, 'TblTaxes', 'tax_cta_income'),
			'tblTaxes1' => array(self::HAS_MANY, 'TblTaxes', 'tax_cta_spending'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'account_id' => 'Account',
			'account_type' => 'Account Type',
			'account_name' => 'Account Name',
			'account_number' => 'Account Number',
			'account_description' => 'Account Description',
			'account_status' => 'Account Status',
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

		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('account_type',$this->account_type);
		$criteria->compare('account_name',$this->account_name,true);
		$criteria->compare('account_number',$this->account_number,true);
		$criteria->compare('account_description',$this->account_description,true);
		$criteria->compare('account_status',$this->account_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblAccounts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
