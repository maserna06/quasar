<?php
use App\User\User as U;
/**
 * This is the model class for table "tbl_wharehouses".
 *
 * The followings are the available columns in table 'tbl_wharehouses':
 * @property integer $wharehouse_id
 * @property string $company_id
 * @property string $wharehouse_name
 * @property string $wharehouse_phone
 * @property string $wharehouse_address
 * @property integer $deparment_id
 * @property integer $city_id
 * @property integer $wharehouse_status
 */
class Wharehouses extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_wharehouses';
	}

	/**     
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, wharehouse_name, deparment_id, city_id, wharehouse_status', 'required'),
			array('deparment_id, city_id, wharehouse_status', 'numerical', 'integerOnly'=>true),
			array('company_id, wharehouse_phone', 'length', 'max'=>20),
			array('wharehouse_name, wharehouse_address', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('wharehouse_id, company_id, wharehouse_name, wharehouse_phone, wharehouse_address, deparment_id, city_id, wharehouse_status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			'dailyCloses' => array(self::HAS_MANY, 'DailyClose', 'wharehouse_id'),
			'finishedProductConfigs' => array(self::HAS_MANY, 'FinishedProductConfig', 'wharehouse_id'),
			'finishedProductDetails' => array(self::HAS_MANY, 'FinishedProductDetails', 'wharehouse_inserted'),
			'inventories' => array(self::HAS_MANY, 'Inventories', 'wharehouse_id'),
			'orderConfigs' => array(self::HAS_MANY, 'OrderConfig', 'wharehouse_id'),
			'orderDetails' => array(self::HAS_MANY, 'OrderDetails', 'wharehouse_id'),
			'purchaseConfigs' => array(self::HAS_MANY, 'PurchaseConfig', 'wharehouse_id'),
			'purchaseDetails' => array(self::HAS_MANY, 'PurchaseDetails', 'wharehouse_id'),
			'referralConfigs' => array(self::HAS_MANY, 'ReferralConfig', 'wharehouse_id'),
			'referralpConfigs' => array(self::HAS_MANY, 'ReferralpConfig', 'wharehouse_id'),
			'referralsDetails' => array(self::HAS_MANY, 'ReferralsDetails', 'wharehouse_id'),
			'referralspDetails' => array(self::HAS_MANY, 'ReferralspDetails', 'wharehouse_id'),
			'requestConfigs' => array(self::HAS_MANY, 'RequestConfig', 'wharehouse_id'),
			'requestsDetails' => array(self::HAS_MANY, 'RequestsDetails', 'wharehouse_id'),
			'saleConfigs' => array(self::HAS_MANY, 'SaleConfig', 'wharehouse_id'),
			'salesDetails' => array(self::HAS_MANY, 'SalesDetails', 'wharehouse_id'),
			'transferConfigs' => array(self::HAS_MANY, 'TransferConfig', 'wharehouse_in'),
			'transferConfigs1' => array(self::HAS_MANY, 'TransferConfig', 'wharehouse_out'),
			'transfersDetails' => array(self::HAS_MANY, 'TransfersDetails', 'wharehouse_in'),
			'transfersDetails1' => array(self::HAS_MANY, 'TransfersDetails', 'wharehouse_out'),
			'company' => array(self::BELONGS_TO, 'Companies', 'company_id'),
			'deparment' => array(self::BELONGS_TO, 'Departaments', 'deparment_id'),
			'city' => array(self::BELONGS_TO, 'Cities', 'city_id'),
			'wharehousesClassifications' => array(self::HAS_MANY, 'WharehousesClassification', 'wharehouse_id'),
			'wharehousesUsers' => array(self::HAS_MANY, 'WharehousesUser', 'wharehouse_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'wharehouse_id' => 'Id',
			'company_id' => 'Empresa',
			'wharehouse_name' => 'Bodega',
			'wharehouse_phone' => 'Telefono',
			'wharehouse_address' => 'Direccion',
			'deparment_id' => 'Departamento',
			'city_id' => 'Ciudad',
			'wharehouse_status' => 'Estado',
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
		$criteria->addCondition('t.wharehouse_status in (0,1)');
		$criteria->with = array('company'=>array('joinType' => 'INNER JOIN','together' => true,));
		
		$criteria->compare('wharehouse_id',$this->wharehouse_id);
		$criteria->compare('wharehouse_name',$this->wharehouse_name,true);
		$criteria->compare('wharehouse_phone',$this->wharehouse_phone,true);
		$criteria->compare('wharehouse_address',$this->wharehouse_address,true);
		$criteria->compare('deparment_id',$this->deparment_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('wharehouse_status',$this->wharehouse_status);
    
	    $user=U::getInstance();

	    if($user->isOnlyAdmin()){
	      $criteria->compare('t.company_id',$user->companyId);
	      $criteria->order= 'wharehouse_name ASC';
	    }else{
	      $criteria->compare('t.company_id',$this->company_id,true);
	      $criteria->order= 'wharehouse_name ASC';
	      $criteria->order= 'company.company_name ASC';
	    }

	    
	    

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Wharehouses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
