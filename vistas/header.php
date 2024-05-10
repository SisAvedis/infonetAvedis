<?php
  if(strlen(session_id()) < 1) //Si la variable de session no esta iniciada
  {
    session_start();
  } 

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IN | AvedisInfoNet</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon" href="../public/img/avedis_favicon.ico">
    <!--DATATABLES-->
    <link rel="stylesheet" href="../public/datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../public/datatables/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../public/datatables/responsive.dataTables.min.css">
    
    <link rel="stylesheet" href="../public/css/bootstrap-select.min.css">
    <script src="../public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <style>
        #login{
         color:white;
         top:5px;
         right:15px;
         position:relative;
        }
        #login:hover{
          color:blanchedalmond;
        }
    </style>

  </head>
  <body class="hold-transition skin-red sidebar-mini">
    <div class="wrapper" style="z-index: 2;">

      <header class="main-header">

        <!-- Logo -->
        <a href="escritorio.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>IN</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg" style="text-decoration:none">Avedis<b>InfoNet</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              
              <!-- User Account: style can be found in dropdown.less -->
              <?php echo(!isset($_SESSION['imagen']))?'<a href="login.html" id="login"  ><h4>Iniciar Sesión</h4></a>': ""  ?>
              <li class="dropdown user user-menu" style="<?php echo(!isset($_SESSION['imagen']))?"display:none": "" ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                  <img   src="<?php echo(!isset($_SESSION['imagen']))? "..." : '../files/usuarios/'. $_SESSION['imagen']; ?>" class="user-image" alt="">
                  <span class="hidden-xs"><?php echo(!isset($_SESSION['nombre']))? "" : $_SESSION['nombre']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                    <p>
                      Sistemas
                      <small>Avedis</small>
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    
                    <div class="pull-right">
                      <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Cerrar</a>
                    </div>
                  </li>
                </ul>
              </li>
              
            </ul>
          </div>

        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">       
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>
            <?php
              
                echo 
                '<li>
                  <a href="escritorio.php">
                    <i class="fa fa-tasks"></i> <span>Noticias</span>
                  </a>
                </li>';
                
                
                /* if($_SESSION['ABM'] == 1)
                {*/
                  echo 
                  '<li class="treeview">
                  <a href="internos-v2.php">
                  <i class="fa fa-phone"></i>
                  <span>Internos</span>
                  </a>
                  </li>'
                  ;
                  /* } else {echo "";}*/
                  
                  /*  if($_SESSION['acceso'] == 1)
                  {*/
                    echo 
                    '<li class="treeview">
                    <a href="#">
                    <i class="fa fa-fax"></i> <span>Padrones</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                <ul class="treeview-menu">
                <li><a href="cpadronARBA.php?id=1"><i class="fa fa-circle-o"></i>IIBB ARBA (R)</a></li>
                <li><a href="cpadronARBA.php?id=2"><i class="fa fa-circle-o"></i>IIBB ARBA (P)</a></li>
                <li><a href="cpadronAGIP.php?id=3"><i class="fa fa-circle-o"></i>IIBB AGIP</a></li>
                
                </ul>
                </li>'
                
                .((isset($_SESSION['noticias']) && $_SESSION['noticias'] == 1)
                ? '<li>
                  <a href="maestroInternos.php">
                    <i class="fa fa-phone"></i> <span>Maestro de Internos</span>
                  </a>
                </li>'
                :  "");
                /*  if($_SESSION['consulta'] == 1)
                {*/
                  echo 
                  '<li class="treeview">
                  <a href="pruebaRTIBG3.php">
                      <i class="fa fa-bar-chart"></i> <span>Retención (A Cuenta)</span>
                    </a>
                  </li>'
                 ;
            /*  } else {echo "";}*/
             /* if($_SESSION['consulta'] == 1)
              {*/
                 echo 
                '<li class="treeview">
                    <a href="qr.php">
                      <i class="fa fa-qrcode"></i> <span>Leer QR</span>
                    </a>
                  </li>'
                 ;
              /*} else {echo "";}*/
             /* if($_SESSION['consulta'] == 1)
              {*/
                echo 
                '<li class="treeview">
                    <a href="consultadocumento.php">
                      <i class="fa fa-book"></i> <span>Procedimientos</span>
                    </a>
                  </li>'
                 ;
            /*  } else {echo "";}*/
            ?>                                
          
            <li>
              <a href="#">
                <i class="fa fa-plus-square"></i> <span>Ayuda</span>
                <small class="label pull-right bg-red">PDF</small>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
                <small class="label pull-right bg-yellow">IT</small>
              </a>
            </li>
            <li>
            <a href="http://10.10.0.131/">
          <i class="fa fa-arrow-left"></i> <span>Volver Al Menú</span>
          
        </a>
            </li>
                        
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <script>
        $("#login").hover("style", "color:yellow")

      </script>