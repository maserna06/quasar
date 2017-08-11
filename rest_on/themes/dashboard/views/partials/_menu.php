<?php

use App\User\User as U;
use App\Utils\MenuHelper;

/*
 *  Created by Diego Castro <ing.diegocastro@gmail.com>
 */
/* @var $this SiteController */

$user = U::getInstance();
MenuHelper::setControllerId($this->id);
MenuHelper::setActionId($this->action->id);
MenuHelper::setActiveClass('active');
MenuHelper::setOpenClass('menu-open');

//mostrar/ocultar Menu procesos segun - ficha tecnica en config inventarios 
$empresa = Yii::app()->getSession()->get('empresa');
$inveFichaTec = InventoryConfig::model()->findAll('company_id='.$empresa);
$MenuShowHide = 0;
     if($inveFichaTec)
     {
       foreach($inveFichaTec as $inve)
       {
        $MenuShowHide = $inve->handle_datasheet;      
       }
     }
     
$items = [
  array(
    'label'=>'<i class="fa fa-dashboard"></i><span>Inicio</span>',
    'url'=>array('/')
  ),
  array(
    'label'=>'<i class="fa fa-gears"></i><span>Configuracion</span><span class="pull-right-container"><span class="label label-primary pull-right">7</span></span>',
    'url'=>'#',
    'visible'=>$user->isAdmin,
    'itemOptions'=>array(
      'class'=>'treeview'
    ),
    'submenuOptions'=>[
      'class'=>'treeview-menu'
    ],
    'items'=>array(
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Departamentos',
        'url'=>array('/departaments'),
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Ciudades',
        'url'=>array('/cities'),
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Actividades Economicas',
        'url'=>array('/economicActivities'),
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Empresas',
        'url'=>array('/companies'),
        'visible'=>$user->isSuper
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Bodegas',
        'url'=>array('/wharehouses'),
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Usuarios',
        'url'=>array('/user'),
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Impuestos',
        'url'=>array('/taxes'),
      ),
    )
  ),
  array(
    'label'=>'<i class="fa fa-calendar"></i> <span>Calendario</span><span class="pull-right-container"><small class="label pull-right bg-red">3</small><small class="label pull-right bg-blue">17</small></span>',
    'url'=>array('/schedule'),
    'visible'=>$user->isContable,
  ),
  array(
    'label'=>'<i class="fa fa-users"></i> <span>Clientes</span>',
    'url'=>array('/customers'),
    'visible'=>$user->isSupervisor,
  ),
  array(
    'label'=>'<i class="fa fa-building"></i> <span>Proveedores</span>',
    'url'=>array('/suppliers'),
    'visible'=>$user->isSupervisor,
  ),  
  array(
    'label'=>'<i class="fa fa-list-alt"></i><span>Inventarios</span><span class="pull-right-container"><span class="label label-primary pull-right">9</span></span>',
    'url'=>'#',
    'visible'=>$user->isSupervisor,    
    'itemOptions'=>array(
      'class'=>'treeview'      
    ),
    'submenuOptions'=>[
      'class'=>'treeview-menu',
    ],
    'items'=>array(
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Unidades de Medida',
        'url'=>array('/unit'),
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Conversion de Unidad',
        'url'=>array('/conversionUnit'),
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Categorias',
        'url'=>array('/categories'),
        'itemOptions'=>array(
          'id'=>'categorias-menuIzq-process'      
        ),
      ),      
      
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Procesos',
        'url'=>array('/process'),
        'visible'=>$MenuShowHide, 
        'itemOptions'=>array(
          'id'=>'left-menu-process'      
        ),                
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Productos',
        'url'=>array('/products'),
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Clasificacion',
        'url'=>array('/classification'),
      ),
      /*array(
        'label'=>'<i class="fa fa-circle-o"></i> Lista de Precios',
        'url'=>array('/priceList'),
      ),*/
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Inventarios',
        'url'=>array('/inventories'),
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Producto Terminado',
        'url'=>array('/finishedProduct'),
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Traslados',
        'url'=>array('/transfers'),
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Configuracion',
        'url'=>array('/inventories/config'),
      ),
    )
  ),
  array(
    'label'=>'<i class="fa fa-money"></i><span>Compras</span><span class="pull-right-container"><span class="label label-primary pull-right">4</span></span>',
    'url'=>'#',
    'visible'=>$user->isSupplier,
    'itemOptions'=>array(
      'class'=>'treeview'
    ),
    'submenuOptions'=>[
      'class'=>'treeview-menu',
    ],
    'items'=>array(
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Ordenes',
        'url'=>array('/order'),
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Remisiones',
        'url'=>array('/referralsP'),
        'visible'=>$user->isSupervisor
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Compras',
        'url'=>array('/purchases'),
        'visible'=>$user->isSupervisor
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Configuracion',
        'url'=>array('/purchases/config'),
        'visible'=>$user->isSupervisor
      ),
    )
  ),
  array(
    'label'=>'<i class="fa fa-shopping-cart"></i><span>Punto de Venta</span><span class="pull-right-container"><span class="label label-primary pull-right">4</span></span>',
    'url'=>'#',
    'visible'=>$user->isCustomer,
    'itemOptions'=>array(
      'class'=>'treeview',
    ),
    'submenuOptions'=>[
      'class'=>'treeview-menu',
    ],
    'items'=>array(
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Pedidos',
        'url'=>array('/requests'),
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Remisiones',
        'url'=>array('/referrals'),
        'visible'=>$user->isVendor
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Ventas',
        'url'=>array('/sales'),
        'visible'=>$user->isVendor
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Configuracion',
        'url'=>array('/sales/config'),
        'visible'=>$user->isSupervisor
      ),
    )
  ),
  array(
    'label'=>'<i class="fa fa-calculator"></i><span>Contabilidad</span><span class="pull-right-container"><span class="label label-primary pull-right">3</span></span>',
    'url'=>'#',
    'visible'=>$user->isContable,
    'itemOptions'=>array(
      'class'=>'treeview',
    ),
    'submenuOptions'=>[
      'class'=>'treeview-menu',
    ],
    'items'=>array(
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Bancos',
        'url'=>array('/banks'),
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Cuentas Contables',
        'url'=>array('/accounts'),
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Procesos',
        'url'=>'#',
        'visible'=>$user->isSupervisor
      ),
    )
  ),
  array(
    'label'=>'<i class="fa fa-pie-chart"></i><span>Informes</span><span class="pull-right-container"><span class="label label-primary pull-right">6</span></span>',
    'url'=>'#',
    'visible'=>$user->isContable,
    'itemOptions'=>array(
      'class'=>'treeview',
    ),
    'submenuOptions'=>[
      'class'=>'treeview-menu',
    ],
    'items'=>array(
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Clientes',
        'url'=>'#',
        'visible'=>$user->isSupervisor
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Proveedores',
        'url'=>'#',
        'visible'=>$user->isSupervisor
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Inventarios',
        'url'=>'#',
        'visible'=>$user->isSupervisor
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Compras',
        'url'=>'#',
        'visible'=>$user->isSupervisor
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Punto de Venta',
        'url'=>'#',
        'visible'=>!$user->isOnlyContable()
      ),
      array(
        'label'=>'<i class="fa fa-circle-o"></i> Contabilidad',
        'url'=>'#',
        'visible'=>$user->isOnlyContable()
      ),
    )
  ),
  #array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest)
  #array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
];
$items= MenuHelper::processItems($items);

$this->widget('zii.widgets.CMenu',array(
  'encodeLabel'=>false,
  'htmlOptions'=>array(
    "class"=>"sidebar-menu"
  ),
  'items'=>$items,
  'submenuHtmlOptions'=>array(
    'class'=>'treeview-menu',
  ),
));
