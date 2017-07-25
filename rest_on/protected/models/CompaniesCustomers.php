<?php

use App\User\User as U;

/**
 * This is the model class for table "tbl_companies_customers".
 *
 * The followings are the available columns in table 'tbl_companies_customers':
 * @property string $id
 * @property string $company_nit
 * @property string $customer_nit
 * @property string $created_by
 * @property string $created_at
 * @property string $ip
 */
class CompaniesCustomers extends BaseModel{

  /**
   * @return string the associated database table name
   */
  public function tableName(){
    return 'tbl_companies_customers';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules(){
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('company_nit, customer_nit, created_by, created_at, ip','required'),
      array('company_nit, customer_nit','length','max'=>20),
      array('created_by, ip','length','max'=>10),
      // The following rule is used by search().
      // @todo Please remove those attributes that should not be searched.
      array('id, company_nit, customer_nit, created_by, created_at, ip','safe','on'=>'search'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations(){
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
        'customer' => array(self::BELONGS_TO, 'Customers', 'customer_nit'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels(){
    return array(
      'id'=>'ID',
      'company_nit'=>'Empresa',
      'customer_nit'=>'Cliente',
      'created_by'=>'Usuario que crea',
      'created_at'=>'Fecha de Creación',
      'ip'=>'Ip',
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
  public function search(){
    // @todo Please modify the following code to remove attributes that should not be searched.

    $criteria = new CDbCriteria;

    $criteria->compare('id',$this->id,true);
    $criteria->compare('company_nit',$this->company_nit,true);
    $criteria->compare('customer_nit',$this->customer_nit,true);
//    $criteria->compare('created_by',$this->created_by,true);
//    $criteria->compare('created_at',$this->created_at,true);
//    $criteria->compare('ip',$this->ip,true);

    return new CActiveDataProvider($this,array(
      'criteria'=>$criteria,
    ));
  }

  /**
   * Returns the static model of the specified AR class.
   * Please note that you should have this exact method in all your CActiveRecord descendants!
   * @param string $className active record class name.
   * @return CompaniesCustomers the static model class
   */
  public static function model($className = __CLASS__){
    return parent::model($className);
  }

  /**
   * Get company's customer
   * @param string $customerNit
   * @param string $companyNit
   * @return CompaniesCustomers\null
   */
  public static function getByNit($customerNit,$companyNit = null){
    $user = U::getInstance();
    $companyNit = $companyNit?:$user->companyId;
    return self::model()->find('company_nit=:company_nit AND customer_nit=:customer_nit',[
        ':company_nit'=>$companyNit,
        ':customer_nit'=>$customerNit,
    ]);
  }

}
