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
  <?php foreach($users as $data):
    $data = (object)$data;
    ?>
      <li>
        <h4><a href="#"><?php echo strtoupper($data->user_firtsname).' '.strtoupper($data->user_lastname);?></a>
          <small>
            (<?=$data->user_name; ?>)
          </small>
            <button class="pull-right user-edit" id="<?= $data->user_id?>" >
            <i class="fa fa-pencil"></i>
            </button>
        </h4>
        <p><?php// echo $data->description;?></p>
        <hr>
      </li>
  <?php endforeach;?>
</ul>