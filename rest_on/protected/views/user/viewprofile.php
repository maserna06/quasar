
<?php /* $this->widget('zii.widgets.CDetailView', array(
  'data'=>$model,
  'attributes'=>array(
  'user_id',
  'user_name',
  'user_firtsname',
  'user_lastname',
  'user_phone',
  'user_address',
  'user_photo',
  'user_email',
  'user_emailconfirmed',
  'user_phonenumber',
  'user_phonenumberconfirmed',
  'user_passwordhash',
  'user_lockoutenddateutc',
  'user_lockoutenabled',
  'user_accessfailcount',
  'deparment_id',
  'city_id',
  'company_id',
  'user_status',
  ),
  )); */
?>
<div class="row">
<div class="col-md-12">
<div class="col-md-3">

    <!-- Profile Image -->
    <div class="box box-primary">
        <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="<?php echo Yii::app()->theme->baseUrl. '/dist/img/'.User::model()->findByPk(YII::app()->user->id)->user_photo ?>" alt="User profile picture">

            <h3 class="profile-username text-center"><?php echo $model->user_firtsname . " " . $model->user_lastname; ?></h3>

            <p class="text-muted text-center"><?php echo $model->user_name; ?></p>

            <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                    <b>Activo desde:</b> <a class="pull-right"><?php echo $model->user_lockoutenddateutc; ?></a>
                </li>
                <li class="list-group-item">
                    <b>Dirección:</b> <a class="pull-right"><?php echo $model->user_address; ?></a>
                </li>
                <li class="list-group-item">
                    <b>Telefono:</b> <a class="pull-right"><?php echo $model->user_phone; ?></a>
                </li>
            </ul>

            <!--<a href="#" class="btn btn-primary btn-block"><b>Seguir</b></a>-->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <!-- About Me Box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Sobre mí</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <strong><i class="fa fa-book margin-r-5"></i> Empresa</strong>

            <p class="text-muted">
                <?php
                if (!empty($model->company_id)) {
                    $company = Companies::model()->findByPk($model->company_id);
                    echo $company->company_name;
                } else {
                    echo "";
                }
                ?>
            </p>

            <hr>

            <strong><i class="fa fa-map-marker margin-r-5"></i> Ubicacion</strong>

            <p class="text-muted"> 
                <?php
                if (!empty($model->city_id)) {
                    $city = Cities::model()->findByPk($model->city_id);
                    echo $city->city_name;
                } else {
                    echo "";
                }
                echo ", ";
                if (!empty($model->deparment_id)) {
                    $deparment = Departaments::model()->findByPk($model->deparment_id);
                    echo $deparment->deparment_name;
                } else {
                    echo "";
                }
                ?></p>

            <hr>

            <strong><i class="fa fa-pencil margin-r-5"></i> Roles</strong>

            <p>
                <?php foreach (Yii::app()->authManager->getAuthItems(2, $model->user_id) as $data): ?>
                    <span class="label label-success"><?php echo strtoupper($data->name); ?></span>
                <?php endforeach; ?>
            </p>

            <hr>

            <strong><i class="fa fa-file-text-o margin-r-5"></i> Estado Actual</strong>

            <p><?php
                if ($model->user_status == "1") {
                    echo "Activo";
                } else {
                    echo "Inactivo";
                }
                ?></p>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>

<div class="col-md-9">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <!--<li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Línea de tiempo</a></li>-->
            <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="false">Ajustes</a></li>
        </ul>
        <div class="tab-content">      
            <!--<div class="tab-pane" id="timeline">
                
                <ul class="timeline timeline-inverse">
                    
                    <li class="time-label">
                        <span class="bg-red">
                            10 Sep. 2016
                        </span>
                    </li>
                    
                    <li>
                        <i class="fa fa-envelope bg-blue"></i>

                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                            <h3 class="timeline-header"><a href="#">Activacion de cuenta</a> se te ha enviado un email</h3>

                            <div class="timeline-body">
                                Bienvenido!, el sistema POS se alegra de contar con tu participacion,
                                es muy grato para nosotros poder servir como apoyo a las necesidades
                                de su empresa, esperamos tenga una...
                            </div>
                            <div class="timeline-footer">
                                <a class="btn btn-primary btn-xs">Leer mas</a>
                                <a class="btn btn-danger btn-xs">Borrar</a>
                            </div>
                        </div>
                    </li>
                    
                    <li>
                        <i class="fa fa-user bg-aqua"></i>

                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> 2 hrs atras</span>

                            <h3 class="timeline-header no-border"><a href="#">Daniel Ciro</a> te envia una solicitud de acceso
                            </h3>
                        </div>
                    </li>
                    
                    <li>
                        <i class="fa fa-comments bg-yellow"></i>

                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> 4hrs atras</span>

                            <h3 class="timeline-header"><a href="#">Super Administrador</a> crea un comentario</h3>

                            <div class="timeline-body">
                                Sistema POS!
                                Enfocado para las necesidades de las empresas, el sistema POS ya se encuentra en el mercado!
                                Felicitamos a los participantes y clientes!
                            </div>
                            <div class="timeline-footer">
                                <a class="btn btn-warning btn-flat btn-xs">Ver comentario</a>
                            </div>
                        </div>
                    </li>
                    
                    <li class="time-label">
                        <span class="bg-green">
                            1 Sep. 2016
                        </span>
                    </li>
                    
                    <li>
                        <i class="fa fa-camera bg-purple"></i>

                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> 12 dias atras</span>

                            <h3 class="timeline-header"><a href="#">Daniel Ciro</a> Actualiza fotos de usuarios</h3>

                            <div class="timeline-body">
                                <img src="http://placehold.it/150x100" alt="..." class="margin">
                                <img src="http://placehold.it/150x100" alt="..." class="margin">
                                <img src="http://placehold.it/150x100" alt="..." class="margin">
                                <img src="http://placehold.it/150x100" alt="..." class="margin">
                            </div>
                        </div>
                    </li>
                    <li>
                        <i class="fa fa-clock-o bg-gray"></i>
                    </li>
                </ul>
            </div>-->

            <div class="tab-pane active" id="settings">        
                <div class="row-fluid">
                    <h2 class="page-header">
                        <i class="fa fa-group"></i> Roles
                        <small class="pull-right">Estado</small>
                    </h2>
                    <?php echo $this->renderPartial('_roles',['model'=>$model]); ?>
                </div>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'user-form',
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                        'validateOnType' => true,
                    ),
                ));
                ?>
                <div class="row-fluid">
                    <h2 class="page-header">
                        <i class="fa fa-globe"></i> Modificar Contraseña
                        <small class="pull-right">Nueva Contraseña</small>
                    </h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Contraseña Actual</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-asterisk"></i>
                                    </div>
                                    <?php echo $form->passwordField($model, 'old_password', array('class' => 'form-control', 'placeholder' => 'Ingrese Contraseña Actual')); ?>
                                </div><!-- /.input group -->
                                <br><?php echo $form->error($model, 'old_password', array('class' => 'alert alert-danger')); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nueva Contraseña</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-asterisk"></i>
                                    </div><!--<?php #echo $form->textField($model, 'user_name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control'));     ?>-->
                                    <?php echo $form->passwordField($model, 'new_password', array('class' => 'form-control', 'placeholder' => 'Ingrese Nueva Contraseña')); ?>
                                </div><!-- /.input group -->
                                <br><?php echo $form->error($model, 'new_password', array('class' => 'alert alert-danger')); ?>
                                <!--<br><?php #echo $form->error($model, 'user_name', array('class' => 'alert alert-danger'));     ?>-->
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Confirme Contraseña</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-asterisk"></i>
                                    </div><!--<?php #echo $form->textField($model, 'user_name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control'));     ?>-->
                                    <?php echo $form->passwordField($model, 'repeat_password', array('class' => 'form-control', 'placeholder' => 'Confirme Contraseña')); ?>
                                </div><!-- /.input group -->
                                <br><?php echo $form->error($model, 'repeat_password', array('class' => 'alert alert-danger')); ?>
                                <!--<br><?php #echo $form->error($model, 'user_name', array('class' => 'alert alert-danger'));     ?>-->
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">			
                                    <?php echo CHtml::submitButton('Cambiar Contraseña', array('class' => 'btn btn-block btn-success btn-lg')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
                
            </div>
        </div>
    </div>
</div>
</div>
</div>