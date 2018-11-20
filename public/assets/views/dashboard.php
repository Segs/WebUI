<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config/config.php';
require_once '../vendor/autoload.php';
require_once '../vendor/tivoka/tivoka/include.php';

try{
    $client = Tivoka\Client::connect($ws_target)->getNativeInterface();
    try{
        // verify server online
        $client->ping();
        $server_online = $client->last_request->result;
        $server_status = "ONLINE";
        $server_status_color = "success";
        // get server version
        try {
            $client->getVersion();
            $server_version = $client->last_request->result;
            $server_version_color = "success";
        } catch(Exception $e) {
            $server_version = "NO DATA";
            $server_version_color = "danger";
        }
        // get server start time
        try {
            require_once '../src/dateTime.php';
            $client->getStartTime();
            $server_uptime = (int)$client->last_request->result;
            $server_uptime = dateDiff(time(), $server_uptime,6,1);
            $server_uptime_color = "success";
        } catch(Exception $e) {
            $server_uptime = "NO DATA";
            $server_uptime_color = "danger";
        }
    } catch(Exception $e) {
        $server_status = "OFFLINE";
        $server_status_color = "danger";
        $server_version = "NO DATA";
        $server_version_color = "danger";
        $server_uptime = "NO DATA";
        $server_uptime_color = "danger";
    }
}
catch(Exception $e) {
    $server_status = "OFFLINE";
    $server_status_color = "danger";
    $server_uptime = "NO DATA";
    $server_uptime_color = "danger";
    $server_version = "NO DATA";
    $server_version_color = "danger";
}

?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
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
                <div class="col-lg-4 col-md-6 col-sm-12">
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
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-stats">
                    <div class="card-header card-header-<?php echo $server_version_color; ?> card-header-icon">
                        <div class="card-icon"><i class="fa fa-code"></i></div>
                        <p class="card-category">Server Version</p>
                        <h4 class="card-title"><?php echo $server_version; ?></h4>
                    </div>
                    <div class="card-footer">
                        <div class="stats"><i class="material-icons">update</i>Updated <?php echo date("Y-m-d h:i:s a") ?></div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon"><i class="fa fa-user-circle-o"></i></div>
                        <p class="card-category">Players Online</p>
                        <h4 class="card-title">23</h4>
                    </div>
                    <div class="card-footer">
                        <div class="stats"><i class="material-icons">update</i>Updated <?php echo date("Y-m-d h:i:s a") ?></div>
                    </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
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
                <div class="col-lg-4 col-md-6 col-sm-12">
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
        </div>
    </div>
    <script type="text/javascript">
        window.onload = function () {
            getAccountsInfo();
        }
    </script>
