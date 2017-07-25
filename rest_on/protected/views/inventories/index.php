<?php
/* @var $this InventoriesController */
/* @var $dataProvider CActiveDataProvider */

$visible = 0;

//Validate Visibility
if (Yii::app()->user->checkAccess("super") || Yii::app()->user->checkAccess("admin"))
  $visible = 1;

/* $this->menu=array(
  array('label'=>'Crear Inventories', 'url'=>array('create'), 'visible'=>$visible),
  array('label'=>'Administrar Inventories', 'url'=>array('admin'), 'visible'=>$visible),
  ); */

if ($companies) {
  $dropdownCompany[] = 'Seleccionar empresa';
  foreach ($companies as $company) {
    $dropdownCompany[$company->company_id] = $company->company_name;
  }
}
?>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Inventario <small>Informaciòn General de Productos en Inventario</small></h3>
        </div>  

        <div class="col-xs-12 col-sm-12">
          <div class='view-options pull-right'>
            <label for="view-12" class='type12' rel="tooltip" data-toggle="tooltip" title="" data-original-title="Vista tabla">
              <input <?php echo ($view == '12') ? 'checked' : ''; ?> type='radio' name="viewtype" value="12" id="view-12">
            </label>
            <label for="view-222222" class='type222222' rel="tooltip" data-toggle="tooltip" title="" data-original-title="Vista 8 columnas">
              <input <?php echo ($view == '222222') ? 'checked' : ''; ?> type='radio' name="viewtype" value="222222" id="view-222222">
            </label>
            <label for="view-3333" class='type3333' rel="tooltip" data-toggle="tooltip" title="" data-original-title="Vista 4 columnas">
              <input <?php echo ($view == '3333' || empty($view)) ? 'checked' : ''; ?> type='radio' name="viewtype" value="3333" id="view-3333">
            </label>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6 margin-bottom">

          <?php if ($companies) { ?>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon ">Empresa</span>
                <?php
                echo CHtml::dropDownList('company', false, $dropdownCompany, [
                    'id' => 'companies-select'
                ]);
                ?>
                <span class="input-group-btn">
                  <button class="btn btn-primary btn-search-product">Buscar</button>
                </span>
              </div>
            </div>
          <?php } ?>

        </div>
        <form class="col-xs-12 col-sm-6" onsubmit="return false;">
          <div class="form-group">

            <div class="input-group">
              <span class="input-group-addon ">Producto</span>
              <?php
              echo CHtml::textField('producto', '', [
                  'id' => 'product-autocomplete',
                  'size' => '40',
                  'data-url' => Yii::app()->createUrl('inventories/index/'),
                  'data-source' => Yii::app()->createUrl('inventories/getSearch/')
              ]);
              ?>
              <span class="input-group-btn">
                <button class="btn btn-primary btn-search-product">Buscar</button>
              </span>
            </div>
          </div>
        </form>

        <div class="box-body">
          <div id="Inventories_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <?php $this->renderPartial($render, array('products' => $model['data'])); ?>
          </div>
          <div>
            <div class="row-fluid">
              <div class="col-sm-12">
                <div id="paginator" class="pull-right"><?php echo $model['paginator']; ?></div>
              </div>
            </div>
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section>
<script>
var urlDetailProduct = '<?php echo Yii::app()->createUrl('inventories/getProductDetail');?>';
</script>
<?php $this->renderPartial('_modal_product');