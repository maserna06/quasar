<style>
.modal {
  text-align: center;
  padding: 0!important;
}

.modal:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -4px;
}

.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
}
</style>

<!-- Modal cancelar formulario-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" >&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Borrar Datos</h4>
      </div>
      <div class="modal-body">
          <div id="bodyArchivos" class="row bodyArchivos">    </div>
      </div>
      <div class="modal-footer">
        
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