<?php
    /*
     * SEGS - Super Entity Game Server
     * http://www.segs.io/
     * Copyright (c) 2006 - 2018 SEGS Team (see AUTHORS.md)
     * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
     */
?>
<div class="card">
    <div class="card-header card-header-<?php echo $site_color; ?>">
        <h4 class="card-title ">Switch Zones</h4>
        <p class="card-category">Move a character.</p>
    </div>
    <div class="card-body">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div id="switchbox"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(isset($_SESSION['isAuthenticated'])) { ?>
    <script type="text/javascript">
        window.onload = function () {
            doZoneSwitch();
        }
    </script>
<?php } else { ?>
    <script type="text/javascript">
        var sb = document.getElementById('switchbox');
        sb.innerHTML = "<p class=\"alert alert-info\">You must be logged in to move a character.</p>";
    </script>
<?php } ?>

