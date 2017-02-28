<?php
require_once '../class.db.php';

if($admin->is_loggedin())
{
 require_once 'Dashboard.php';
}
else{
  require_once 'login.php';
}
?>
