<?php

use App\User\User as U;

/**
 * This is the model class for table "tbl_companies_suppliers".
 *
 * The followings are the available columns in table 'tbl_companies_suppliers':
 * @property string $id
 * @property string $company_nit
 * @property string $supplier_nit
 * @property string $created_by
 * @property string $created_at
 * @property string $ip
 */
class CompaniesSuppliers extends BaseModel{

  /**
   * @return string the associated database table name
   */
  public function tableName(){
    return 'tbl_companies_suppliers';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules(){
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('company_nit, supplier_nit, created_by, created_at, ip','required'),
      array('company_nit, supplier_nit','length','max'=>20),
      array('created_by, ip','length','max'=>10),
      // The following rule is used by search().
      // @todo Please remove those attributes that should not be searched.
      array('id, company_nit, supplier_nit, created_by, created_at, ip','safe','on'=>'search'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations(){
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
        'supplier' => array(self::BELONGS_TO, 'Suppliers', 'supplier_nit'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels(){
    return array(
      'id'=>'ID',
      'company_nit'=>'Empresa',
      'supplier_nit'=>'Proveedor',
      'created_by'=>'Created By',
      'created_at'=>'Created At',
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
    $criteria->compare('supplier_nit',$this->supplier_nit,true);
    $criteria->compare('created_by',$this->created_by,true);
    $criteria->compare('created_at',$this->created_at,true);
    $criteria->compare('ip',$this->ip,true);

    return new CActiveDataProvider($this,array(
      'criteria'=>$criteria,
    ));
  }

  /**
   * Returns the static model of the specified AR class.
   * Please note that you should have this exact method in all your CActiveRecord descendants!
   * @param string $className active record class name.
   * @return CompaniesSuppliers the static model class
   */
  public static function model($className = __CLASS__){
    return parent::model($className);
  }

  /**
   * Get company's supplier
   * @param string $supplierNit
   * @param string $companyNit
   * @return CompaniesCustomers\null
   */
  public static function getByNit($supplierNit,$companyNit = null){
    $user = U::getInstance();
    $companyNit = $companyNit?:$user->companyId;
    return self::model()->find('company_nit=:company_nit AND supplier_nit=:supplier_nit',[
        ':company_nit'=>$companyNit,
        ':supplier_nit'=>$supplierNit,
    ]);
  }

}
