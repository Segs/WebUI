      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Switch Zones</h4>
                  <p class="card-category">Move a character.</p>
                </div>
                <div class="card-body">
					<div id="switchbox"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php if(isset($_SESSION['authenticated'])) { ?>
          <script type="text/javascript">
              window.onload = function () {
                  goZoneSwitch();
              }
          </script>
      <?php } else { ?>
          <script type="text/javascript">
              var sb = document.getElementById('switchbox');
              sb.innerHTML = "<p class=\"alert alert-info\">You must be logged in to move a character.</p>";
          </script>
      <?php } ?>

