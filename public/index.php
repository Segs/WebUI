<?php
    /*
     * SEGS - Super Entity Game Server
     * http://www.segs.io/
     * Copyright (c) 2006 - 2018 SEGS Team (see AUTHORS.md)
     * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
     */

    session_start();

    require_once '../config/config.php';
    if (isset($_GET['page'])):
        $page = $_GET["page"];
    else:
        $page = "dashboard";
    endif;
    setCookie("CurrentPage", $page);

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <link rel="icon" type="image/png" href="assets/img/favicon.png">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title><?php echo $site_title; ?></title>
        <!-- WebUI Base -->
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
        <!--    Fonts and icons     -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />

        <!-- Font Awesome          -->
        <!--
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
        -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <!-- CSS Files -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-lightbox/0.7.0/bootstrap-lightbox.css" integrity="sha256-iSJ+O7SdfdjO7VYs5/SlJm9JWfnJSkqTFjI7xQV3CvE=" crossorigin="anonymous" />
        <link href="/assets/css/material-dashboard.css?v=2.1.0" rel="stylesheet" />
        <link href="/assets/css/segs.css" rel="stylesheet" />
    </head>

    <body class="">
        <div class="wrapper ">
            <div id="modal-login" class="modal fade" tabindex="-1" role="dialog">
                <?php require_once 'assets/includes/showLogin.php'; ?>
            </div>
            <div id="modal-message" class="modal fade" tabindex="-1" role="dialog">
                <?php require_once 'assets/includes/showMessage.php'; ?>
            </div>
            <div class="sidebar" data-color="<?php echo $site_color; ?>" data-background-color="white" data-image="">
                <div class="customLogo container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-8 col-sm-6 col-xs-4 mx-auto">
                            <a href="<?php echo $site_url; ?>" class="simple-text logo-normal" target="_blank">
                                <img class="img-fluid" src="<?php echo $site_logo ; ?>" alt="<?php echo $site_name; ?>">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-wrapper">
                    <?php require_once 'assets/includes/menuLeft.php'; ?>
                </div>
            </div>
            <div class="main-panel">
                <div class="container-fluid d-flex justify-content-between"><!--  -->
                    <h3><?php echo $site_navbar_title; ?><br>
                        <?php if(isset($_SESSION['isAuthenticated']) && isset($_SESSION['username'])) { ?>
                            <span class="badge badge-secondary">
                                <?php echo  strtoupper($_SESSION['username']); ?>
                            </span>
                        <?php } ?>
                    </h3>
                     <!-- Navbar -->
                    <nav class="navbar navbar-expand-lg navbar-transparent">
                        <ul class="navbar-nav">
                            <li class="nav-item"><!--  -->
                                <?php if(isset($_SESSION['isAuthenticated'])) { ?>
                                <a  class="nav-link" role="button" href="#logout" onclick="doLogout();">
                                   <i class="fas fa-sign-out"></i>Log Out
                                <?php } else { ?>
                                <a class="nav-link" href="#modal-login" data-toggle="modal" data-target="#modal-login">
                                    <i class="fas fa-sign-in"></i>Login or Sign Up
                                <?php } ?>
                               </a>
                            </li><!--  -->
                        </ul>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="navbar-toggler-icon icon-bar"></span>
                            <span class="navbar-toggler-icon icon-bar"></span>
                            <span class="navbar-toggler-icon icon-bar"></span>
                        </button>
                    </nav>
                    <!-- End Navbar -->
                </div>
                <div class="content segs-content">
                    <div id="main-content">
                        <?php include "assets/views/{$page}.php"; ?>
                    </div>
                </div>
                <footer class="footer">
                    <div class="container-fluid">
                        <nav class="float-left">
                            <?php include_once 'assets/includes/menuFooter.php'; ?>
                        </nav>
                        <div class="copyright float-right">
                            &copy; <?php echo strftime("%Y"); ?> <a href="https://segs.io" target="_blank">SEGS</a>, with help from <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a>.
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!--   Core JS Files   -->
        <script type="text/javascript" src="assets/js/core/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/core/popper.min.js"></script>
        <script type="text/javascript" src="assets/js/core/bootstrap-material-design.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
        <!--  Google Maps Plugin
        <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
        -->
        <!-- Chartist JS -->
        <script type="text/javascript" src="assets/js/plugins/chartist.min.js"></script>
        <!--  Notifications Plugin    -->
        <script type="text/javascript" src="assets/js/plugins/bootstrap-notify.js"></script>
        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script type="text/javascript" src="assets/js/material-dashboard.min.js?v=2.1.0"></script>
        <!-- Material Dashboard DEMO methods, don't include it in your project! -->
        <script type="text/javascript" src="assets/js/plugins/imageMapResizer.min.js"></script>
        <script type="text/javascript" src="//cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.js" charset="utf-8"></script>
        <script type="text/javascript" src="assets/js/segs.js"></script>
    </body>
</html>
