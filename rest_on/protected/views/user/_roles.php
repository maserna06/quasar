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
			      $enabled?"On":"Off",$isadmin?array("user/assignprofile","id"=>$model->user_id,"item"=>$data->name):"#",array("class"=>$enabled?"btn btn-success pull-right":"btn btn-danger pull-right")
			    );
			    ?>
			  </h4>
			  <p><?php echo $data->description;?></p>
			  <hr>
			</li>
		<?php endif;?>
	<?php endforeach;?>
</ul>