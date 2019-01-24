<?php
/*
 * SEGS - Super Entity Game Server
 * http://www.segs.io/
 * Copyright (c) 2006 - 2018 SEGS Team (see Authors.md)
 * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
 */
  include 'functions.php';
  $res = new RET_TYPE();
  onlineStatus($res);
  echo json_encode( $res );
?>
