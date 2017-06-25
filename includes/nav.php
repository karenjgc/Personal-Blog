<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <title>Jeanette González</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="css/clean-blog.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <link href="css/estilos.css" rel="stylesheet">
    <style media="screen">
    #instafeed{
      -moz-column-count: 2; /* For FireFox */
      -webkit-column-count: 2; /* For Safari/Chrome */
      column-count: 2; /* For when the standard gets fully supported */
      -moz-column-gap: 0;
      -webkit-column-gap: 0;
      column-gap: 0;
      list-style-type: none;
      padding: 0;
      margin: 0;
      text-align: center;
      float: none;
    }

    #instafeed li{
      padding: 0;
      margin-bottom: 3px;
      margin-right: 3px;
    }

    @media only screen and (min-width: 1024px) {
      #instafeed {
        float: left;
      }
    }

    #recientes{
      list-style-type: square;
      padding: 0;
      margin: 0;
    }

    #recientes li{
      margin-top: 2px;
      margin-left: 1.3em;
    }

    .etiqueta{
      padding-left: 3px;
      font-size: 0.6em;
      color:#777777;
    }

    .titulo-reciente{
      font-size: 0.9em;
      text-align: justify;
    }

    .titulo-reciente::after{
      content: '\A';
      white-space: pre;
    }

    .ir-arriba{
      display: none;
      padding: 12px;
      background: #777777;
      color:#fff;
      cursor: pointer;
      position: fixed;
      right: 1em;
      bottom: 1em;
      top: auto;
      z-index: 10000;
    }

    .post-preview img{
      max-width: 100%;
      height: auto;
    }

    .pager li > a{
      padding: 9px;
      font-size: 9px;
    }

    @media only screen and (min-width: 500px){
      .pager li > a{
        font-size: 14px;
      }
    }
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    Menu <i class="fa fa-bars"></i>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="index.php">Blog</a>
                    </li>
                    <li>
                        <a href="about.php">Sobre mí</a>
                    </li>
                    <li>
                        <a href="contact.php">Subscribete</a>
                    </li>
                    <li>
                        <a href="contact.php">Contacto</a>
                    </li>
                    <?php
                    if (isset($_SESSION['usuario'])){
                      echo"
                      <li>
                          <a href='admin.php'>Mi cuenta</a>
                      </li>";
                    }
                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <!-- End Navigation -->

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('img/home-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>Jeanette González</h1>
                        <hr class="small">
                        <span class="subheading">A Clean Blog Theme by Start Bootstrap</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- End Page Header -->

   <span class='ir-arriba glyphicon glyphicon-menu-up'></span>
