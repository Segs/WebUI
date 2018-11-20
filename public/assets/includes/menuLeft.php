<?php
    /*
     * SEGS - Super Entity Game Server
     * http://www.segs.io/
     * Copyright (c) 2006 - 2018 SEGS Team (see AUTHORS.md)
     * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
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


