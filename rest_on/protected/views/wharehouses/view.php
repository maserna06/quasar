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
    <div class="col-sm-2 invoice-col" style="text-align: right;">
      <i class="fa fa-gears configGeneral" rel="tooltip" data-toggle="tooltip" data-original-title="Configuración General" style="cursor: pointer; color: #3c8dbc; display: none;"></i>
      <input type="hidden" class="multicash" value="<?php echo ($multicash != '')?$multicash:'#'; ?>">
      <input type="hidden" class="wharehouse_id" value="<?php echo $model->wharehouse_id; ?>">
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
          <table class="table table-striped table-bordered" id="head-edit-wharehouses-users">
            <thead>
              <tr class="tblEncabezado">
                <th>Id</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th class='columConfig' style="display: none;">Config</th>
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
                  <td class='columConfig' style="display: none;">
                  <?php 
                    echo "<i class='fa fa-gears configUser' name=". $user['user_id'] ." rel='tooltip' data-toggle='tooltip' data-original-title='Configuración Usuario' style='cursor: pointer; color: #3c8dbc;'></i>"; 
                  ?>
                  </td>
                  <td>
                  <?php
                    echo CHtml::link("On", array("wharehouses/removeuser", "id" => $model->wharehouse_id, "item" => $user['user_id']), array("class" => "btn btn-success pull-right"));
                  ?>                      
                  </td>
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
    //Hide General Config and Table Vendors
    $('.configGeneral').hide();
    $('#edit-wharehouses-users').html("");
    //Create Table Vendors with Config
    $('.tblEncabezado').html("<th>Id</th><th>Usuario</th><th>Nombre</th><th>Estado</th><th>Config</th><th></th>");
    $.each(datos['users'], function( i, val )
    {
      var $rowUser = '<tr class="' + val.user_id + '">';
      $rowUser += '<td>' + val.user_id + '</td>';
      $rowUser += '<td>' + val.user_name + '</td>';
      $rowUser += '<td>' + val.user_firtsname + ' ' + val.user_lastname + '</td>';
      $rowUser += '<td>' + (val.user_status ? 'Activo' : 'Inactivo') + '</td>';
      $rowUser += "<td class='columConfig'><i class='fa fa-gears configUser' name="+ val.user_id +" rel='tooltip' data-toggle='tooltip' data-original-title='Configuración Usuario' style='cursor: pointer; color: #3c8dbc;'></i></td>";     
      $rowUser += '<td>' + val.link + '</td>';
      $rowUser += '</tr>';
      $('#edit-wharehouses-users').append($rowUser);
    });
  }

  //Not Multicash
  function notMulticash(datos)
  {
    $('#edit-wharehouses-users').html("");
    //Create Table Vendors not Config
    $('.tblEncabezado').html("<th>Id</th><th>Usuario</th><th>Nombre</th><th>Estado</th><th></th>");
    $.each( datos['users'], function( i, val )
    {
      var $rowUser = '<tr class="' + val.user_id + '">';
      $rowUser += '<td>' + val.user_id + '</td>';
      $rowUser += '<td>' + val.user_name + '</td>';
      $rowUser += '<td>' + val.user_firtsname + ' ' + val.user_lastname + '</td>';
      $rowUser += '<td>' + (val.user_status ? 'Activo' : 'Inactivo') + '</td>';
      $rowUser += '<td>' + val.link + '</td>';
      $rowUser += '</tr>';
      $('#edit-wharehouses-users').append($rowUser);
    });
    //Show General Config
    $('.configGeneral').show();
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
              }else if(datos['estado'] == "danger")
                $('.dataphone').css({"border-color": "red"})
            }
        });
    }
    // Always return false so that Yii will never do a traditional form submit
    return false;
  }

  jQuery(function ($) {
    //Hide ConfigGeneral
    if($('.multicash').attr('value') == 1 || $('.multicash').attr('value') == '#'){
      $('.configGeneral').hide();
      $('.columConfig').show();
    }else{
      $('.configGeneral').show();
      $('.columConfig').hide();
    }
    //Load Buttons
    var $saveBtn = $('#saveVendor'),
    $configGeneral = $('.configGeneral'),
    $configUser = $('.configUser');
    var userVendor = null, wharehouseVendor = null;
    //Print PDF
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

      //First Config
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

      //General & Users Config
      function configWharehouseAdvance(user_id = null)
      {
        var wharehouse_id = $('.wharehouse_id').attr('value');
        //Call myModal with Structure Config
        $("#modal-config").modal({keyboard: false});
        $(".modal-dialog").width("30%");
        //Initial Values
        $("#WharehousesUser_user_id").val((user_id.length)?user_id:"#");
        $("#WharehousesUser_wharehouse_id").val(wharehouse_id);
        //Load Data WhareHouses
        $.ajax({
          url: '<?php echo Yii::app()->createUrl('wharehouses/getWharehouse/'); ?>',
          dataType: "json",
          data: {
            wharehouseVendor : wharehouse_id,
            user_id : (user_id.length)?user_id:"#"
          },
          success: function (datos) {  
            var apply_datafono = 'off',
                cash_ip = '', cash_port = '', 
                dataphone_ip = '', dataphone_port = '', dataphone_name = '',
                daily_close = (datos[0]['daily_close'] == 1) ? 'on' : 'off',
                multicash = (datos[0]['multicash'] == 1) ? 'on' : 'off';
            if(datos[0]['cash_ip'] != '' && datos[0]['cash_ip'] != 0){
              apply_datafono = 'on';
              cash_ip = datos[0]['cash_ip'];
              cash_port = datos[0]['cash_port'];
              dataphone_ip = datos[0]['dataphone_ip'];
              dataphone_port = datos[0]['dataphone_port'];
              dataphone_name = datos[0]['dataphone_name'];
            }
            $('#WharehousesUser_multicash').bootstrapToggle(multicash);
            $('#WharehousesUser_daily_close').bootstrapToggle(daily_close);
            $('#WharehousesUser_apply_datafono').bootstrapToggle(apply_datafono);
            $("#WharehousesUser_cash_ip").val(cash_ip);
            $("#WharehousesUser_cash_port").val(cash_port);
            $("#WharehousesUser_dataphone_ip").val(dataphone_ip);
            $("#WharehousesUser_dataphone_port").val(dataphone_port);
            $("#WharehousesUser_dataphone_name").val(dataphone_name);
          }
        });        
      }

      $wharehousesUser.on('click', 'a.btn', function (e) {
        e.preventDefault();
        var $this = $(this),
        successClass = 'btn-success',
        dangerClass = 'btn-danger';
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
        //Delete Object Config General
        var $haveUsers = $('#edit-wharehouses-users tr');
        if ($haveUsers.length == 1)
          $('.configGeneral').hide();
      });
    }

    //Object Attributes
    var $addVendorBtn = $('.btn-add-vendor'),
    $autocompleteInput = $('#vendor-autocomplete'),
    currentVendorSelected = null;

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
          currentVendorSelected = ui.item;
          return false;
        }
      });

      $addVendorBtn.on('click', function (e) {
        e.preventDefault();
        if (!currentVendorSelected)
          return false;
        //Asing Value
        userVendor = currentVendorSelected.id;

        $.ajax({
          url: currentVendorSelected.linkAjax,
          dataType: "json",
          data: {
            user: currentVendorSelected.id
          },
          success: function (set) {
            var $rowUser = '<tr class="' + set.data.user_id + '">';
            $rowUser += '<td>' + set.data.user_id + '</td>';
            $rowUser += '<td>' + set.data.user_name + '</td>';
            $rowUser += '<td>' + set.data.user_firtsname + ' ' + set.data.user_lastname + '</td>';
            $rowUser += '<td>' + (set.data.user_status ? 'Activo' : 'Inactivo') + '</td>';
            //Validate Multicash
            if(set.data.multicash == 1){
              $('.configGeneral').hide();
              $rowUser += "<td class='columConfig'><i class='fa fa-gears configUser' name="+ set.data.user_id+" rel='tooltip' data-toggle='tooltip' data-original-title='Configuración Usuario' style='cursor: pointer; color: #3c8dbc;'></i></td>";
            }
            else{
              $('.configGeneral').show();
              $('.columConfig').hide();
            }

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
    //Send All Events
    $saveBtn.on('click', sendVendor);
    $configGeneral.on('click', configWharehouseAdvance);
    $configUser.on('click', function () {
      configWharehouseAdvance($(this).attr('name'));
    });
  });
</script>