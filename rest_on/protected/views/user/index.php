<?php

use App\User\User as U;

/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */
$user=U::getInstance();
$visible=$user->isAdmin;

$this->menu=array(
  array('label'=>'Crear Usuario','url'=>array('create'),'visible'=>$visible),
);
?>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Usuarios <small>Informaciòn General</small></h3>
        </div>  
        <div class="box-body">

          <div id="User_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
              <div class="col-sm-6"></div>
              <div class="col-sm-6"></div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <?=$this->renderPartial('_admin_grid',['model'=>$model,'admin'=>false]);?>
              </div>
            </div>
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section>