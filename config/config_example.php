<?php
    /*
     * SEGS - Super Entity Game Server
     * http://www.segs.io/
     * Copyright (c) 2006 - 2019 SEGS Team (see AUTHORS.md)
     * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
     */
 
    // Site Settings
    $site_title                 = "SEGS";
    $site_name                  = "SEGS";
    $site_url                   = "//segs.io";
    $site_logo                  = "//github.com/Segs/Segs/raw/develop/docs/segs-medallion-med.png";
    $site_admin                 = "webmaster@example.com";
    /*
        You can change some of the WebUI colors to the following:
        "dark | gold | purple | azure | green | orange | danger"
    */
    $site_color                 = "gold";
    $site_navbar_title          = "SEGS WebUI";

    // Database Settings
    $dbhost                     = "localhost";
    $dbuser                     = "segsadmin";
    $dbpass                     = "segs123";
    $accdb                      = "segs";
    $chardb                     = "segs_game";

    // User Account Settings;
    $min_username_len           = 6;
    $min_password_len           = 15;
    $complex_password           = true;
    $login_users_on_create      = true;
    $warn_pwned_password        = true;
    
    // WebSocket connection
    $ws_target                  = "ws://localhost/";
    $ws_port                    = 6001;
    $ws_use_ssl                 = false;

    // Date and Time
    $timezone                   = "UTC";
