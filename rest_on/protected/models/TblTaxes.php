<?php

/**
 * This is the model class for table "tbl_taxes".
 *
 * The followings are the available columns in table 'tbl_taxes':
 * @property integer $tax_id
 * @property string $tax_description
 * @property integer $tax_ishighervalue
 * @property integer $tax_islowervalue
 * @property double $tax_rate
 * @property integer $tax_cta_income
 * @property integer $tax_cta_spending
 * @property string $economic_activity_cod
 * @property integer $tax_status
 *
 * The followings are the available model relations:
 * @property TblTaxProduct[] $tblTaxProducts
 * @property TblEconomicActivities $economicActivityCod
 * @property TblAccounts $taxCtaIncome
 * @property TblAccounts $taxCtaSpending
 * @property TblTaxesCustomer[] $tblTaxesCustomers
 * @property TblTaxesSupplier[] $tblTaxesSuppliers
 */
class TblTaxes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_taxes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tax_description, tax_ishighervalue, tax_islowervalue, tax_rate, tax_status', 'required'),
			array('tax_ishighervalue, tax_islowervalue, tax_cta_income, tax_cta_spending, tax_status', 'numerical', 'integerOnly'=>true),
			array('tax_rate', 'numerical'),
			array('tax_description', 'length', 'max'=>50),
			array('economic_activity_cod', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tax_id, tax_description, tax_ishighervalue, tax_islowervalue, tax_rate, tax_cta_income, tax_cta_spending, economic_activity_cod, tax_status', 'safe', 'on'=>'search'),
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
			'tblTaxProducts' => array(self::HAS_MANY, 'TblTaxProduct', 'tax_id'),
			'economicActivityCod' => array(self::BELONGS_TO, 'TblEconomicActivities', 'economic_activity_cod'),
			'taxCtaIncome' => array(self::BELONGS_TO, 'TblAccounts', 'tax_cta_income'),
			'taxCtaSpending' => array(self::BELONGS_TO, 'TblAccounts', 'tax_cta_spending'),
			'tblTaxesCustomers' => array(self::HAS_MANY, 'TblTaxesCustomer', 'tax_id'),
			'tblTaxesSuppliers' => array(self::HAS_MANY, 'TblTaxesSupplier', 'tax_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tax_id' => 'Tax',
			'tax_description' => 'Tax Description',
			'tax_ishighervalue' => 'Tax Ishighervalue',
			'tax_islowervalue' => 'Tax Islowervalue',
			'tax_rate' => 'Tax Rate',
			'tax_cta_income' => 'Tax Cta Income',
			'tax_cta_spending' => 'Tax Cta Spending',
			'economic_activity_cod' => 'Economic Activity Cod',
			'tax_status' => 'Tax Status',
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

		$criteria->compare('tax_id',$this->tax_id);
		$criteria->compare('tax_description',$this->tax_description,true);
		$criteria->compare('tax_ishighervalue',$this->tax_ishighervalue);
		$criteria->compare('tax_islowervalue',$this->tax_islowervalue);
		$criteria->compare('tax_rate',$this->tax_rate);
		$criteria->compare('tax_cta_income',$this->tax_cta_income);
		$criteria->compare('tax_cta_spending',$this->tax_cta_spending);
		$criteria->compare('economic_activity_cod',$this->economic_activity_cod,true);
		$criteria->compare('tax_status',$this->tax_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblTaxes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
