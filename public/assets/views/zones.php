<?php
    /*
     * SEGS - Super Entity Game Server
     * http://www.segs.io/
     * Copyright (c) 2006 - 2019 SEGS Team (see AUTHORS.md)
     * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
     */
    $page_title = "Switch Zones";
    $page_summary = "Move a character.";

    require "partials/page_top.php";
?>
                <div class="row">
                    <div class="col-md-12">
                        <div id="switchbox"></div>
                    </div>
                </div>
<?php require_once "partials/page_bottom.php"; ?>

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

