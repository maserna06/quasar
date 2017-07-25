<?php
use App\Utils\Purifier;
/**
 * Modelo extendido de Companies por si hay actualizaciones en base de datos 
 * y se genera el modelo por GII no se vean afectadas las funciones personalizadas
 */
class CompaniesExtend extends Companies {

  public static function newCompany($company = NULL) {
    if ($company)
      $model = Companies::model()->findByPk($company); // si $product es diferente de null declara el modelo del producto aeditar
    else
      $model = new Companies;

    $archivo = (!$model->company_logo) ? 'company-350x350.png' : $model->company_logo;
    $model->attributes = $_POST['Companies'];
    $model->company_logo = $archivo;
    if ($model->save() && !$company) {

      /////////////////////////////////////////////////////////////////////
      //////////////////////////// WHAREHOUSE ////////////////////////////
      ///////////////////////////////////////////////////////////////////
      //WhareHouses Create
      $wharehouse = new Wharehouses;
      $wharehouse->company_id = $model->company_id;
      $wharehouse->wharehouse_name = 'CENTRO DE OPERACIONES';
      $wharehouse->wharehouse_phone = $model->company_phone;
      $wharehouse->wharehouse_address = $model->company_address;
      $wharehouse->deparment_id = $model->deparment_id;
      $wharehouse->city_id = $model->city_id;
      $wharehouse->wharehouse_status = 1;
      $wharehouse->save();

      /////////////////////////////////////////////////////////////////////
      /////////////////////////////// USERS //////////////////////////////
      ///////////////////////////////////////////////////////////////////
      //User Create
      $user = new User('company');
      $user->user_id = $model->company_id;
      $user->company_id = $model->company_id;
      $user->user_name = $model->company_id;
      $user->user_firtsname = $model->company_name;
      $user->user_passwordhash = md5('admin');
      $user->deparment_id = $model->deparment_id;
      $user->user_phone = $model->company_phone;
      $user->user_address = $model->company_address;
      $user->user_lockoutenabled = 0;
      $user->user_lockoutenddateutc = date('Y-m-d');
      $user->city_id = $model->city_id;
      $user->user_status = 1;
      $user->user_photo = 'user2-160x160.jpg';
      $user->save();
      //creando rol
      $auth = Yii::app()->authManager;
      $auth->assign('admin', $user->user_id);

      /////////////////////////////////////////////////////////////////////
      ///////////////////////////// PURCHASES ////////////////////////////
      ///////////////////////////////////////////////////////////////////
      //Orders Config
      $order = new OrderConfig('company');
      $order->order_id = 0;
      $order->order_format = 3;
      $order->wharehouse_id = $wharehouse->wharehouse_id;
      $order->save();

      //Referrals Config
      $refferalP = new ReferralPConfig('company');
      $refferalP->referralP_id = 0;
      $refferalP->referralP_format = 3;
      $refferalP->wharehouse_id = $wharehouse->wharehouse_id;
      $refferalP->referralP_payment = 1;
      $refferalP->save();

      //Purchases Config
      $purchase = new PurchaseConfig('company');
      $purchase->purchase_id = 0;
      $purchase->purchase_format = 3;
      $purchase->wharehouse_id = $wharehouse->wharehouse_id;
      $purchase->purchase_payment = 1;
      $purchase->save();

      /////////////////////////////////////////////////////////////////////
      /////////////////////////////// SALES //////////////////////////////
      ///////////////////////////////////////////////////////////////////
      //Requests Config
      $request = new RequestConfig('company');
      $request->request_id = 0;
      $request->request_format = 3;
      $request->wharehouse_id = $wharehouse->wharehouse_id;
      $request->save();

      //Referrals Config
      $refferal = new ReferralConfig('company');
      $refferal->referral_id = 0;
      $refferal->referral_format = 3;
      $refferal->wharehouse_id = $wharehouse->wharehouse_id;
      $refferal->referral_payment = 1;
      $refferal->save();

      //Sales Config
      $sale = new SaleConfig('company');
      $sale->sale_id = 0;
      $sale->sale_format = 3;
      $sale->wharehouse_id = $wharehouse->wharehouse_id;
      $sale->sale_payment = 1;
      $sale->save();

      /////////////////////////////////////////////////////////////////////
      /////////////////////////////// PT //////////////////////////////
      ///////////////////////////////////////////////////////////////////
      //PT Config
      $finish = new FinishedProductConfig('company');
      $finish->finished_product_id = 0;
      $finish->finished_product_format = 3;
      $finish->wharehouse_id = $wharehouse->wharehouse_id;
      $finish->save();

      //Transfer Config
      $transfer = new TransferConfig('company');
      $transfer->transfer_id = 0;
      $transfer->transfer_format = 3;
      $transfer->wharehouse_in = $wharehouse->wharehouse_id;
      $transfer->wharehouse_out = $wharehouse->wharehouse_id;
      $transfer->save();
    }

    if ($model->company_id && $_FILES['Companies']['name']['company_logo'] != '') {
      $uploads_dir = 'themes/dashboard/dist/img/';
      $uploads_dir_mail = 'images/mail/';
      $tmp_name = $_FILES["Companies"]["tmp_name"]['company_logo'];
      $archivo = $_FILES["Companies"]["name"]['company_logo'];
      $extension = end(explode(".", $_FILES["Companies"]["name"]['company_logo']));
      $name = Yii::app()->controller->id . '-' . $model->company_id . '.' . $extension;
      if ($errorgd = move_uploaded_file($tmp_name, $uploads_dir . $name)) {
        $model->company_logo = $name;
        move_uploaded_file($tmp_name, $uploads_dir_mail . $name);
      } else {
        print_r($errorgd);
        exit;
      }
      $model->save();
    }
    return $model;
  }

  public static function newCompanyRegister() {

    $model = new Companies;
    $model->attributes = $_POST['Companies'];

    if ($model->save()) {

      /////////////////////////////////////////////////////////////////////
      //////////////////////////// WHAREHOUSE ////////////////////////////
      ///////////////////////////////////////////////////////////////////
      //WhareHouses Create
      $wharehouse = new Wharehouses;
      $wharehouse->company_id = $model->company_id;
      $wharehouse->wharehouse_name = 'CENTRO DE OPERACIONES';
      $wharehouse->wharehouse_phone = $model->company_phone;
      $wharehouse->wharehouse_address = $model->company_address;
      $wharehouse->deparment_id = $model->deparment_id;
      $wharehouse->city_id = $model->city_id;
      $wharehouse->wharehouse_status = 1;
      if (!$wharehouse->save()) {
        Companies::model()->deleteAll('company_id = ' . $model->primaryKey);
        return false;
      }

      /////////////////////////////////////////////////////////////////////
      /////////////////////////////// USERS //////////////////////////////
      ///////////////////////////////////////////////////////////////////
      //User Create
      //User Create
      $user = new User('company');
      $user->attributes = $_POST['User'];
      $user->company_id = $model->company_id;
      $user->user_name = $user->user_id;
      $user->user_passwordhash = md5('admin');
      $user->deparment_id = $model->deparment_id;
      $user->user_phone = $model->company_phone;
      $user->user_address = $model->company_address;
      $user->user_lockoutenabled = 0;
      $user->user_lockoutenddateutc = date('Y-m-d');
      $user->city_id = $model->city_id;
      $user->user_status = 1;
      $user->user_photo = 'user2-160x160.jpg';
      if (!$user->save()) {
        Companies::model()->deleteAll('company_id = ' . $model->primaryKey);
        Wharehouses::model()->deleteAll('wharehouse_id = ' . $wharehouse->primaryKey);
        return false;
      }

      UserExtend::mailUser($user, 'admin');
      //creando rol
      $auth = Yii::app()->authManager;
      $auth->assign('admin', $user->user_id);

      /////////////////////////////////////////////////////////////////////
      ///////////////////////////// PURCHASES ////////////////////////////
      ///////////////////////////////////////////////////////////////////
      //Orders Config
      $order = new OrderConfig('company');
      $order->order_id = 0;
      $order->order_format = 3;
      $order->wharehouse_id = $wharehouse->wharehouse_id;
      if (!$order->save()) {
        Companies::model()->deleteAll('company_id = ' . $model->primaryKey);
        Wharehouses::model()->deleteAll('wharehouse_id = ' . $wharehouse->primaryKey);
        User::model()->deleteAll('user_id = ' . $user->primaryKey);
        return false;
      }

      //Referrals Config
      $refferalP = new ReferralPConfig('company');
      $refferalP->referralP_id = 0;
      $refferalP->referralP_format = 3;
      $refferalP->wharehouse_id = $wharehouse->wharehouse_id;
      $refferalP->referralP_payment = 1;
      if (!$refferalP->save()) {
        Companies::model()->deleteAll('company_id = ' . $model->primaryKey);
        Wharehouses::model()->deleteAll('wharehouse_id = ' . $wharehouse->primaryKey);
        User::model()->deleteAll('user_id = ' . $user->primaryKey);
        OrderConfig::model()->deleteAll('id = ' . $order->primaryKey);
        return false;
      }

      //Purchases Config
      $purchase = new PurchaseConfig('company');
      $purchase->purchase_id = 0;
      $purchase->purchase_format = 3;
      $purchase->wharehouse_id = $wharehouse->wharehouse_id;
      $purchase->purchase_payment = 1;
      if (!$purchase->save()) {
        Companies::model()->deleteAll('company_id = ' . $model->primaryKey);
        Wharehouses::model()->deleteAll('wharehouse_id = ' . $wharehouse->primaryKey);
        User::model()->deleteAll('user_id = ' . $user->primaryKey);
        OrderConfig::model()->deleteAll('id = ' . $order->primaryKey);
        ReferralPConfig::model()->deleteAll('id = ' . $refferalP->primaryKey);
        return false;
      }

      /////////////////////////////////////////////////////////////////////
      /////////////////////////////// SALES //////////////////////////////
      ///////////////////////////////////////////////////////////////////
      //Requests Config
      $request = new RequestConfig('company');
      $request->request_id = 0;
      $request->request_format = 3;
      $request->wharehouse_id = $wharehouse->wharehouse_id;
      if (!$request->save()) {
        Companies::model()->deleteAll('company_id = ' . $model->primaryKey);
        Wharehouses::model()->deleteAll('wharehouse_id = ' . $wharehouse->primaryKey);
        User::model()->deleteAll('user_id = ' . $user->primaryKey);
        OrderConfig::model()->deleteAll('id = ' . $order->primaryKey);
        ReferralPConfig::model()->deleteAll('id = ' . $refferalP->primaryKey);
        PurchaseConfig::model()->deleteAll('id = ' . $purchase->primaryKey);
        return false;
      }

      //Referrals Config
      $refferal = new ReferralConfig('company');
      $refferal->referral_id = 0;
      $refferal->referral_format = 3;
      $refferal->wharehouse_id = $wharehouse->wharehouse_id;
      $refferal->referral_payment = 1;
      if (!$refferal->save()) {
        Companies::model()->deleteAll('company_id = ' . $model->primaryKey);
        Wharehouses::model()->deleteAll('wharehouse_id = ' . $wharehouse->primaryKey);
        User::model()->deleteAll('user_id = ' . $user->primaryKey);
        OrderConfig::model()->deleteAll('id = ' . $order->primaryKey);
        ReferralPConfig::model()->deleteAll('id = ' . $refferalP->primaryKey);
        PurchaseConfig::model()->deleteAll('id = ' . $purchase->primaryKey);
        RequestConfig::model()->deleteAll('id = ' . $request->primaryKey);
        return false;
      }

      //Sales Config
      $sale = new SaleConfig('company');
      $sale->sale_id = 0;
      $sale->sale_format = 3;
      $sale->wharehouse_id = $wharehouse->wharehouse_id;
      $sale->sale_payment = 1;
      if (!$sale->save()) {
        Companies::model()->deleteAll('company_id = ' . $model->primaryKey);
        Wharehouses::model()->deleteAll('wharehouse_id = ' . $wharehouse->primaryKey);
        User::model()->deleteAll('user_id = ' . $user->primaryKey);
        OrderConfig::model()->deleteAll('id = ' . $order->primaryKey);
        ReferralPConfig::model()->deleteAll('id = ' . $refferalP->primaryKey);
        PurchaseConfig::model()->deleteAll('id = ' . $purchase->primaryKey);
        RequestConfig::model()->deleteAll('id = ' . $request->primaryKey);
        ReferralConfig::model()->deleteAll('id = ' . $refferal->primaryKey);
        return false;
      }

      /////////////////////////////////////////////////////////////////////
      /////////////////////////////// INVEN //////////////////////////////
      ///////////////////////////////////////////////////////////////////
      //PT Config
      $finish = new FinishedProductConfig('company');
      $finish->finished_product_id = 0;
      $finish->finished_product_format = 3;
      $finish->wharehouse_id = $wharehouse->wharehouse_id;
      if (!$finish->save()) {
        Companies::model()->deleteAll('company_id = ' . $model->primaryKey);
        Wharehouses::model()->deleteAll('wharehouse_id = ' . $wharehouse->primaryKey);
        User::model()->deleteAll('user_id = ' . $user->primaryKey);
        OrderConfig::model()->deleteAll('id = ' . $order->primaryKey);
        ReferralPConfig::model()->deleteAll('id = ' . $refferalP->primaryKey);
        PurchaseConfig::model()->deleteAll('id = ' . $purchase->primaryKey);
        RequestConfig::model()->deleteAll('id = ' . $sale->primaryKey);
        SaleConfig::model()->deleteAll('id = ' . $refferal->primaryKey);
        return false;
      }

      //Transfer Config
      $transfer = new TransferConfig('company');
      $transfer->transfer_id = 0;
      $transfer->transfer_format = 3;
      $transfer->wharehouse_in = $wharehouse->wharehouse_id;
      $transfer->wharehouse_out = $wharehouse->wharehouse_id;
      if (!$transfer->save()) {
        Companies::model()->deleteAll('company_id = ' . $model->primaryKey);
        Wharehouses::model()->deleteAll('wharehouse_id = ' . $wharehouse->primaryKey);
        User::model()->deleteAll('user_id = ' . $user->primaryKey);
        OrderConfig::model()->deleteAll('id = ' . $order->primaryKey);
        ReferralPConfig::model()->deleteAll('id = ' . $refferalP->primaryKey);
        PurchaseConfig::model()->deleteAll('id = ' . $purchase->primaryKey);
        RequestConfig::model()->deleteAll('id = ' . $sale->primaryKey);
        SaleConfig::model()->deleteAll('id = ' . $refferal->primaryKey);
        FinishedProductConfig::model()->deleteAll('id = ' . $finish->primaryKey);
        return false;
      }

      return $model;
    } else {
      return false;
    }
  }

  // enviando correo de creación de usario, no se termina de configurar no esta en uso.

  public static function mailCompany($order) {

    $supplier = Suppliers::model()->findByPk($order->supplier_nit);

    $mail = new YiiMailer();
    $mail->setView('order');
    $mail->setData(array('model' => $order));
    $mail->setLayout('mailer');
    $mail->setFrom(Yii::app()->params['adminEmail']);
    //$mail->setTo(array('john.cubides87@gmail.com','taromaciro@gmail.com'));
    $mail->setTo(array('john.cubides87@gmail.com', $supplier->supplier_email));
    $mail->setSubject('Orden de Compra # ' . $order->order_consecut);
    //echo Yii::app()->theme->baseUrl.'/adjuntos/prueba.txt';exit;
    $mail->setAttachment(array('themes/dashboard/adjuntos/prueba.txt'));
    $mail->send();
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
    $criteria->addCondition('t.company_status in (0,1)');
    $criteria->compare('company_id', $this->company_id, true);
    $criteria->compare('company_name', $this->company_name, true);
    $criteria->compare('company_phone', $this->company_phone, true);
    $criteria->compare('company_address', $this->company_address, true);
    $criteria->compare('company_logo', $this->company_logo, true);
    $criteria->compare('company_url', $this->company_url, true);
    $criteria->compare('company_status', $this->company_status);
    $criteria->compare('deparment_id', $this->deparment_id);
    $criteria->compare('city_id', $this->city_id);

    $criteria->order = 'company_name ASC';

    return new CActiveDataProvider($this, array(
        'criteria' => $criteria,
    ));
  }

  public static function getUsersByCompany($company) {
    $purifier = Purifier::getInstance();
    $query = Yii::app()->db->createCommand()
            ->select(['u.*'])
            ->from('tbl_user u')
            ->join('AuthAssignment a', "a.userid = u.user_id AND a.itemname <> 'supplier' AND a.itemname <> 'customer'")
            ->where(['u.company_id' => $purifier->purify($company)])
            ->group('u.user_id')
    ;
    return $query->queryAll();
  }

}
