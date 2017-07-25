******************* ESTADO *******************
<?php if($data->user_status=1){echo "Activo";}else{echo "Inactivo";} ?>


<?php echo $form->dropDownList($model,'user_status',array("1"=>"Activo","0"=>"Inactivo"),array('class'=>'form-control')); ?>

<?php 
	$departaments = CHtml::listData(Departaments::model()->findAll(), 'deparment_id', 'deparment_name');
	echo $form->dropDownList($model,'deparment_id',$departaments,array('class'=>'form-control','prompt'=>'--Seleccione--')); 
?>

<?php 
	$cities = CHtml::listData(Cities::model()->findAll(), 'city_id', 'city_name');
	echo $form->dropDownList($model,'city_id',$cities,array('class'=>'form-control','prompt'=>'--Seleccione--')); 
?>

<?php 
	$companies = CHtml::listData(Companies::model()->findAll(), 'company_id', 'company_name');
	echo $form->dropDownList($model,'company_id',$companies,array('class'=>'form-control','prompt'=>'--Seleccione--')); 
?>

<?php 
    $category = CHtml::listData(Categories::model()->findAll(), 'category_id', 'category_description');
    echo $form->dropDownList($model,'category_id',$category,array('class'=>'form-control','prompt'=>'--Seleccione--')); 
?>

<?php 
	$activity = CHtml::listData(EconomicActivities::model()->findAll(), 'economic_activity_cod', 'economic_activity_description');
	echo $form->dropDownList($model,'economic_activity_cod',$activity,array('class'=>'form-control','prompt'=>'--Seleccione--')); 
?>

<?php 
	$price = CHtml::listData(PriceList::model()->findAll(), 'price_list_id', 'price_name');
	echo $form->dropDownList($model,'price_list_id',$price,array('class'=>'form-control','prompt'=>'--Seleccione--')); 
?>

<?php 
	$bank = CHtml::listData(Banks::model()->findAll(), 'bank_nit', 'bank_name');
	echo $form->dropDownList($model,'bank_nit',$bank,array('class'=>'form-control','prompt'=>'--Seleccione--')); 
?>

<?php 
    $supplier = CHtml::listData(Suppliers::model()->findAll(), 'supplier_nit', 'supplier_name');
    echo $form->dropDownList($model,'supplier_nit',$supplier,array('class'=>'form-control','prompt'=>'--Seleccione--')); 
?>

<?php 
    $document = CHtml::listData(DocumentType::model()->findAll(), 'type_id', 'type_name');
    echo $form->dropDownList($model,'supplier_document_type',$document,array('class'=>'form-control','prompt'=>'--Seleccione--')); 
?>

<?php 
    $type = CHtml::listData(TypeAccounts::model()->findAll(), 'type_account_id', 'type_account_name');
    echo $form->dropDownList($model,'account_type',$type,array('class'=>'form-control','prompt'=>'--Seleccione--'));
?>

<?php
	array(
		'name'=>'deparment_state',
		'filter'=>array('1'=>'Activo','0'=>'Inactivo'),
		'value'=>'($data->deparment_state=="1")?("Activo"):("Inactivo")'
	),

	array(
        'name' =>'customer_document_type',
        'filter' => CHtml::listData(DocumentType::model()->findAll('type_status=1'), 'type_id', 'type_name'),
        'value' =>'($data->customerDocumentType!=null) ? $data->customerDocumentType->type_name : null',
    ),

    array(
        'name' =>'deparment_cod',
        'filter' => CHtml::listData(Departaments::model()->findAll('deparment_state=1'), 'deparment_cod', 'deparment_name'),
        'value' =>'($data->deparmentCod!=null) ? $data->deparmentCod->deparment_name : null',
    ),

    array(
        'name' =>'economic_activity_cod',
        'filter' => CHtml::listData(EconomicActivities::model()->findAll('economic_activity_status=1'), 'economic_activity_cod', 'economic_activity_description'),
        'value' =>'($data->economicActivityCod!=null) ? $data->economicActivityCod->economic_activity_description : null',
    ),

    array(
        'name' =>'deparment_id',
        'filter' => CHtml::listData(Departaments::model()->findAll('deparment_state=1'), 'deparment_cod', 'deparment_name'),
        'value' =>'($data->deparment!=null) ? $data->deparment->deparment_name : null',
    ),

	array(
        'name' =>'city_id',
        'filter' => CHtml::listData(Cities::model()->findAll('city_state=1'), 'city_cod', 'city_name'),
        'value' =>'($data->city!=null) ? $data->city->city_name : null',
    ),
    
	array(
		'name'=>'wharehouse_status',
		'filter'=>array('1'=>'Activo','0'=>'Inactivo'),
		'value'=>'($data->wharehouse_status=="1")?("Activo"):("Inactivo")'
	),

	array(
        'name' =>'bank_nit',
        'filter' => CHtml::listData(Banks::model()->findAll('bank_status=1'), 'bank_nit', 'bank_name'),
        'value' =>'($data->bankNit!=null) ? $data->bankNit->bank_name : null',
    ),

    array(
        'name' =>'convertion_base_unit',
        'filter' => CHtml::listData(Unit::model()->findAll('unit_status=1'), 'unit_id', 'unit_name'),
        'value' =>'($data->convertionBaseUnit!=null) ? $data->convertionBaseUnit->unit_name : null',
    ),
    
	array(
        'name' =>'convertion_destination_unit',
        'filter' => CHtml::listData(Unit::model()->findAll('unit_status=1'), 'unit_id', 'unit_name'),
        'value' =>'($data->convertionDestinationUnit!=null) ? $data->convertionDestinationUnit->unit_name : null',
    ),

    array(
		'name'=>'supplier_is_simplified_regime',
		'filter'=>array('1'=>'Si','0'=>'No'),
		'value'=>'($data->supplier_is_simplified_regime=="1")?("Activo"):("Inactivo")'
	),

    array(
        'name' =>'company_id',
        'filter' => CHtml::listData(Companies::model()->findAll('company_status=1'), 'company_id', 'company_name'),
        'value' =>'($data->company!=null) ? $data->company->company_name : null',
    ),

    array(
        'name' =>'category_id',
        'filter' => CHtml::listData(Categories::model()->findAll('category_status=1'), 'category_id', 'category_description'),
        'value' =>'($data->category!=null) ? $data->category->category_description : null',
    ),

    array(
        'name' =>'supplier_nit',
        'filter' => CHtml::listData(Suppliers::model()->findAll('supplier_status=1'), 'supplier_nit', 'supplier_name'),
        'value' =>'($data->supplierNit!=null) ? $data->supplierNit->supplier_name : null',
    ),

	array(
        'name' =>'user_id',
        'filter' => CHtml::listData(User::model()->findAll('user_status=1'), 'user_id', 'user_name'),
        'value' =>'($data->user!=null) ? $data->user->user_name : null',
    ),

    array(
        'name' =>'order_id',
        'filter' => CHtml::listData(Order::model()->findAll('order_status=1'), 'order_id', 'order_id'),
        'value' =>'($data->order!=null) ? $data->order->order_id : null',
    ),

    array(
          'name' =>'request_id',
          'filter' => CHtml::listData(Requests::model()->findAll('request_status=1'), 'request_id', 'request_id'),
          'value' =>'($data->request!=null) ? $data->request->request_id : null',
    ),

    array(
        'name' =>'customer_nit',
        'filter' => CHtml::listData(Customers::model()->findAll('customer_status=1'), 'customer_nit', 'customer_name'),
        'value' =>'($data->customerNit!=null) ? $data->customerNit->customer_name : null',
    ),

    array(
        'name' =>'accounts_id',
        'filter' => CHtml::listData(Accounts::model()->findAll('account_status=1'), 'account_id', 'account_name'),
        'value' =>'($data->accounts!=null) ? $data->accounts->account_name : null',
    ),

    array(
        'name' =>'account_type',
        'filter' => CHtml::listData(TypeAccounts::model()->findAll(), 'type_account_id', 'type_account_name'),
        'value' =>'($data->accountType!=null) ? $data->accountType->type_account_name : null',
    ),
    
?>