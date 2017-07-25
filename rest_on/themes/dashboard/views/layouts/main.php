<?php

use App\User\User as U;

/* @var $this Controller */
//Diego Castro
$user = U::getInstance();
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/diegocastro.min.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/dc.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.easing.min.js');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <base href="<?= Yii::app()->getBaseUrl(true) ?>/" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/dist/css/skins/jc.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/iCheck/flat/blue.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/morris/morris.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- Date Picker -->
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/datepicker/datepicker3.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/daterangepicker/daterangepicker.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <!-- Autocpletable selects -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/selectize/css/normalize.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/selectize/css/selectize.css"/>
        <!-- End selectize -->

        <!-- File input -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/fileinput/fileinput.css"/>

        <!-- Css personalizado John CUbides  -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/johnCubides.css"/>

        <!-- Css personalizado Jaime Alvarez  -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/jaimeAlvarez.css"/>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->


        <!-- Autocpletable selects -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/selectize/js/selectize.js"></script>

        <!-- js inputfile -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/fileinput/fileinput.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/fileinput/locales/es.js"></script>

        <!-- toogle -->
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">



    </head>
    <body class="hold-transition skin-blue sidebar-mini <?= $user->sidebarState ?>">
        <?= $this->renderPartial('//partials/_modal') ?>
        <div id="div-content" class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="#" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>Q</b>POS</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>QUASAR </b><i>sys</i> POS</span>
                </a> 
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Navegacion</span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->
                            <li class="dropdown messages-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="label label-success">4</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">Tienes 4 mensajes</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <li><!-- start message -->
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img src="<?php echo Yii::app()->theme->baseUrl . '/dist/img/' . User::model()->findByPk(YII::app()->user->id)->user_photo ?>" class="img-circle" alt="User Image">
                                                    </div>
                                                    <h4>
                                                        Equipo de Apoyo
                                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                    </h4>
                                                    <p>Accede y valida tu cuenta?</p>
                                                </a>
                                            </li>
                                            <!-- end message -->
                                            <li>
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                                    </div>
                                                    <h4>
                                                        Equipo de Soporte
                                                        <small><i class="fa fa-clock-o"></i> 2 horas</small>
                                                    </h4>
                                                    <p>Ya terminaste tu curso de Rest On?</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                                    </div>
                                                    <h4>
                                                        Bodegas
                                                        <small><i class="fa fa-clock-o"></i> Hoy</small>
                                                    </h4>
                                                    <p>Es necesario montar unos tickets?</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                                    </div>
                                                    <h4>
                                                        Departamento de Ventas
                                                        <small><i class="fa fa-clock-o"></i> Ayer</small>
                                                    </h4>
                                                    <p>Necesitamos apoyo y capacitacion del sistema POS</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                                    </div>
                                                    <h4>
                                                        Soporte
                                                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                                                    </h4>
                                                    <p>Necesitas nuevos tiempos de capacitacion?</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">Ver Mensajes</a></li>
                                </ul>
                            </li>
                            <!-- Notifications: style can be found in dropdown.less -->
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning">10</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">Tienes 10 Notificaciones</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-users text-aqua"></i> 5 nuevas ventas hoy
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-warning text-yellow"></i> Existen procesos de cierre que estan ocacionando lios en contabilidad
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-users text-red"></i> 1 nuevo miembro del sistema
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-shopping-cart text-green"></i> 25 ordenes hechas
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-user text-red"></i> Completar perfil de usuario
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">Ver Todas</a></li>
                                </ul>
                            </li>
                            <!-- Tasks: style can be found in dropdown.less -->
                            <li class="dropdown tasks-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-flag-o"></i>
                                    <span class="label label-danger">3</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">Tienes 3 Tareas</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <li><!-- Task item -->
                                                <a href="#">
                                                    <h3>
                                                        Hay productos en inventario con Stock minimo
                                                        <small class="pull-right">30%</small>
                                                    </h3>
                                                    <div class="progress xs">
                                                        <div class="progress-bar progress-bar-aqua" style="width: 30%" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">30% Complete</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <!-- end task item -->
                                            <li><!-- Task item -->
                                                <a href="#">
                                                    <h3>
                                                        Perfil completo
                                                        <small class="pull-right">40%</small>
                                                    </h3>
                                                    <div class="progress xs">
                                                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">40% Complete</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <!-- end task item -->
                                            <li><!-- Task item -->
                                                <a href="#">
                                                    <h3>
                                                        Punto de Venta configurado
                                                        <small class="pull-right">80%</small>
                                                    </h3>
                                                    <div class="progress xs">
                                                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">80% Complete</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <!-- end task item -->
                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <a href="#">Ver Tareas</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo Yii::app()->theme->baseUrl . '/dist/img/' . User::model()->findByPk(YII::app()->user->id)->user_photo ?>" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo Yii::app()->user->name; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?php echo Yii::app()->theme->baseUrl . '/dist/img/' . User::model()->findByPk(YII::app()->user->id)->user_photo ?>" class="img-circle" alt="User Image">

                                        <p>
                                            <?php echo Yii::app()->user->name; ?> - <?php #echo Yii::app()->authManager->getRoles(Yii::app()->user->id); ?>
                                            <small>Miembro desde Sep. 2016</small>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-body">
                                        <div class="row">
                                            <div class="col-xs-4 text-center">
                                                <a href="#">PQRS</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a href="#">Soporte</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a href="#">Manual</a>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left"> 
                                            <?php echo CHtml::link("Perfil", array('user/viewprofile'), array('class' => 'btn btn-default btn-flat')); ?>
                                        </div>
                                        <div class="pull-right">
                                            <a class="btn btn-default btn-flat" href="<?= Yii::app()->createUrl('site/logout') ?>">Cerrar Sesion</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                            <li>
                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo Yii::app()->theme->baseUrl . '/dist/img/' . User::model()->findByPk(YII::app()->user->id)->user_photo ?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?php echo Yii::app()->user->name; ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                    <?php $this->renderPartial('//partials/_menu') ?>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">     
                <?php echo $content; ?><!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 1.0.1
                </div>
                <strong>Copyright &copy; 2016 <a href="http://mademoinnovacion.com">Mas Desarrollo Moderno S.A.S</a>.</strong> Todos los derechos reservados.
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Create the tabs -->
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                    <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                    <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Home tab content -->
                    <div class="tab-pane" id="control-sidebar-home-tab">
                        <h3 class="control-sidebar-heading">Actividad reciente</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Alejandro Cumpleaños</h4>

                                        <p>Será 24 de abril</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-user bg-yellow"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Andres Arias</h4>

                                        <p>Nuevo numero +57(300)433-1234</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Nora se ha unido al equipo</h4>

                                        <p>nora@carboneepasta.com</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-file-code-o bg-green"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Tienes 140 ordenes</h4>

                                        <p>Tiempo esperado de respuesta 24hr</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <!-- /.control-sidebar-menu -->

                        <h3 class="control-sidebar-heading">Progreso de Tareas</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        Custom Template Design
                                        <span class="label label-danger pull-right">70%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        Update Resume
                                        <span class="label label-success pull-right">95%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        Laravel Integration
                                        <span class="label label-warning pull-right">50%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        Back End Framework
                                        <span class="label label-primary pull-right">68%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <!-- /.control-sidebar-menu -->

                    </div>
                    <!-- /.tab-pane -->
                    <!-- Stats tab content -->
                    <div class="tab-pane" id="control-sidebar-stats-tab">Estadisticas de Contenido</div>
                    <!-- /.tab-pane -->
                    <!-- Settings tab content -->
                    <div class="tab-pane" id="control-sidebar-settings-tab">
                        <form method="post">
                            <h3 class="control-sidebar-heading">Configuracion General</h3>

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Informe de uso del panel
                                    <input type="checkbox" class="pull-right" checked>
                                </label>

                                <p>
                                    Parte de la informacion acerca de opciones de configuracion general.
                                </p>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Permitir redirección de correo
                                    <input type="checkbox" class="pull-right" checked>
                                </label>

                                <p>
                                    Otras opciones estan disponibles.
                                </p>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Mostrar el nombre del autor en las publicaciones
                                    <input type="checkbox" class="pull-right" checked>
                                </label>

                                <p>
                                    Permitir al usuario mostrar su nombre en las entradas del blog.
                                </p>
                            </div>
                            <!-- /.form-group -->

                            <h3 class="control-sidebar-heading">Configuracion del Chat</h3>

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Mostrarme OnLine.
                                    <input type="checkbox" class="pull-right" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Desactivar notificaciones.
                                    <input type="checkbox" class="pull-right">
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Borrar historial del chat.
                                    <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                                </label>
                            </div>
                            <!-- /.form-group -->
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
            </aside>
            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <?php
        Yii::app()->clientScript->registerScript("export", "
            $('#export_pdf').click(function(){
                if(confirm('" . Yii::t('application', 'Generation time can take up to 5 minutes, depending on the number of records. Want to continue?') . "')){
                    window.open('" . Yii::app()->controller->createUrl('exportPdf', array('type' => 'PDF', 'id' => 1)) . "', '', 'hotkeys=no, height=500, width=700');
                }
                return false;
            });
        ", CClientScript::POS_READY);
        ?>
        <script>

            //    $('select').selectize({
            //        sortField: {
            //            field: 'text',
            //            direction: 'asc'
            //        },
            //        dropdownParent: 'body'
            //    });
        </script>
        <!-- ./wrapper -->


        <!-- jQuery UI 1.11.4 -->
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/js/bootstrap.min.js"></script>
        <!-- Morris.js charts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <!--<script src="<?php #echo Yii::app()->theme->baseUrl;    ?>/plugins/morris/morris.min.js"></script>-->
        <!-- Sparkline -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/sparkline/jquery.sparkline.min.js"></script>
        <!-- jvectormap -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/knob/jquery.knob.js"></script>
        <!-- daterangepicker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/daterangepicker/daterangepicker.js"></script>
        <!-- datepicker -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/datepicker/bootstrap-datepicker.js"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <!--<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>-->
        <!-- Slimscroll -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/fastclick/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/js/app.min.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/js/pages/dashboard.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/js/demo.js"></script>
        <!-- js personalizado jcubides -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/jc.js"></script>
        <!-- convertir numeros con comas y viceversa -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
        <?php $this->renderPartial('../_modal_recovery'); ?>
        <?php
        $user = User::model()->findByPk(Yii::app()->user->id);
        if ($user->reset_password == 1) {
            ?>
            <script>
            $("#formPassword").html('');
            $.ajax({
                url: "<?php echo $this->createUrl('/user/ChangePassword') ?>",
                success: function (result) {
                    $("#formPassword").html(result);
                }
            });
            $("#myModalPassword").modal({backdrop: 'static', keyboard: false});
            </script>
            <?php
        }
        ?>    
        <!-- togle -->
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    </body>
</html>
