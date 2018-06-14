<?php
  $title = "SEGS page";
  $serverstatus = "ONLINE";
  include 'functions.php';
?>
<!DOCTYPE HTML5>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="scripts.js"></script>
    <title>
      <?php echo $title; ?>
    </title>
    <meta property="og:title" content="<?php echo $title; ?>">
    <meta property="og:description" content="A page about SEGS">
    <meta property="og:image" content="https://github.com/Segs/Segs/raw/develop/docs/segs-medallion-med.png">
    <meta property="twitter:card" content="summary_large_image">
    <meta charset="UTF-8">
    <script type="text/view" id="dash">
      <div id="dashy" class="contained">
        <div id="serverstatus">
          <p class="bigtext">Server Status</p>
          Server is currently <span id="onoff"><?php echo $serverstatus; ?></span>
          <div id="statsbox">
	    <div class="value">Server Uptime</div><div class="size">32d, 16h, 23m</div>
	    <div class="value">Players Online</div><div class="size">23</div>
	    <div class="value">Server Version</div><div class="size">0.5.0</div>
	    <div class="value">Unique Accounts</div><div class="size" id="numaccs"></div>
	    <div class="value">Characters Created</div><div class="size" id="numchars"></div>
          </div>
        </div>
        <div id="inbox">
        </div>
      </div>
      <div id="signup" class="contained">
        <form id="signupform" method="POST" onsubmit="signupFunction(); return false;" >
          <legend class="bigtext">Account Sign-up</legend>
	  <div>
            <label for="username">User:</label>
	    <input type="text" maxlength="14" name="username" id="username" placeholder="xxxxx" required />
	  </div>
	  <div>
            <label for="password">Pass:</label>
	    <input type="password" maxlength="14" id="pass" name="password" required />
	  </div>
          <input type="submit" value="Sign up" name="loginsubmit" />
          <div id="signupFail"></div>
        </form>
      </div>
      <div id="statistics" class="contained">
        <p class="bigtext">Statistics</p>
	<?php
	  //fetchstats();
          echo "There is a dashboard. What more could you possibly want?";
	?>
      </div>
      <div id="chatlog" class="contained">
        <p class="bigtext">Chat logs</p>
	<?php
	  //fetchchat();
          echo "On a cloudy day, you might find chat logs here.";
	?>
      </div>
      <div id="servlog" class="contained">
        <p class="bigtext">Server logs</p>
	<?php
	  //fetchserv();
          echo "Here will be server logs. One day.";
	?>
      </div>
    </script>
  </head>
  <body>
    <div id="container">
      <div id="leftmenu">
        <img src="https://github.com/Segs/Segs/raw/develop/docs/segs-medallion-med.png">
        <div class="leftchoice">
          left nav entry 1
        </div>
        <div class="leftchoice">
          left nav entry 2
        </div>
        <div class="leftchoice">
          left nav entry 3
        </div>
        <div id="reportbutton">
          Report Bugs!
        </div>
      </div>
      <div id="headmenu">
        <div class="item selected" id="dashboard" onClick="goHome();">
          Server Dashboard
          <div class="arrow">
          </div>
        </div>
        <div class="item others" id="accounts" onClick="goAccs();">
          User Accounts
          <div class="arrow">
          </div>
        </div>
        <div class="item others" id="stats" onClick="goStats();">
          Statistics
          <div class="arrow">
          </div>
        </div>
        <div class="item others" id="chatlogs" onClick="goClogs();">
          Chat logs
          <div class="arrow">
          </div>
        </div>
        <div class="item others" id="serverlogs" onClick="goSlogs();">
          Server logs
          <div class="arrow">
          </div>
        </div>
      </div>
      <div id="pagebody">
      </div>
    </div>
  </body>
</html>
