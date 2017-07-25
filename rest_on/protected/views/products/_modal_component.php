<div class="modal fade" id="modalComp" tabindex="-1" role="dialog"  >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true" >&times;</span>
        </button>
        <h4 class="modal-title-component" id="myModalLabelComponent">Asignar Componentes</h4>
      </div>
      <div class="modal-body">
        <div class="input-group">
          <span class="input-group-addon ">Producto</span>
          <?php
          echo CHtml::textField('producto','',[
            'id'=>'producto-autocomplete',
            'size'=>'40'
          ]);
          ?>
          <span class="input-group-btn">
            <button class="btn btn-primary btn-add-product">Agregar Producto</button>
          </span>
        </div>
        <div class="alert alert-danger" id="div-errores" style="display: none;">Por favor diligencie todos los datos en rojo e intente guardar nuevamente.</div>
        <div>
          <div style="padding: 10px;">
            <table id="tablaproductos" style="width: 100%;" class="table table-striped table">
              <thead>
                <tr class="titnumbertab">
                  <td style="width: 40%">Producto</td>
                  <td style="width: 25%" align="center">Cantidad</td>
                  <td style="width: 20%;" align="center">Unidad</td>
                  <td></td>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>  
      </div>
      <div class="modal-footer clearfix footer-component">
        <div class="col-sm-6">
          <button id="saveBtn" type="button" class="col-sm-12 btn btn-success btn-lg">Aceptar</button>
        </div>
        <div class="col-sm-6">
          <button type="button" class="col-sm-12 btn btn-danger btn-lg" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</div>