<?php
/**
 * Created by PhpStorm.
 * User: jcicak
 * Date: 11/9/2018
 * Time: 12:53 PM
 */

?>
    <ul class="nav">
        <li id="menu_dashboard" class="nav-item ">
            <a class="nav-link" href="?page=dashboard" >
                <i class="material-icons">dashboard</i>
                <p>Dashboard</p>
            </a>
        </li>
        <li id="menu_zones" class="nav-item ">
            <a class="nav-link" href="?page=zones">
                <i class="fa fa-map"></i>
                <p>Zone Switcher</p>
            </a>
        </li>
<?php if(isset($_SESSION['authenticated'])){ ?>
        <li id="menu_notifications" class="nav-item ">
            <a class="nav-link" href="?page=notifications">
                <i class="material-icons">notifications</i>
                <p>Notifications</p>
            </a>
        </li>
<?php } ?>


