<div class="col-sm-3">
    <div class="user">
        <div class="market">
            <div class="user-info">
                <div class="user-photo" style="text-align: center;">
                     <?php $img = ($data->user_photo) ? $data->user_photo : 'user2-160x160.jpg';   ?>
                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/img/<?php echo $img ?>" 
                         alt="<?php echo $data->user_firtsname . " " . $data->user_lastname; ?>">
                </div>    

                <p class="user-name"><?php echo $data->user_firtsname . " " . $data->user_lastname ?></p>

                <div class="user-roles">
                    <?php foreach (Yii::app()->authManager->getAuthItems(2, $data->user_id) as $role): ?>
                        <span class="label label-success"><?php echo strtoupper($role->name); ?></span>
                    <?php endforeach; ?>
                </div>
            </div> 

            <div>
                <p align="center">
                    <a href="javaScript:userDetails(<?= $data->user_id ?>)" class="btn btn-warning btn-block">Detalle</a>
                </p>
            </div>
        </div>
    </div>
</div>