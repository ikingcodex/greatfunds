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
        public function timer(){
          if (isset($_SESSION['time'])) {
            $time = $_SESSION['time'];
          }else {
            $time_start = date("Y-m-d H:i:s");
          	$_SESSION['time'] = $time_start;
          	$time = $_SESSION['time'];
          }
        	$end_time = date("Y-m-d H:i:s", strtotime("+ 1 minutes", strtotime($time)));
        	$from_time1 = Date("Y-m-d H:i:s");
        	$to_time = $end_time;
        	$time_first = strtotime($from_time1);
        	$time_second = strtotime($to_time);
        	$countdown = $time_second - $time_first;
        	$timer = gmdate("H:i:s",$countdown);
          return $timer;
        }
        public function check(){
            if($this->not_paired()) {
              $uname = $_SESSION['user_session'];
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
                $update = $this->db->prepare("UPDATE prohelp SET paired_with=:user,is_paired = 1 WHERE username=:username");
                $update->bindparam(":user", $username);
                $update->bindparam(":username", $uname);
                $update->execute();
                $this->paired_user();
              }else{
                $this->paired_user();
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
    }
?>
