<?php
    /*
     * SEGS - Super Entity Game Server
     * http://www.segs.io/
     * Copyright (c) 2006 - 2019 SEGS Team (see AUTHORS.md)
     * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
     */

    require_once '../config/config.php';
    require_once '../vendor/autoload.php';
    require_once '../vendor/tivoka/tivoka/include.php';

    use Segs\DateTime;

    // Set default statuses
    $server_status = "OFFLINE";
    $server_status_color = "danger";
    $server_uptime = "NO DATA";
    $server_uptime_color = "danger";
    $server_version_number = "NO DATA";
    $server_version_number_color = "danger";
    $server_version_name = "NO DATA";
    
    // Create websocket URL
    if($ws_use_ssl){
        $ws_target_protocol = "wss://";
    } else {
        $ws_target_protocol = "ws://";
    }
    $target = "{$ws_target_protocol}{$ws_target_addr}:{$ws_target_port}";

    try {
        $client = Tivoka\Client::connect($target)->getNativeInterface();
        try {
            // verify server online
            $client->ping();
            $server_online = $client->last_request->result;
            $server_status = "ONLINE";
            $server_status_color = "success";
            // get server version number
            try {
                $client->getVersion();
                $server_version_number = $client->last_request->result;
                $server_version_number_color = "success";
            } catch(Exception $e) {
                $server_version_number = "NO DATA";
                $server_version_number_color = "danger";
            }
            // get server version name
            try {
                $client->getVersionName();
                $server_version_name = $client->last_request->result;
            } catch(Exception $e) {
                $server_version_name = "NO DATA";
            }
            // get server start time
            try {
                $dt = new DateTime($timezone);
                $client->getStartTime();
                $server_uptime = (int)$client->last_request->result;
                $server_uptime = $dt->dateDiff(time(), $server_uptime,6,1);
                $server_uptime_color = "success";
            } catch(Exception $e) {
                $server_uptime = "NO DATA";
                $server_uptime_color = "danger";
            }
        } catch(Exception $e) {
            // TODO: Handle error, as well as notify user and/or log.
        }
    } catch(Exception $e) {
        // TODO: Handle error, as well as notify user and/or log.
    }
    
    $page_title = "Dashboard";
    $page_summary = "Status of the server and users.";
    
    require "partials/page_top.php";
?>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card card-stats">
                            <div class="card-header card-header-<?php echo $server_status_color; ?> card-header-icon">
                                <div class="card-icon"><i class="fa fa-heartbeat"></i></div>
                                <p class="card-category">Server Status</p>
                                <h4 class="card-title"><?php echo $server_status; ?></h4>
                            </div>
                            <div class="card-footer">
                                <div class="stats"><i class="material-icons">update</i>Updated <?php echo date("Y-m-d h:i:s a") ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card card-stats">
                        <div class="card-header card-header-<?php echo $server_uptime_color; ?> card-header-icon">
                            <div class="card-icon"><i class="material-icons">access_time</i></div>
                            <p class="card-category">Server Uptime</p>
                            <h4 class="card-title"><?php echo $server_uptime; ?></h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats"><i class="material-icons">update</i>Updated <?php echo date("Y-m-d h:i:s a") ?></div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card card-stats">
                        <div class="card-header card-header-<?php echo $server_version_number_color; ?> card-header-icon">
                            <div class="card-icon"><i class="fa fa-code"></i></div>
                            <p class="card-category">Server Version</p>
                            <h4 class="card-title"><?php echo "{$server_version_number} \"{$server_version_name}\""; ?></h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats"><i class="material-icons">update</i>Updated <?php echo date("Y-m-d h:i:s a") ?></div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card card-stats">
                        <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon"><i class="fa fa-user-astronaut"></i></div>
                            <p class="card-category">Players Online</p>
                            <h4 class="card-title">23</h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats"><i class="material-icons">update</i>Updated <?php echo date("Y-m-d h:i:s a") ?></div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card card-stats">
                        <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon"><i class="fa fa-users"></i></div>
                            <p class="card-category">Unique Users</p>
                            <h4 class="card-title"><div id="num_accts"></div></h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats"><i class="material-icons">update</i>Updated <?php echo date("Y-m-d h:i:s a") ?></div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card card-stats">
                            <div class="card-header card-header-info card-header-icon">
                                <div class="card-icon"><i class="fa fa-user-secret"></i></div>
                                <p class="card-category">Characters</p>
                                <h4 class="card-title"><div id="num_chars"></div></h4>
                            </div>
                            <div class="card-footer">
                                <div class="stats"><i class="material-icons">update</i>Updated <?php echo date("Y-m-d h:i:s a") ?></div>
                            </div>
                        </div>
                    </div>
                </div>
<?php require_once "partials/page_bottom.php"; ?>

<script type="text/javascript">
    window.onload = function () {
        getAccountsInfo();
    }
</script>
