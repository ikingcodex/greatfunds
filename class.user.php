<?php
  class USER{
      public $db;
      public $username;

      function __construct($DB_con){
        $this->db = $DB_con;
      }

      public function register($username,$email,$pnumber,$bank,$acc_number,$acc_name,$password){
        try{
          $new_password = password_hash($password, PASSWORD_DEFAULT);

          $stmt = $this->db->prepare("INSERT INTO users(username,email,phone_number,bank_name,account_number,account_name,password)
          VALUES(:username, :email, :pnumber, :bank, :acc_number, :acc_name, :password)");
          $stmt->bindparam(":username", $username);
          $stmt->bindparam(":email", $email);
          $stmt->bindparam(":pnumber", $pnumber);
          $stmt->bindparam(":bank", $bank);
          $stmt->bindparam(":acc_number", $acc_number);
          $stmt->bindparam(":acc_name", $acc_name);
          $stmt->bindparam(":password", $new_password);
          $stmt->execute();
          return $stmt;
        }
        catch(PDOException $e){
          echo $e->getMessage();
        }
      }

      public function update($username,$email,$pnumber,$bank,$acc_number,$acc_name,$password){
        try{
          $uname = $_SESSION['user_session'];
          if($password = ""){
            $new_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->db->prepare("UPDATE users SET username = :username, email = :email, phone_number = :pnumber, bank_name = :bank, account_number = :acc_number, account_name = :acc_name, password = :password WHERE username = :user");
            $stmt->bindparam(":username", $username);
            $stmt->bindparam(":email", $email);
            $stmt->bindparam(":pnumber", $pnumber);
            $stmt->bindparam(":bank", $bank);
            $stmt->bindparam(":acc_number", $acc_number);
            $stmt->bindparam(":acc_name", $acc_name);
            $stmt->bindparam(":user", $uname);
            $stmt->bindparam(":password", $new_password);
            $stmt->execute();
            return $stmt;
          }
          else{
            $new_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE users SET username = :username, email = :email, phone_number = :pnumber, bank_name = :bank, account_number = :acc_number, account_name = :acc_name WHERE username = :user");
            $stmt->bindparam(":username", $username);
            $stmt->bindparam(":email", $email);
            $stmt->bindparam(":pnumber", $pnumber);
            $stmt->bindparam(":bank", $bank);
            $stmt->bindparam(":acc_number", $acc_number);
            $stmt->bindparam(":acc_name", $acc_name);
            $stmt->bindparam(":user", $uname);
            $stmt->execute();
            return $stmt;
          }
        }
        catch(PDOException $e){
          echo $e->getMessage();
        }
      }

      public function login($uname,$upass){
        try{
          $stmt = $this->db->prepare("SELECT * FROM users WHERE username=:uname LIMIT 1");
          $stmt->execute(array(':uname'=>$uname));
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          if($stmt->rowCount() > 0){
            if(password_verify($upass, $userRow['password'])){
              $this->username =  $userRow['username'];
                $_SESSION['user_session'] = $this->username;
                return true;
            }
            else{
              return false;
            }
          }
        }
        catch(PDOException $e){
          echo $e->getMessage();
        }
      }

      public function is_loggedin(){
        if(isset($_SESSION['user_session'])){
          return true;
        }
        else{
          return false;
        }
      }

      public function redirect($url){
        header("Location: $url");
      }

      public function logout(){
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
      }

      public function not_paired(){
        try {
          $select = $this->db->prepare("SELECT is_paired FROM prohelp WHERE username=:uname LIMIT 1");
          $uname = $_SESSION['user_session'];
          $select->execute(array(':uname'=>$uname));
          $userRow = $select->fetch(PDO::FETCH_ASSOC);
          if ($userRow['is_paired'] == 0){
            return true;
          }
          else{
            return false;
          }
        }catch (PDOException $e) {
          echo $e->getMessage();
        }

      }

      public function start_timer(){
        if (!($this->has_pop())) {
          if (isset($_SESSION['time'])) {
            $time = $_SESSION['time'];
          }else {
            $uname = $_SESSION['user_session'];
            $stmt = $this->db->prepare("SELECT paired_time FROM prohelp WHERE username =:user");
            $stmt->bindparam(":user", $uname);
            $stmt->execute();
            $Row = $stmt->fetch(PDO::FETCH_ASSOC);
            $time_start = date("Y-m-d H:i:s",strtotime($Row['paired_time']));
            // $time_start = date("Y-m-d H:i:s");
          	$_SESSION['time'] = $time_start;
          	$time = $_SESSION['time'];
          }
        	$end_time = date("Y-m-d H:i:s", strtotime("+ 3 minute", strtotime($time)));
        	$from_time1 = Date("Y-m-d H:i:s");
        	$to_time = $end_time;
        	$time_first = strtotime($from_time1);
        	$time_second = strtotime($to_time);
        	$countdown = $time_second - $time_first;
        	$timer = gmdate("H:i:s",$countdown);
          if (date("Y-m-d H:i:s") >= $end_time) {
            $this->c_block_user();
            return "done";
          }
          else{
            return $timer;
          }
        }else {
          return "Timer Stopped";
        }
      }
      public function timepast(){
        $uname = $_SESSION['user_session'];
        $stmt = $this->db->prepare("SELECT paired_time FROM prohelp WHERE username =:user");
        $stmt->bindparam(":user", $uname);
        $stmt->execute();
        $Row = $stmt->fetch(PDO::FETCH_ASSOC);
        $time_start = date("Y-m-d H:i:s",strtotime($Row['paired_time']));
        $time = $time_start;
        $end_time = date("Y-m-d H:i:s", strtotime("+ 1 minute", strtotime($time)));
        $from_time1 = Date("Y-m-d H:i:s");
        $to_time = $end_time;
        $time_first = strtotime($from_time1);
        $time_second = strtotime($to_time);
        $countdown = $time_second - $time_first;
        $timer = gmdate("H:i:s",$countdown);
        if (date("Y-m-d H:i:s") >= $end_time) {
          return true;
        }
        else{
          return false;
        }
      }

      public function check(){
          if($this->not_paired()) {
            $uname = $_SESSION['user_session'];
            $stmt = $this->db->prepare("SELECT userid, username, num_of_pair FROM gethelp WHERE num_of_pair < 4 AND is_admin =1 ORDER BY time ASC LIMIT 1");
            $stmt->execute();
            $Row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0){
              $userid= $Row['userid'];
              $username = $Row['username'];
              if ($Row['num_of_pair'] == 3) {
                $newval = $Row['num_of_pair'] + 1;
                $update = $this->db->prepare("UPDATE gethelp SET num_of_pair=:numofpair,is_paired=1 WHERE userid=:userid");
                $update->bindparam(":userid", $userid);
                $update->bindparam(":numofpair", $newval);
                $update->execute();
                $this->paired_user();
              }
              else{
              $newval = $Row['num_of_pair'] + 1;
              $update = $this->db->prepare("UPDATE gethelp SET num_of_pair=:numofpair WHERE username=:username");
              $update->bindparam(":username", $username);
              $update->bindparam(":numofpair", $newval);
              $update->execute();
              $this->paired_user();
              }
              $update = $this->db->prepare("UPDATE prohelp SET paired_with=:user,is_paired = 1,paired_time = NOW() WHERE username=:username");
              $update->bindparam(":user", $username);
              $update->bindparam(":username", $uname);
              $update->execute();
              $this->paired_user();
              $this->start_timer();
            }else{
              $stmt = $this->db->prepare("SELECT userid, username, num_of_pair FROM gethelp WHERE num_of_pair < 2 ORDER BY time ASC LIMIT 1");
              $stmt->execute();
              $Row = $stmt->fetch(PDO::FETCH_ASSOC);
              if($stmt->rowCount() > 0){
                $userid= $Row['userid'];
                $username = $Row['username'];
                if ($Row['num_of_pair'] == 1) {
                  $newval = $Row['num_of_pair'] + 1;
                  $update = $this->db->prepare("UPDATE gethelp SET num_of_pair=:numofpair,is_paired=1 WHERE userid=:userid");
                  $update->bindparam(":userid", $userid);
                  $update->bindparam(":numofpair", $newval);
                  $update->execute();
                  $this->paired_user();
                }
                else{
                $newval = $Row['num_of_pair'] + 1;
                $update = $this->db->prepare("UPDATE gethelp SET num_of_pair=:numofpair WHERE username=:username");
                $update->bindparam(":username", $username);
                $update->bindparam(":numofpair", $newval);
                $update->execute();
                $this->paired_user();
                }
                $update = $this->db->prepare("UPDATE prohelp SET paired_with=:user,is_paired = 1,paired_time = NOW() WHERE username=:username");
                $update->bindparam(":user", $username);
                $update->bindparam(":username", $uname);
                $update->execute();
                $this->paired_user();
                $this->start_timer();
              }else{
                $this->paired_user();
              }
            }
        }
      }

      public function cycle(){
        try{
          $select = $this->db->prepare("SELECT username,phone_number,account_name,account_number,bank_name FROM users WHERE username=:uname LIMIT 1");
          $uname = $_SESSION['user_session'];
          $select->execute(array(':uname'=>$uname));
          $userRow = $select->fetch(PDO::FETCH_ASSOC);
          $username = $userRow['username'];
          $phone_number = $userRow['phone_number'];
          $account_name = $userRow['account_name'];
          $account_number = $userRow['account_number'];
          $bank_name = $userRow['bank_name'];
          $insert = $this->db->prepare("INSERT INTO prohelp(username,phone_number,account_name,bank_name,account_number)
          VALUES(:username, :pnumber, :acc_name, :bank, :acc_number)");
          $insert->bindparam(":username", $username);
          $insert->bindparam(":pnumber", $phone_number);
          $insert->bindparam(":acc_name", $account_name);
          $insert->bindparam(":acc_number", $account_number);
          $insert->bindparam(":bank", $bank_name);
          $insert->execute();
          $this->check();
        }
        catch(PDOException $e){
             echo $e->getMessage();
        }
      }

      public function is_in_ph(){
        try{
          $uname = $_SESSION['user_session'];
          $ph = $this->db->prepare("SELECT * FROM prohelp WHERE username=:uname LIMIT 1");
          $ph->execute(array(':uname'=>$uname));
          $userRow=$ph->fetch(PDO::FETCH_ASSOC);

          if($ph->rowCount() > 0){
              return true;
          }
            else{
              return false;
            }
          }
        catch(PDOException $e){
          echo $e->getMessage();
        }
      }
      public function is_in_gh(){
        try{
          $uname = $_SESSION['user_session'];
          $gh = $this->db->prepare("SELECT * FROM gethelp WHERE username=:uname LIMIT 1");
          $gh->execute(array(':uname'=>$uname));
          $userRow=$gh->fetch(PDO::FETCH_ASSOC);

          if($gh->rowCount() > 0){
              return true;
          }
            else{
              return false;
            }
          }
          catch(PDOException $e){
          echo $e->getMessage();
        }
      }

      public function is_in_cycle(){
         if ($this->is_in_ph() || $this->is_in_gh()) {
          return true;
         }
         else {
           return false;
         }
      }
      public function paired_user(){
        try {
          $select = $this->db->prepare("SELECT paired_with FROM prohelp WHERE username=:uname LIMIT 1");
          $uname = $_SESSION['user_session'];
          $select->execute(array(':uname'=>$uname));
          $userRow = $select->fetch(PDO::FETCH_ASSOC);
          if ($userRow['paired_with'] != null || $userRow['paired_with'] != "" ){
            return $userRow['paired_with'];
          }
          else{
            return false;
          }
        }catch (PDOException $e) {
          echo $e->getMessage();
        }

      }

      public function c_block_user(){
        try{
            $select = $this->db->prepare("SELECT username,paired_with,phone_number,account_name,account_number,bank_name,pop FROM prohelp WHERE username=:uname LIMIT 1");
            $uname = $_SESSION['user_session'];
            $select->execute(array(':uname'=>$uname));
            $userRow = $select->fetch(PDO::FETCH_ASSOC);
            $username = $userRow['username'];
            $paired_with = $userRow['paired_with'];
            $phone_number = $userRow['phone_number'];
            $account_name = $userRow['account_name'];
            $account_number = $userRow['account_number'];
            $bank_name = $userRow['bank_name'];
            $pop = $userRow['pop'];
            $insert = $this->db->prepare("INSERT INTO blocked(username,paired_with,phone_number,account_name,bank_name,account_number,pop)
            VALUES(:username, :paired_with, :pnumber, :acc_name, :bank, :acc_number, :pop)");
            $insert->bindparam(":username", $username);
            $insert->bindparam(":paired_with", $paired_with);
            $insert->bindparam(":pnumber", $phone_number);
            $insert->bindparam(":acc_name", $account_name);
            $insert->bindparam(":acc_number", $account_number);
            $insert->bindparam(":bank", $bank_name);
            $insert->bindparam(":pop", $pop);
            $insert->execute();
            $stmt = $this->db->prepare("SELECT userid, username, num_of_pair,is_admin FROM gethelp WHERE username=:paired_with");
            $stmt->bindparam(":paired_with", $paired_with);
            $stmt->execute();
            $Row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0){
              $userid= $Row['userid'];
              $username = $Row['username'];
              if ($Row['is_admin'] == 1) {
                if ($Row['num_of_pair'] == 4) {
                  $newval = $Row['num_of_pair'] - 1;
                  $update = $this->db->prepare("UPDATE gethelp SET num_of_pair=:numofpair,is_paired=0 WHERE userid=:userid");
                  $update->bindparam(":userid", $userid);
                  $update->bindparam(":numofpair", $newval);
                  $update->execute();
                }
                else{
                $newval = $Row['num_of_pair'] - 1;
                $update = $this->db->prepare("UPDATE gethelp SET num_of_pair=:numofpair WHERE username=:username");
                $update->bindparam(":username", $username);
                $update->bindparam(":numofpair", $newval);
                $update->execute();
                }
              }
              else{
                if ($Row['num_of_pair'] == 2) {
                  $newval = $Row['num_of_pair'] - 1;
                  $update = $this->db->prepare("UPDATE gethelp SET num_of_pair=:numofpair,is_paired=0 WHERE userid=:userid");
                  $update->bindparam(":userid", $userid);
                  $update->bindparam(":numofpair", $newval);
                  $update->execute();
                }
                else{
                $newval = $Row['num_of_pair'] - 1;
                $update = $this->db->prepare("UPDATE gethelp SET num_of_pair=:numofpair WHERE username=:username");
                $update->bindparam(":username", $username);
                $update->bindparam(":numofpair", $newval);
                $update->execute();
                }
              }
            }
            $delete = $this->db->prepare("DELETE FROM prohelp WHERE username =:user");
            $uname = $_SESSION['user_session'];
            $delete->bindparam(":user", $uname);
            $delete->execute();
            $update = $this->db->prepare("UPDATE users SET is_blocked = 1 WHERE username =:user");
            $uname = $_SESSION['user_session'];
            $update->bindparam(":user", $uname);
            $update->execute();

        }catch (PDOException $e) {
          echo $e->getMessage();
        }
      }

      public function is_blocked(){
        try{
          $uname = $_SESSION['user_session'];
          $stmt = $this->db->prepare("SELECT * FROM users WHERE username= :uname AND is_blocked=1 ");
          $stmt->execute(array(':uname'=>$uname));
          if($stmt->rowCount() > 0){
              return true;
          }
            else{
              return false;
            }
          }
        catch(PDOException $e){
          echo $e->getMessage();
        }
      }

      public function is_in_blockedlist(){
        try{
          $uname = $_SESSION['user_session'];
          $user = $this->db->prepare("SELECT * FROM blocked WHERE username=:uname");
          $user->execute(array(':uname'=>$uname));

          if($user->rowCount() > 0){
              return true;
          }
            else{
              return false;
            }
          }
        catch(PDOException $e){
          echo $e->getMessage();
        }
      }

      public function upload_pop($iname,$itmp,$isize){
        $upload_dir = "uploads/";
        if (empty($iname)) {
    			echo "Please insert image";
    		}
    		else {
    			$imgExt = strtolower(pathinfo($iname,PATHINFO_EXTENSION));
    			$allowExt = array('jpeg','jpg','png','gif');
    			$userPic = time().'_'.rand(1000,9999).'.'.$imgExt;
    			if (in_array($imgExt,$allowExt)) {
    				if ($isize < 50000000) {
    					move_uploaded_file($itmp,$upload_dir.$userPic);
              try{
                $stmt = $this->db->prepare("UPDATE prohelp SET pop =:pop WHERE username =:username");
                $username = $_SESSION['user_session'];
                $stmt->bindparam(":username", $username);
                $stmt->bindparam(":pop", $userPic);
                $stmt->execute();
                return $stmt;
              }
              catch(PDOException $e){
                echo $e->getMessage();
              }
    				}
    				else{
    					echo "image too large";
    				}
    			}
    			else {
    				echo "please enter a valide image";
    			}
    		}
      }

      public function has_pop(){
        try{
          $uname = $_SESSION['user_session'];
          $user = $this->db->prepare("SELECT pop FROM prohelp WHERE username=:uname");
          $user->execute(array(':uname'=>$uname));
          $Row = $user->fetch(PDO::FETCH_ASSOC);

          if($Row['pop'] != "" || $Row['pop'] != null){
              return true;
          }
            else{
              return false;
            }
          }
        catch(PDOException $e){
          echo $e->getMessage();
        }
      }

      public function confirm($user){
        try {
          $iselect = $this->db->prepare("SELECT pop FROM prohelp WHERE username=:uname");
          $iselect->execute(array(':uname'=>$user));
          $iRow = $iselect->fetch(PDO::FETCH_ASSOC);
          $uname = $_SESSION['user_session'];
          $delete = $this->db->prepare("DELETE FROM prohelp WHERE username =:user");
          $delete->bindparam(":user", $user);
          $delete->execute();
          $insert = $this->db->prepare("INSERT INTO gethelp(username) VALUES(:username)");
          $insert->bindparam(":username", $user);
          $insert->execute();
          $select = $this->db->prepare("SELECT * FROM gethelp WHERE username=:uname");
          $select->execute(array(':uname'=>$user));
          if ($select->rowCount() > 0) {
            if (isset($iRow['pop'])) {
              unlink("uploads/".$iRow['pop']);
            }
            $select = $this->db->prepare("SELECT is_confirmed FROM gethelp WHERE username=:username");
            $select->bindparam(":username", $uname);
            $select->execute();
            $Row = $select->fetch(PDO::FETCH_ASSOC);
            if ($Row['is_confirmed'] == 1) {
              $delete = $this->db->prepare("DELETE FROM gethelp WHERE username =:user");
              $delete->bindparam(":user", $uname);
              $delete->execute();
              $iselect = $this->db->prepare("SELECT number_of_cycles FROM users WHERE username=:uname");
              $iselect->execute(array(':uname'=>$uname));
              $iRow = $iselect->fetch(PDO::FETCH_ASSOC);
              $newval = $iRow['number_of_cycles'] + 1;
              $update = $this->db->prepare("UPDATE users SET number_of_cycles =:val WHERE username =:username");
              $update->bindparam(":val", $newval);
              $update->bindparam(":username", $uname);
              $update->execute();

            }
            else {
              $newval = $Row['is_confirmed'] + 1;
              $update = $this->db->prepare("UPDATE gethelp SET is_confirmed =:val WHERE username =:username");
              $update->bindparam(":val", $newval);
              $update->bindparam(":username", $uname);
              $update->execute();
            }
          }
        } catch (PDOException $e) {
          echo $e->getMessage();
        }
      }

      public function confirmed($uname){
        try{
          $user = $this->db->prepare("SELECT * FROM gethelp WHERE username=:uname");
          $user->execute(array(':uname'=>$uname));

          if ($user->rowCount() > 0) {
              return true;
          }
            else{
              return false;
            }
          }
        catch(PDOException $e){
          echo $e->getMessage();
        }
      }

      public function is_admin(){
        try{
          $uname = $_SESSION['user_session'];
          $user = $this->db->prepare("SELECT * FROM users WHERE username=:uname AND is_admin=1");
          $user->execute(array(':uname'=>$uname));

          if ($user->rowCount() > 0) {
              return true;
          }
            else{
              return false;
            }
          }
        catch(PDOException $e){
          echo $e->getMessage();
        }
      }
  }
?>
