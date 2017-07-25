<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $user_id
 * @property string $user_name
 * @property string $user_firtsname
 * @property string $user_lastname
 * @property string $user_phone
 * @property string $user_address
 * @property string $user_photo
 * @property string $user_email
 * @property integer $user_emailconfirmed
 * @property string $user_phonenumber
 * @property integer $user_phonenumberconfirmed
 * @property string $user_passwordhash
 * @property string $user_lockoutenddateutc
 * @property integer $user_lockoutenabled
 * @property integer $user_accessfailcount
 * @property integer $deparment_id
 * @property integer $city_id
 * @property integer $company_id
 * @property integer $user_status
 *
 * The followings are the available model relations:
 * @property AuthItem[] $authItems
 * @property TblDepartaments $deparment
 * @property TblCities $city
 * @property TblCompanies $company
 */
class User extends CActiveRecord {

    // holds the password confirmation word
    public $repeat_password;
    public $old_password;
    public $new_password;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, user_name, user_firtsname, user_passwordhash, deparment_id, city_id, user_status', 'required','on'=>'insert, update'),
            array('user_name, user_email, user_status', 'required','on'=>'updateUser'),
            array('user_id, user_name, user_email, user_status', 'required','on'=>'updateCustomer'),
            array('user_emailconfirmed, user_phonenumberconfirmed, user_lockoutenabled, user_accessfailcount, deparment_id, city_id, user_status', 'numerical', 'integerOnly' => true),
            array('user_name, user_firtsname, user_lastname, user_address, user_email, user_photo', 'length', 'max' => 50),
            array('user_phone', 'length', 'max' => 30),
            array('user_id, user_phonenumber', 'length', 'max' => 20),
            array('user_id, user_name', 'unique'),
            array('user_id', 'numerical', 'integerOnly'=>true,'message'=>'ID debe ser numerico.'),
            array('user_passwordhash, repeat_password, old_password', 'length', 'max' => 60),
            array('user_lockoutenddateutc', 'safe'),
            array('company_id', 'default', 'setOnEmpty' => true, 'value' => null),
            array('repeat_password', 'compare', 'compareAttribute' => 'user_passwordhash', 'on' => 'insert'),
            array('repeat_password', 'compare', 'compareAttribute' => 'new_password', 'on' => 'updatepass, updateUser'),
            array('repeat_password, old_password, new_password', 'required', 'on' => 'updatepass'),
            array('repeat_password, new_password', 'length', 'min' => 6, 'on' => 'updatepass'),
            array('old_password', 'validate_pass', 'on' => 'updatepass'),
            array('user_email', 'email'),
            array('user_email', 'validate_mail', 'on' => 'recoverypass'),
            array('user_email', 'required', 'on' => 'recoverypass'),
            array('user_id, user_email', 'unique', 'on'=>'registertest'),
            array('user_email, user_id, user_firtsname', 'required', 'on'=>'registertest'),
            
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('user_id, user_name, user_firtsname, user_lastname, user_phone, user_address, user_photo, user_email, user_emailconfirmed, user_phonenumber, user_phonenumberconfirmed, user_passwordhash, user_lockoutenddateutc, user_lockoutenabled, user_accessfailcount, deparment_id, city_id, company_id, user_status', 'safe', 'on' => 'search'),
            
        );
    }
    
    public function validate_mail($attr, $param) {
        
        $data = 'user_email like '.'"'.$this[$attr].'"';
        $user = User::model()->findAll($data);
        if (!$user) {
            $this->addError($attr, "El correo electronico $this[$attr] no existe.");
        }
    }
    public function validate_pass($attr, $param) {
        $user = User::model()->findByPk(Yii::app()->user->id);
        if ($user->user_passwordhash != md5($this[$attr])) {
            $this->addError($attr, "La contraseña actual no coincide");
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'dailyCloses' => array(self::HAS_MANY, 'DailyClose', 'user_id'),
            //'authassignments' => array(self::HAS_MANY, 'Authassignment', 'userid'),
            'finishedProducts' => array(self::HAS_MANY, 'FinishedProduct', 'user_id'),
            'orders' => array(self::HAS_MANY, 'Order', 'user_id'),
            'purchases' => array(self::HAS_MANY, 'Purchases', 'user_id'),
            'referrals' => array(self::HAS_MANY, 'Referrals', 'user_id'),
            'referralsps' => array(self::HAS_MANY, 'Referralsp', 'user_id'),
            'requests' => array(self::HAS_MANY, 'Requests', 'user_id'),
            'sales' => array(self::HAS_MANY, 'Sales', 'user_id'),
            'scheduleUsers' => array(self::HAS_MANY, 'ScheduleUser', 'user_id'),
            'taskUsers' => array(self::HAS_MANY, 'TaskUser', 'user_id'),
            'transfers' => array(self::HAS_MANY, 'Transfers', 'user_id'),
            'deparment' => array(self::BELONGS_TO, 'Departaments', 'deparment_id'),
            'city' => array(self::BELONGS_TO, 'Cities', 'city_id'),
            'company' => array(self::BELONGS_TO, 'Companies', 'company_id'),
            'wharehousesUsers' => array(self::HAS_MANY, 'WharehousesUser', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'user_id' => 'ID',
            'user_name' => 'Usuario',
            'user_firtsname' => 'Nombres',
            'user_lastname' => 'Apellidos',
            'user_phone' => 'Telefono',
            'user_address' => 'Direccion',
            'user_photo' => 'Foto',
            'user_email' => 'Email',
            'user_emailconfirmed' => 'Emailconfirmed',
            'user_phonenumber' => 'Celular',
            'user_phonenumberconfirmed' => 'Phonenumberconfirmed',
            'user_passwordhash' => 'Contraseña',
            'repeat_password' => 'Confirme Contraseña',
            'new_password' => 'Nueva Contraseña',
            'old_password' => 'Contraseña Actual',
            'user_lockoutenddateutc' => 'Lockoutenddateutc',
            'user_lockoutenabled' => 'Lockoutenabled',
            'user_accessfailcount' => 'Accessfailcount',
            'deparment_id' => 'Departamento',
            'city_id' => 'Ciudad',
            'company_id' => 'Empresa',
            'user_status' => 'Estado',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = array('company' => array('joinType' => 'INNER JOIN', 'together' => true,));
        $criteria->join="INNER JOIN AuthAssignment a ON a.userid = user_id AND a.itemname <> 'supplier' AND a.itemname <> 'customer'";

        $criteria->addCondition('t.user_status in (0,1)');
        //$criteria->with = array('authassignments' => array('joinType' => 'INNER JOIN', 'together' => true,));
        //$criteria->compare('t.itemname != "customer"');
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('user_name', $this->user_name, true);
        $criteria->compare('user_firtsname', $this->user_firtsname, true);
        $criteria->compare('user_lastname', $this->user_lastname, true);
        $criteria->compare('user_phone', $this->user_phone, true);
        $criteria->compare('user_address', $this->user_address, true);
        $criteria->compare('user_photo', $this->user_photo, true);
        $criteria->compare('user_email', $this->user_email, true);
        $criteria->compare('user_emailconfirmed', $this->user_emailconfirmed);
        $criteria->compare('user_phonenumber', $this->user_phonenumber, true);
        $criteria->compare('user_phonenumberconfirmed', $this->user_phonenumberconfirmed);
        $criteria->compare('user_passwordhash', $this->user_passwordhash, true);
        $criteria->compare('user_lockoutenddateutc', $this->user_lockoutenddateutc, true);
        $criteria->compare('user_lockoutenabled', $this->user_lockoutenabled);
        $criteria->compare('user_accessfailcount', $this->user_accessfailcount);
        $criteria->compare('deparment_id', $this->deparment_id);
        $criteria->compare('city_id', $this->city_id);

        $criteria->compare('user_status', $this->user_status);

        $user = U::getInstance();
        if ($user->isOnlyAdmin()) {
            $criteria->compare('t.company_id', $user->companyId);
            $criteria->order = 'user_firtsname ASC';
        } else {
            $criteria->compare('t.company_id', $this->company_id);

            $criteria->order = 'user_firtsname ASC';
            $criteria->order = 'company.company_name ASC';
        }

        $criteria->group="user_id";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
