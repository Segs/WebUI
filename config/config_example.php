<?php
    /*
     * SEGS - Super Entity Game Server
     * http://www.segs.io/
     * Copyright (c) 2006 - 2018 SEGS Team (see AUTHORS.md)
     * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
     */
 
    // Server Settings
    $site_title     = "SEGS";
    $site_name      = "SEGS";
    $site_url       = "https://segs.io";
    $site_logo      = "https://github.com/Segs/Segs/raw/develop/docs/segs-medallion-med.png";
    $site_admin     = "webmaster@example.com";
    /*
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"
        Tip 2: you can also add an image using data-image tag
    */
    $site_color         = "green";
    $site_navbar_title  = "SEGS WebUI";

    // Database Settings
    $dbhost         = "localhost";
    $dbuser         = "segsadmin";
    $dbpass         = "segs123";
    $accdb          = "segs";
    $chardb         = "segs_game";

    // WebSocket connection
    $ws_target      = "ws://localhost/";
    $ws_port        = 6001;
    $ws_use_ssl     = false;

    // Date and Time
    $timezone       = "UTC";

?>