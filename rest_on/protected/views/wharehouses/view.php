<?php
/* @var $this WharehousesController */
/* @var $model Wharehouses */

Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/dist/js/html2canvas.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/bootstrap/css/bootstrap.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/dist/css/AdminLTE.min.css');

use App\User\User as U;

$user = U::getInstance();
$isAdmin = $user->isAdmin;
$visible = $user->isAdmin;

$this->menu = array(
    array('label' => 'Crear Bodega', 'url' => array('create'), 'visible' => $visible),
    array('label' => 'Actualizar Bodega', 'url' => array('update', 'id' => $model->wharehouse_id)),
    array('label' => ($isAdmin ? 'Administrar' : 'Ver') . ' Bodegas', 'url' => array('index')),
);

//Load MultiCash
foreach ($users as $user){
  $multicash = $user['multicash'];
}

?>

<section class="invoice" id="section-to-print"><!-- title row -->
  <div class="row">
    <div class="col-xs-12">
      <h2 class="page-header">
        <i class="fa fa-file-text"></i> Detalle de Bodega
        <small class="pull-right">Fecha: <?php echo date('Y-m-d'); ?></small>
      </h2>
    </div><!-- /.col -->
  </div><!-- info row -->
  <div class="row invoice-info">
    <div class="col-sm-4 invoice-col">
      <strong>Bodega</strong>    
      <address>
        <strong><?php echo $model->wharehouse_name; ?></strong>
      </address>
    </div><!-- /.col -->
    <div class="col-sm-6 invoice-col">
      <strong>Datos bodega</strong>
      <address>
        Direccion: <?php echo $model->wharehouse_address ?><br>
        Tel&eacute;fono: <?php echo $model->wharehouse_phone ?>
      </address>
    </div><!-- /.col -->
    <div class="col-sm-2 invoice-col">
      <div class="btnGeneral" style="text-align: right;"><?php if($multicash == 0 && $multicash != ''){ echo "<i name='btn_configG' class='fa fa-gears configGeneral'></i>"; } ?></div>
    </div><!-- /.col -->
  </div><!-- /.row -->
  <br>
  <!-- Table row -->
  <div class="row">
    <div class="col-sm-12 invoice-col">
      <h2 class="page-header">
        <i class="fa fa-users"></i> Panel de usuarios Vendedores
        <small class="pull-right"> Asignación de vendedores a la Bodega.</small>
      </h2>
    </div><!-- /.col -->

    <div class="col-sm-6 margin-bottom">
    </div>
    <form class="col-sm-6" onsubmit="return false;">
      <div class="form-group">

        <div class="input-group">
          <span class="input-group-addon ">Vendedor</span>
          <?php
          echo CHtml::textField('producto', '', [
              'id' => 'vendor-autocomplete',
              'size' => '40'
          ]);
          ?>
          <span class="input-group-btn">
            <button class="btn btn-primary btn-add-vendor">Agregar</button>
          </span>
        </div>
      </div>
    </form>
    <div class="col-sm-12">
      <div id="inner-content-users">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
          <table class="table table-striped table-bordered" id="edit-wharehouses-users">
            <thead>
              <tr class="tblEncabezado">
                <th>Id</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Estado</th>
                <?php if($multicash == 1 && $multicash != ''){ echo "<th>Config</th>"; } ?>
                <th></th>
              </tr>
            </thead>
            <tbody id="edit-wharehouses-users">
              <?php foreach ($users as $user): ?>
                <tr>
                  <td><?php echo $user['user_id'] ?></td>
                  <td><?php echo $user['user_name'] ?></td>
                  <td><?php echo $user['user_firtsname'] . ' ' . $user['user_lastname'] ?></td>
                  <td><?php echo ($user['user_status']) ? 'Activo' : 'Inactivo'; ?></td>
                  <?php if($multicash == 1 && $multicash != ''){ echo "<td><i name='btn_configU' id='". $user['user_id'] ."' class='fa fa-gears configUser'></i></td>"; } ?>
                  <td><?php
                    echo CHtml::link(
                            "On", array("wharehouses/removeuser", "id" => $model->wharehouse_id, "item" => $user['user_id']), array("class" => "btn btn-success pull-right")
                    );
                    ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="col-sm-1"></div>
      </div>
    </div><!-- /.col -->
  </div><!-- /.row -->
  <br>
  <!-- this row will not appear when printing -->
  <br>
  <!-- this row will not appear when printing -->
  <div class="row no-print">
    <div class="col-xs-12">
      <a href="#" target="_blank" class="btn btn-default printing" data-section="section-to-print"><i class="fa fa-print"></i> Imprimir</a>
      <a href="javascript:;" target="_blank" class="btn btn-primary pull-right to-canvas" style="margin-right: 5px;">
        <i class="fa fa-download"></i> Generar PDF
      </a>
    </div>
  </div>
  <form id="form_save_pdf" name="form_save_pdf" target="_blank" method="post" action="<?= Yii::app()->createAbsoluteUrl('wharehouses/' . $model->wharehouse_id, ['format' => 'pdf']) ?>">
    <input type="hidden" name="image" id="image-to-pdf" />
  </form>
</section>

<?php $this->renderPartial('modalConfig', ['model' => $model]); ?>


<script>
  //Is Multicash
  function isMulticash(datos)
  {
    $('.btnGeneral').html("");
    $('.tblEncabezado').html("<th>Id</th><th>Usuario</th><th>Nombre</th><th>Estado</th><th>Config</th><th></th>");
    var $rowUser = '<td>' + datos['user_id'] + '</td>';
    $rowUser += '<td>' + datos['user_name'] + '</td>';
    $rowUser += '<td>' + datos['user_firtsname'] + ' ' + datos['user_lastname'] + '</td>';
    $rowUser += '<td>' + (datos['user_status'] ? 'Activo' : 'Inactivo') + '</td>';
    $rowUser += "<td><i name='btn_configU' id='"+ datos['user_id'] +"' class='fa fa-gears'></i></td>";
    $rowUser += '<td>' + datos['link'] + '</td>';
    $('.'+ datos['user_id']).html($rowUser);
  }

  //Not Multicash
  function notMulticash(datos)
  {
    $('.btnGeneral').html("<i name='btn_configG' class='fa fa-gears configGeneral'></i>");
  }

  //Send Data
  function sendVendor(form, hasError) {
    data = $("#wharehouses-form").serialize();
    var formData = new FormData(document.getElementById("wharehouses-form"));
    if (!hasError) {
        $.ajax({
            url: '<?=Yii::app()->createUrl('wharehouses/savevendoroptions')?>',
            method: 'post',
            dataType: "html",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
              var datos = $.parseJSON(data);       
              if(datos['estado'] == "success"){
                $('#modal-config').modal('hide');
                var multicash = datos['multicash'];
                //Switch Data
                switch(multicash)
                {
                  case 0 : notMulticash(datos);
                    break;
                  case 1 : isMulticash(datos);
                    break;
                }
              }
            }
        });
    }
    // Always return false so that Yii will never do a traditional form submit
    return false;
  }

  jQuery(function ($) {
    var $saveBtn = $('#saveVendor');
    var userVendor = null, wharehouseVendor = null;

    $('.to-canvas').on('click', function () {
      var invoice = $('.invoice');
      $('.no-print').hide();

      Modal.show('Generando archivo PDF...<br /> Debe habilitar las ventanas emergentes para poder visualizarlo.');
      html2canvas(invoice[0], {
        onrendered: function (canvas) {
          Modal.show('El achivo se ha generado correctamente. <br />Si no lo visualiza debe habilitar las ventanas emergentes.');
          $('.no-print').show();

          var form = document.form_save_pdf;
          form.image.value = canvas.toDataURL("image/png");
          form.submit();
        }
      });
    });

    //  yu add
    $('#inner-content-users').slimScroll({
      height: '300px',
      railVisible: true,
      alwaysVisible: true
    });
    var $wharehousesUser = $('#edit-wharehouses-users');
    if ($wharehousesUser.length) {
      /**
       * Ajax request to change role
       * @param {string} url
       * @param {function} callback
       * @returns {jqAjaxObject}
       */
      function removeUser(url, callback) {
        return $.ajax({
          url: url,
          method: 'post',
          dataType: 'json',
          success: callback
        });
      }

      function configWharehouse(multicash)
      {
        //Call myModal with Structure Config
        $("#modal-config").modal({keyboard: false});
        $(".modal-dialog").width("30%");
        //Initial Values
        $("#WharehousesUser_user_id").val(userVendor);
        $("#WharehousesUser_wharehouse_id").val(wharehouseVendor);
        if(multicash == 1)
          $('#WharehousesUser_multicash').bootstrapToggle('on');
        else
          $('#WharehousesUser_multicash').bootstrapToggle('off');
        $('#WharehousesUser_daily_close').bootstrapToggle('on');
        $('#WharehousesUser_apply_datafono').bootstrapToggle('off');
        $("#WharehousesUser_cash_ip").val('');
        $("#WharehousesUser_cash_port").val('');
        $("#WharehousesUser_dataphone_ip").val('');
        $("#WharehousesUser_dataphone_port").val('');
        $("#WharehousesUser_dataphone_name").val('');
      }

      $wharehousesUser.on('click', 'a.btn', function (e) {
        e.preventDefault();
        var $this = $(this),
                successClass = 'btn-success',
                dangerClass = 'btn-danger'
                ;
        if ($this.attr('disabled') == 'disabled')
          return false;
        $this.attr('disabled', 'disabled');
        removeUser(this.href, function (response) {
          $this.removeAttr('disabled');
          if (!response.error) {
            $this.parents('tr').fadeOut(300, function () {
              $(this).remove();
            });
          } else {
            showMessage(response.error);
          }
        });
      });
    }

    //Object Attributes
    var $addVendorBtn = $('.btn-add-vendor'),
    $autocompleteInput = $('#vendor-autocomplete'),
    currentComponentSelected = null;

    if ($autocompleteInput.length) {
      $autocompleteInput.autocomplete({
        source: function (request, response) {
          wharehouseVendor = '<?php echo $model->wharehouse_id; ?>';
          $.ajax({
            url: '<?php echo Yii::app()->createUrl('wharehouses/getUsers/' . $model->wharehouse_id); ?>',
            dataType: "json",
            data: {
              term: request.term
            },
            success: function (data) {
              response(data);
            }
          });
        },
        minLength: 1,
        select: function (event, ui) {
          $autocompleteInput.val(ui.item.value);
          currentComponentSelected = ui.item;
          return false;
        }

      });

      $addVendorBtn.on('click', function (e) {
        e.preventDefault();
        if (!currentComponentSelected)
          return false;
        //Asing Value
        userVendor = currentComponentSelected.id;

        $.ajax({
          url: currentComponentSelected.linkAjax,
          dataType: "json",
          data: {
            user: currentComponentSelected.id
          },
          success: function (set) {
            var $rowUser = '<tr class="' + set.data.user_id + '">';
            $rowUser += '<td>' + set.data.user_id + '</td>';
            $rowUser += '<td>' + set.data.user_name + '</td>';
            $rowUser += '<td>' + set.data.user_firtsname + ' ' + set.data.user_lastname + '</td>';
            $rowUser += '<td>' + (set.data.user_status ? 'Activo' : 'Inactivo') + '</td>';
            if(set.data.multicash == 1){
              $('.btnGeneral').html("");
              $rowUser += "<td><i name='btn_configU' id='"+ set.data.user_id +"' class='fa fa-gears'></i></td>";
            }
            else
              $('.btnGeneral').html("<i name='btn_configG' class='fa fa-gears configGeneral'></i>");
            $rowUser += '<td>' + set.data.link + '</td>';
            $rowUser += '</tr>';
            $autocompleteInput.val('');
            $('#edit-wharehouses-users').append($rowUser);

            //Validate View Modal
            if(set.data.openModal == 1)
              configWharehouse(set.data.multicash);
          }
        });
      });
    }
    //Send All Event
    $saveBtn.on('click', sendVendor);
  });
</script>