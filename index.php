<?php
require_once 'class.db.php';

if($user->is_loggedin())
{
 require_once 'profile.php';
}
else{
  require_once 'home.php';
}
?>
