<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => true,
    )
));
?>

<div class="col-xs-6 col-md-6 col-lg-6">
	<div class="form-group">
	    <div class="input-group">
	        <div class="input-group-addon">
	            <i class="fa fa-barcode"></i>
	        </div>
	        <?php echo $form->textField($model, 'company_id', array('size' => 20, 'maxlength' => 20, 'class' => 'form-control', 'placeholder' => "NIT Empresa *" )); ?>
	    </div><!-- /.input group -->
	    <br><?php echo $form->error($model, 'company_id', array('class' => 'alert alert-danger')); ?>
	</div>

	<div class="form-group">
	    <div class="input-group">
	        <div class="input-group-addon">
	            <i class="fa fa-industry"></i>
	        </div>
	        <?php echo $form->textField($model, 'company_name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => "Razon Social *" )); ?>
	    </div><!-- /.input group -->
	    <br><?php echo $form->error($model, 'company_name', array('class' => 'alert alert-danger')); ?>
	</div>

	<div class="form-group">
	    <div class="input-group">
	        <div class="input-group-addon">
	            <i class="fa fa-phone"></i>
	        </div>
	        <?php echo $form->textField($model, 'company_phone', array('size' => 20, 'maxlength' => 20, 'class' => 'form-control', 'placeholder' => "Telefono Empresa *" )); ?>
	    </div><!-- /.input group -->
	    <br><?php echo $form->error($model, 'company_phone', array('class' => 'alert alert-danger')); ?>
	</div>

	<div class="form-group">
	    <div class="input-group">
	        <div class="input-group-addon">
	            <i class="fa fa-map-signs"></i>
	        </div>
	        <?php echo $form->textField($model, 'company_address', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => "Dirección Empresa *" )); ?>
	    </div><!-- /.input group -->
	    <br><?php echo $form->error($model, 'company_address', array('class' => 'alert alert-danger')); ?>
	</div>

	<div class="form-group">
	    <div class="input-group">
	        <div class="input-group-addon">
	            <i class="fa fa-map"></i>
	        </div>
	        <?php
	        $departaments = CHtml::listData(Departaments::model()->findAll('deparment_state=1'), 'deparment_id', 'deparment_name');
	        echo $form->dropDownList($model, 'deparment_id', $departaments, array('class' => 'form-control', 'prompt' => '--Seleccione--',
	            'ajax' => array(
	                'url' => CController::createUrl('citiesByDepartaments'), //action en el controlador
	                'type' => 'POST',
	                'update' => '#' . CHtml::activeId($model, 'city_id'),
	            ),
	        ));
	        ?>
	    </div><!-- /.input group -->
	    <br><?php echo $form->error($model, 'deparment_id', array('class' => 'alert alert-danger')); ?>
	</div>

	<div class="form-group hide">
	    
	</div>
</div>

<div class="col-xs-6 col-md-6 col-lg-6">


	<div class="form-group">		
		<div class="input-group">
		  <div class="input-group-addon">
		    <i class="fa fa-barcode"></i>
		  </div><?php echo $form->textField($model1,'user_id',array('size'=>20,'maxlength'=>20,'class'=>'form-control', 'placeholder' => "Identificación Contacto *"));?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model1,'user_id',array('class'=>'alert alert-danger'));?>
	</div>

	<div class="form-group hide">		
		<div class="input-group">
		  <div class="input-group-addon">
		    <i class="fa fa-user"></i>
		  </div><?php echo $form->textField($model1,'user_name',array('size'=>50,'maxlength'=>50,'class'=>'form-control', 'placeholder' => "Nombre de Usuario *"));?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model1,'user_name',array('class'=>'alert alert-danger'));?>
	</div>

	<div class="form-group">		
		<div class="input-group">
		  <div class="input-group-addon">
		    <i class="fa fa-bookmark"></i>
		  </div><?php echo $form->textField($model1,'user_firtsname',array('size'=>50,'maxlength'=>50,'class'=>'form-control', 'placeholder' => "Nombre Contacto *"));?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model1,'user_firtsname',array('class'=>'alert alert-danger'));?>
	</div>

	<div class="form-group hide">
		<div class="input-group">
		  <div class="input-group-addon">
		    <i class="fa fa-bookmark-o"></i>
		  </div><?php echo $form->textField($model1,'user_lastname',array('size'=>50,'maxlength'=>50,'class'=>'form-control'));?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model1,'user_lastname',array('class'=>'alert alert-danger'));?>
	</div>

	<div class="form-group hide">
		<div class="input-group">
		  <div class="input-group-addon">
		    <i class="fa fa-phone"></i>
		  </div><?php echo $form->textField($model1,'user_phone',array('size'=>30,'maxlength'=>30,'class'=>'form-control', 'placeholder' => "Telefono Contacto *"));?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model1,'user_phone',array('class'=>'alert alert-danger'));?>
	</div>

	<div class="form-group hide">
		<div class="input-group">
		  <div class="input-group-addon">
		    <i class="fa fa-map-signs"></i>
		  </div><?php echo $form->textField($model1,'user_address',array('size'=>50,'maxlength'=>50,'class'=>'form-control', 'placeholder' => "Dirección Contacto *"));?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model1,'user_address',array('class'=>'alert alert-danger'));?>
	</div>

	<div class="form-group">
		<div class="input-group">
		  <div class="input-group-addon">
		    <i class="fa fa-at"></i>
		  </div><?php echo $form->textField($model1,'user_email',array('size'=>50,'maxlength'=>50,'class'=>'form-control', 'placeholder' => "Email Contacto *"));?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model1,'user_email',array('class'=>'alert alert-danger'));?>
	</div>

	<div class="form-group">
		<div class="input-group">
		  <div class="input-group-addon">
		    <i class="fa fa-mobile"></i>
		  </div><?php echo $form->textField($model1,'user_phonenumber',array('size'=>20,'maxlength'=>20,'class'=>'form-control', 'placeholder' => "Celular Contacto *"));?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model1,'user_phonenumber',array('class'=>'alert alert-danger'));?>
	</div>

	<div class="form-group">
		<div class="input-group">
		  <div class="input-group-addon">
		    <i class="fa fa-map-marker"></i>
		  </div>
		  <?php
		  $cities=CHtml::listData(Cities::model()->findAll('city_state=1'),'city_id','city_name');
		  echo $form->dropDownList($model,'city_id',$cities,array('class'=>'form-control','prompt'=>'--Seleccione--'));
		  ?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model,'city_id',array('class'=>'alert alert-danger'));?>
	</div>

	<div class="form-group hide">
		<div class="input-group">
		  <div class="input-group-addon">
		    <i class="fa fa-map-marker"></i>
		  </div>
		  <?php
		  $cities=CHtml::listData(Cities::model()->findAll('city_state=1'),'city_id','city_name');
		  echo $form->dropDownList($model1,'city_id',$cities,array('class'=>'form-control','prompt'=>'--Seleccione--'));
		  ?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model1,'city_id',array('class'=>'alert alert-danger'));?>
	</div>

	<div class="form-group hide">
		<div class="input-group">
		  <div class="input-group-addon">
		    <i class="fa fa-industry"></i>
		  </div>
		  <?php
		  $companies=CHtml::listData(Companies::model()->findAll('company_status=1'),'company_id','company_name');
		  echo $form->dropDownList($model1,'company_id',$companies,array('class'=>'form-control','empty'=>'--Seleccione--'));
		  ?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model1,'company_id',array('class'=>'alert alert-danger'));?>
	</div>

	<div class="form-group hide">
		<?php echo $form->fileField($model1,'user_photo',array('size'=>50,'maxlength'=>50,'class'=>'',"accept"=>"image/*"));?>
		<?php echo $form->hiddenField($model1, 'user_status', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'value' => 1 )); ?>
		<?php echo $form->hiddenField($model, 'company_status', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'value' => 1 )); ?>
	</div>

</div>

<div class="col-xs-12 col-md-12 col-lg-12">
	<div class="form-group">
	    <?php echo CHtml::submitButton('Enviar', array('class' => 'btn btn-block btn-success btn-lg')); ?>
	</div>
</div> 
    
<?php $this->endWidget(); ?>