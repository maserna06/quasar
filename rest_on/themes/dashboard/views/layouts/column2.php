<?php /* @var $this Controller */ ?>

<?php $this->beginContent('//layouts/main'); ?>
<div style="background-image: url(<?php $img = 'home.png' ;echo (Yii::app()->theme->baseUrl. '/dist/img/'.$img); ?>); background-repeat: no-repeat;">
	<nav class="navbar navbar-default">
		<div class="container-fluid">
		  <div class="navbar-header"> 
		    <button type="button" class="collapsed navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> 
		      <span class="sr-only">Navegacion</span> 
		      <span class="icon-bar"></span> 
		      <span class="icon-bar"></span> 
		      <span class="icon-bar"></span> 
		    </button> 
		    <div class="navbar-brand">Menu</div>
		  </div>
		  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		    <?php
		      $this->beginWidget('zii.widgets.CPortlet', array(
		        #'title'=>'Operations',
		      ));
		      $this->widget('zii.widgets.CMenu', array(
		        'items'=>$this->menu,
		        'htmlOptions'=>array('class'=>'nav navbar-nav'),
		      ));
		      $this->endWidget();
		    ?>            
		    <!--<ul class="nav navbar-nav navbar-right"> 
		      <li>
		        <form class="navbar-form navbar-left"> 
		          <div class="form-group"> 
		            <input class="form-control" placeholder="Buscar ..."> 
		          </div> 
		          <button type="submit" class="btn btn-default">Aceptar</button> 
		        </form> 
		      </li>
		    </ul>-->
		  </div> 
		</div> 
	</nav>
	 <?php if(($msgs= Yii::app()->user->getFlashes())!=null): ?>
	 	<?php foreach ($msgs as $type => $message): ?> 
			<section class="content-header">
				<div class="alert alert-<?php echo $type; ?>  alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4>
					<i class="icon fa fa-<?php if($type=="danger"){echo 'ban';}elseif($type=="success"){echo 'check';}else{echo $type;} ?>"></i> 
					<?php if($type=="danger"){echo "Error!";}elseif($type=="info"){echo "Informacion!";}elseif($type=="warning"){echo "Alerta!";}elseif($type=="success"){echo "Confirmacion!";} ?>
					</h4>
					<?php echo $message; ?>
				</div>
			</section>
		<?php endforeach; ?> 
	<?php endif; ?>
	<?php echo $content; ?>
</div>
<?php $this->endContent(); ?>
