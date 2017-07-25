

<!-- Modal cancelar formulario-->
<div class="modal fade" id="myModalCancel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Borrar Datos</h4>
      </div>
      <div class="modal-body">
        ¿Desea eliminar todos los datos ingresados al formulario sin guardar?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">NO</button>
        <button id="cerrar" type="reset" class="btn btn-danger">SI</button>
      </div>
    </div>
  </div>
</div>
<!-- Fin modal -->
<script>
$('#cerrar').click(function () {
   $('#myModalCancel').modal('hide');
});
</script>