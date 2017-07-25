<?php
/* @var $this SiteController */
/* @var $model User */
/*
 *  Created by Diego Castro <ing.diegocastro@gmail.com>
 */
use App\User\User as U;
use App\User\Role;

$user=U::getInstance();

?>

<ul id="edit-roles-list" class="nav nav-tabs nav-stacked">
  <?php 
      foreach(Yii::app()->authManager->getAuthItems() as $data):
        $enabled=Role::isAssigned($data->name,$model->user_id);
        $isadmin=$user->isAdmin;

        //Validate Customer And Supplier
        if($data->name != "customer" && $data->name != "supplier"):
  ?>
      <li>
        <h4><a href="#"><?php echo strtoupper($data->name);?></a>
          <small>
            <?php if($data->type== 0) echo "Operacion";?>
            <?php if($data->type== 1) echo "Tarea";?>
            <?php if($data->type== 2) echo "Rol";?>
          </small>
          <?php
          echo CHtml::link(
            $enabled?"On":"Off","",array("class"=>$enabled?"btn btn-success pull-right assignprofile":"btn btn-danger pull-right assignprofile", "name"=>$model->user_id, "id"=>$data->name, "state"=>$enabled?"On":"Off")
          );
          ?>
        </h4>
        <p><?php echo $data->description;?></p>
        <hr>
      </li>
    <?php endif;?>
  <?php endforeach;?>
</ul>

<script type="text/javascript">
  jQuery(function ($) {

    $('.assignprofile').on('click', function () {
      var id = $(this).attr('name');
      var item = $(this).attr('id');
      var state = $(this).attr('state');

      $.ajax({
        url: '<?php echo Yii::app()->createUrl("companies/assignprofile"); ?>',
        method: 'post',
        dataType: 'html',
        data: {
          id: id,
          item: item
        },
        success: function (data) {
          var datos = $.parseJSON(data);       
          if(datos['message'] == "success"){
            $("#" + item).removeClass((state == "On") ? "btn-success" : "btn-danger");
            $("#" + item).addClass((state == "On") ? "btn-danger" : "btn-success");
            $("#" + item).html((state == "On") ? "Off" : "On");
            $("#" + item).attr('state', (state == "On") ? "Off" : "On");
          }
        }
      });

    });

  });
</script>