<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name.' - Error';
$this->breadcrumbs=array(
  'Error',
);
?>
<!--
<h2>Error <?php // echo $code;?></h2>

<div class="error">
</div>-->



<!-- Content Wrapper. Contains page content -->
<!-- Content Header (Page header) -->
<div class="page-error">

  <section class="content-header">
    <h1>
      <?php echo $code;?> Pagina de Error
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="#">Acceso reestringido</a></li>
      <li class="active"><?php echo $code;?> error</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="error-page">
      <h2 class="headline text-yellow"><?php echo $code;?></h2>

      <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> <p><?php echo CHtml::encode($message);?></p></h3>


        <p>
          Mientras tanto, es posible <a href="<?=Yii::app()->createAbsoluteUrl('/')?>">regresar al Inicio</a> o intente utilizar el formulario de búsqueda.
        </p>

        <form class="search-form">
          <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar">

            <div class="input-group-btn">
              <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i>
              </button>
            </div>
          </div>
          <!-- /.input-group -->
        </form>
      </div>
      <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
  </section>
  <!-- /.content -->

</div>