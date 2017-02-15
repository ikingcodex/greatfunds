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
                // $this->username =  $userRow['username'];
                  // $_SESSION['user_session'] = $this->username;
                  $_SESSION['user_session'] = $userRow['username'];
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

    // public function cycle(){
    //   try{
    //     $stmt = $this->db->prepare("INSERT INTO prohelp(username)VALUES(:username)");
    //     $stmt->bindparam(":username", $this->userid);
    //     $stmt->execute();
    //
    //     return $stmt;
    //   }
    //   catch(PDOException $e){
    //        echo $e->getMessage();
    //   }
    // }
    }
?>
