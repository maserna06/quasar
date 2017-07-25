<?php

use App\User\User as U;
use App\User\Role;
use App\Utils\Purifier;

/**
 * Modelo extendido de User por si hay actualizaciones en base de datos 
 * y se genera el modelo por GII no se vean afectadas las funciones personalizadas
 */
class UserExtend extends User {
    
    public function rules() {
         return array(
            array('user_email', 'validate_mail', 'on' => 'recoverypass'),
             );
    }
    
    public function validate_mail($attr, $param) {
        
        $user = User::model()->findAll('user_email = '.$this[$attr]);
        if (!$user) {
            $this->addError($attr, "La contraseña no coincide");
        }
    }

    public static function newUser($user = NULL) {
        $purifier = Purifier::getInstance();
        $userLogged = U::getInstance();
        $attributes = $purifier->purify($_POST['User']);

        if ($userLogged->isOnlyAdmin()) {
            $attributes['company_id'] = $userLogged->companyId;
        }
        if ($user) {
            $model = User::model()->findByPk($user); // si $user es diferente de null declara el modelo del producto aeditar
            $pass = $model->user_passwordhash;
        } else
            $model = new User; // Producto para crear

        // se valida si el archivo ya existe y no se va a reempazar
        $archivo = (!$model->user_photo) ? 'user2-160x160.jpg' : $model->user_photo;
        $model->attributes = $attributes;
        $model->user_photo = $archivo;

        if ($user) {
            $model->user_passwordhash = $pass;
        } else {
            $pass = $model->user_passwordhash;
            $model->user_passwordhash = md5($model->user_passwordhash);
            $model->repeat_password = md5($attributes['repeat_password']);
        }

        if ($model->user_id && $_FILES) { // si viene archivo y existe el producto se reliza al carga del archivo al servidor
            $uploads_dir = 'themes/dashboard/dist/img/';
            $tmp_name = $_FILES["User"]["tmp_name"]['user_photo'];
            $archivo = $_FILES["User"]["name"]['user_photo'];
            $extension = CFileHelper::getExtension($_FILES["User"]["name"]['user_photo']); //end(explode(".",$_FILES["User"]["name"]['user_photo']));
            $name = Yii::app()->controller->id . '-' . $model->user_id . '.' . $extension;
            if (move_uploaded_file($tmp_name, $uploads_dir . $name)) {
                $model = $model = User::model()->findByPk($model->user_id);
                $model->user_photo = $name;
            }
            $model->save();
        }
        
        if($model->user_email && !$user)
            UserExtend::mailUser($model, $pass);

        if (!$model->save()) {
            return $model;
            exit;
        }
        
        return $model;
    }
    /*
     * Enviando correo al crear usuario.
     */
    
    public static function mailUser($modelUser, $password) {        
        $mail = new YiiMailer();
        $mail->setView('user');
        $mail->setData(array('model' => $modelUser,'password'=>$password));
        $mail->setLayout('mailer');
        $mail->setFrom(Yii::app()->params['adminEmail']);
        $mail->setTo(array('taromaciro@hotmail.com',$modelUser->user_email));
        $mail->setSubject('Datos de acceso');
        //$mail->setAttachment(array('themes/dashboard/adjuntos/prueba.txt'));
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

    public static function bodegasUser($id) {

        $user = User::model()->findByPk($id);
        if ($user->company_id) {
            $bodegas = Wharehouses::model()->findAll('wharehouse_status=1 and company_id = "' . $user->company_id . '"');
            $datos = array();
            $i = 0;
            foreach ($bodegas as $bod) {
                $bodUser = WharehousesUser::model()->findByAttributes(array('wharehouse_id' => $bod->wharehouse_id, 'user_id' => $id));
                $datos[$i]['id'] = $bod->wharehouse_id;
                $datos[$i]['name'] = $bod->wharehouse_name;
                $datos[$i]['estado'] = ($bodUser) ? 'On' : 'Off';
                $i++;
            }
            return $datos;
        } else {
            return array();
        }
    }

    public static function bodSave() {
        $att = array('user_id' => $_GET['user'], 'wharehouse_id' => $_GET['bod']);
        if ($_GET['accion'] == 1) {
            $tax = new WharehousesUser;
            $tax->attributes = $att;
            $tax->save();
            return 'Impuesto asignado correctamente.';
        } else {
            $tax = WharehousesUser::model()->deleteAllByAttributes($att);
            return 'Impuesto desasignado correctamente.';
        }
    }

    public static function userCompany() {
        $users = User::model()->findAll('company_id = ' . Yii::app()->getSession()->get('empresa'));
        $datos = array();
        $i = 0;
        foreach ($users as $us) {
            if ($us->user_status == 1) {
                $datos[$i]['id'] = $us->user_id;
                $datos[$i]['name'] = $us->user_name;
            }
            $i++;
        }
        return CHtml::listData($datos, 'id', 'name');
    }
    
    public static function generaPass(){
        //Se define una cadena de caractares. Te recomiendo que uses esta.
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890#*/";
        //Obtenemos la longitud de la cadena de caracteres
        $longitudCadena=strlen($cadena);
         
        //Se define la variable que va a contener la contraseña
        $pass = "";
        //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
        $longitudPass=10;
         
        //Creamos la contraseña
        for($i=1 ; $i<=$longitudPass ; $i++){
            //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
            $pos=rand(0,$longitudCadena-1);
         
            //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
            $pass .= substr($cadena,$pos,1);
        }
        return $pass;
    }

}
