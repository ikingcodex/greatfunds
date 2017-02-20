<?php
include '../class.db.php';
if($user->is_loggedin()){
  $outp = $user->paired_user();
  // echo $outp;
  if (isset($_GET['view'])){
    $view = $_GET['view'];
    switch ($view) {
      case 'user':
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        json_encode($outp);
        $outp ='{"paired_user":"'.$outp.'"}';
        echo $outp;
        break;

      case $outp:
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        $output = "";

        $select = $database->db->prepare("SELECT username,email,phone_number,bank_name,account_number,account_name FROM users WHERE username=:uname LIMIT 1");
        $select->execute(array(':uname'=>$outp));
        $userRow = $select->fetch(PDO::FETCH_ASSOC);
        $output .= '{"name":"' .$userRow["username"] . '","phone_number":"' .$userRow["phone_number"] . '","account_name":"' .$userRow["account_name"] . '",';
        $output .= '"bank_name":"' .$userRow["bank_name"] . '",';
        $output .= '"number":"' .$userRow["account_number"] . '"}';
        $output = '{"paired_user_info":['.$output.']}' ;

        echo $output;
        break;

      case 'check':
        $user->check();
        if (!($user->not_paired())) {
          json_encode($outp);
          $outp ='{"paired_user":"'.$outp.'"}';
          echo $outp;
        }
        else{
          echo '{}';
        }
        break;
      default:
        echo '{"error":"404"}';
        break;
    }
  }
  else {
    echo '{"error":"404"}';
  }
}

?>
