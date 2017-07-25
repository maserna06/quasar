<?php

/**
 * This is the model class for table "tbl_order_config".
 *
 * The followings are the available columns in table 'tbl_order_config':
 * @property integer $id
 * @property integer $order_id
 * @property integer $order_format
 * @property integer $accounts_id
 * @property integer $wharehouse_id
 */
class OrderConfig extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_order_config';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_id, order_format, accounts_id, wharehouse_id', 'required','on'=>'insert, update,existe'),
            array('order_id, order_format, wharehouse_id', 'required','on'=>'company'),
            array('order_id, order_format, accounts_id, wharehouse_id', 'numerical', 'integerOnly' => true),
            array('order_id', 'validate_num', 'on' => 'existe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('order_id, order_format, accounts_id, wharehouse_id', 'safe', 'on' => 'search'),
        );
    }

    public function validate_num($attr, $param) {
        $valor = OrderConfigExtend::ordenesCreate();
        if($valor)
            $valor = OrderConfig::model()->findByPk($valor)->order_id;
        else
            $valor = 0;
        if ($valor > $this[$attr]) {
            $this->addError($attr, "El numero a actualizar no puede ser menor que ".$valor);
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'wharehouses' => array(self::BELONGS_TO, 'Wharehouses', 'wharehouse_id'),
            'accounts' => array(self::BELONGS_TO, 'Accounts', 'accounts_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
			'id' => 'ID',
            'order_id' => 'Consecutivo de Ordenes',
            'order_format' => 'Formato de Factura',
            'accounts_id' => 'Cuenta Contable',
            'wharehouse_id' => 'Bodega',
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
		
		$criteria->compare('id',$this->id);
        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('order_format', $this->order_format);
        $criteria->compare('accounts_id', $this->accounts_id);
        $criteria->compare('wharehouse_id', $this->wharehouse_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OrderConfig the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
