<?php
/* @var $this SiteController */
/* @var $id string */
/* @var $title string */

$id = 'modal_32x';
$title = isset($title)?$title:'Información';
$body = isset($body)?$body:'';
?>

<div class="modal fade" id="<?=$id?>" tabindex="-1" role="dialog" aria-labelledby="<?=$id?>" style="display: none">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" >&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"><?=$title?:'Información'?></h4>
      </div>
      <div class="modal-body">
        <?=$body?:''?>
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-default cancel">Cancelar</button>-->
        <button type="button" class="btn btn-primary ok" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>
<script>
  var Modal = {};
  jQuery(function(){
    var m = $('#<?=$id?>'),
    close = m.find('.close'),
    title = m.find('.modal-title'),
    body = m.find('.modal-body'),
    ok = m.find('.ok');

    Modal.show = function(options){
      if(typeof options == 'string') {
        options = {
          body: options
        };
      }
      options = options || {};
      options = $.extend({
        title: 'Información',
        body: '',
        ok: 'Aceptar'
      }, options);
      m.modal('show');
      title.html(options.title);
      body.html(options.body);
      ok.text(options.ok);
      return m;
    };
    Modal.hide = function(){
      m.modal('hide');
    };
    Modal.toggle = function(){
      m.modal('toggle');
    };
    Modal.get = function(){
      return m;
    };
  });
</script>