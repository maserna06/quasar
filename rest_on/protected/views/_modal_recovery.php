

<!-- Modal cancelar formulario-->
<div class="modal fade" id="myModalPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="z-index: 2001;">
    <div class="modal-dialog" role="document">
        <div class="" >

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="text-center">
                                    <h3><i class="fa fa-lock fa-4x"></i></h3>
                                    <h2 class="text-center">Cambia tu contraseña</h2>
                                    <div class="panel-body" id="formPassword">

                                        <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                                    <input id="email" name="email" placeholder="Contraseña Antigua" class="form-control"  type="email">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                                    <input id="email" name="email" placeholder="Nueva Contraseña" class="form-control"  type="email">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                                    <input id="email" name="email" placeholder="Confrmar Contraseña" class="form-control"  type="email">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input name="recover-submit" class="btn btn-lg btn-success btn-block" value="Restablecer contraseña" type="submit">
                                            </div>

                                            <input type="hidden" class="hide" name="token" id="token" value=""> 
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Fin modal -->
<script>
//    $('#cerrar').click(function () {
//        $('#myModalCancel').modal('hide');
//    });
</script>