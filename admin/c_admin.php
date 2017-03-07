<?php

  require_once '../class.db.php';

  if(!($admin->is_loggedin()))
  {
      $user->redirect('login.php');
  }

  if(isset($_POST['btn-signup']))
  {

    $username=htmlspecialchars(strip_tags(trim($_POST['username'])));
    $email=htmlspecialchars(strip_tags(trim($_POST['email'])));
    $pnumber=htmlspecialchars(strip_tags(trim($_POST['pnumber'])));
    $bank=htmlspecialchars(strip_tags(trim($_POST['bank'])));
    $acc_number=htmlspecialchars(strip_tags(trim($_POST['accnumber'])));
    $acc_name=htmlspecialchars(strip_tags(trim($_POST['accname'])));
    $password=htmlspecialchars(strip_tags(trim($_POST['password'])));

     if($username=="") {
        echo "provide username !";
     }
     else if($email=="") {
        echo  "provide email id !";
     }
     else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Please enter a valid email address !';
     }
     else if($password == "") {
        echo "provide password !";
     }
     else if(strlen($password) < 6){
        echo "Password must be atleast 6 characters";
     }
     else
     {
        try
        {
           $stmt = $admin->db->prepare("SELECT username,email FROM users WHERE username=:uname OR email=:umail");
           $stmt->execute(array(':uname'=>$username, ':umail'=>$email));
           $row=$stmt->fetch(PDO::FETCH_ASSOC);

           if($row['username'] == $username) {
              echo "sorry username already taken !";
           }
           else if($row['email'] == $email) {
              echo "sorry email id already taken !";
           }
           else
           {
              if($admin->register($username,$email,$pnumber,$bank,$acc_number,$acc_name,$password))
              {
                  $admin->redirect('c_admin.php?registered');
              }
           }
       }
       catch(PDOException $e)
       {
          echo $e->getMessage();
       }
    }
  }

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Light Bootstrap Dashboard by Creative Tim</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />
		<link rel="stylesheet" href="../css/style.css">
	  <link rel="stylesheet" href="../css/set1.css">
	  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	  <link rel="stylesheet" type="text/css" href="../css/cs-select.css" />
	  <link rel="stylesheet" type="text/css" href="../css/cs-skin-elastic.css" />


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <style media="screen">
      .content{
        padding: 0px !important;
      }
    </style>

</head>
<body>

<div class="wrapper">
	<?php include "include/sidebar.php" ?>

    <div class="main-panel">
		<nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Create Admin</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-dashboard"></i>
								<p class="hidden-lg hidden-md">Dashboard</p>
                            </a>
                        </li>
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-globe"></i>
                                    <b class="caret hidden-sm hidden-xs"></b>
                                    <span class="notification hidden-sm hidden-xs">5</span>
									<p class="hidden-lg hidden-md">
										5 Notifications
										<b class="caret"></b>
									</p>
                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Notification 1</a></li>
                                <li><a href="#">Notification 2</a></li>
                                <li><a href="#">Notification 3</a></li>
                                <li><a href="#">Notification 4</a></li>
                                <li><a href="#">Another notification</a></li>
                              </ul>
                        </li>
                        <li>
                           <a href="">
                                <i class="fa fa-search"></i>
								<p class="hidden-lg hidden-md">Search</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                           <a href="">
                               <p>Account</p>
                            </a>
                        </li>
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <p>
										Dropdown
										<b class="caret"></b>
									</p>

                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                              </ul>
                        </li>
                        <li>
                            <a href="#">
                                <p>Log out</p>
                            </a>
                        </li>
						<li class="separator hidden-lg hidden-md"></li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
							<div class="row">
					      <form class="" action="c_admin.php" method="post" name="signform" onsubmit="return signup()">
					        <div class="col-md-6 left-side">
					          <span class="input input--hoshi">
					            <input class="input__field input__field--hoshi" type="text" id="username" name="username" required/>
					            <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="username">
					              <span class="input__label-content input__label-content--hoshi">UserName</span>
					            </label>
					          </span>
					          <span class="input input--hoshi">
					            <input class="input__field input__field--hoshi" type="email" name="email" id="email" required/>
					            <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="email">
					              <span class="input__label-content input__label-content--hoshi">E-mail</span>
					            </label>
					          </span>
					          <span class="input input--hoshi">
					            <input class="input__field input__field--hoshi" type="text" name="pnumber" id="pnumber" required/>
					            <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="pnumber">
					              <span class="input__label-content input__label-content--hoshi">Phone Number</span>
					            </label>
					          </span>
										<span class="input input--hoshi">
					            <input class="input__field input__field--hoshi" type="text" name="accnumber" id="accnumber" required/>
					            <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="accnumber">
					              <span class="input__label-content input__label-content--hoshi">Account Number</span>
					            </label>
					          </span>
					          <select class="cs-select cs-skin-elastic" id="bank" name="bank">
					  					<option value="" disabled selected>Please! select your bank</option>
					  					<option value="Diamond Bank">Diamond Bank</option>
					  					<option value="First Bank">First Bank</option>
					  					<option value="Skye Bank">Skye Bank</option>
					  					<option value="Eco Bank">Eco Bank</option>
					            <option value="Keystone Bank">Keystone Bank</option>
					  					<option value="Guaranty Trust Bank">Guaranty Trust Bank</option>
					            <option value="Wema Bank">Wema Bank</option>
					  					<option value="UBA Bank">UBA Bank</option>
					            <option value="Access Bank">Access Bank</option>
					            <option value="City Bank">City Bank</option>
					            <option value="Enterprise Bank">Enterprise Bank</option>
					            <option value="Fidelity Bank">Fidelity Bank</option>
					            <option value="First City Monument Bank">First City Monument Bank</option>
					            <option value="Heritage Bank">Heritage Bank</option>
					            <option value="Stanbic IBTC Bank">Stanbic IBTC Bank</option>
					            <option value="Standard Chartered Bank">Standard Chartered Bank</option>
					            <option value="Union Bank">Union Bank</option>
					            <option value="Zenith Bank">Zenith Bank</option>
					  				</select>
					        </div>
					        <div class="col-md-6 right-side">
					          <span class="input input--hoshi">
					            <input class="input__field input__field--hoshi" type="text" name="accname" id="accname" required/>
					            <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="accname">
					              <span class="input__label-content input__label-content--hoshi">Account Name</span>
					            </label>
					          </span>
					          <span class="input input--hoshi">
					            <input class="input__field input__field--hoshi" type="password" name="password" id="password" required/>
					            <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="password">
					              <span class="input__label-content input__label-content--hoshi">Password</span>
					            </label>
					          </span>
					          <span class="input input--hoshi">
					            <input class="input__field input__field--hoshi" type="password" name="rpassword" id="rpassword" required/>
					            <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="rpassword">
					              <span class="input__label-content input__label-content--hoshi">Repeat Password</span>
					            </label>
					          </span>
					          <div class="cta">
					            <button type="submit" class="btn btn-primary pull-left" name="btn-signup">
					              Sign-Up Now
					            </button>
					          </div>
					        </div>
					      </form>
					    </div>
            </div>
        </div>


        <?php include 'include/footer.php'; ?>

    </div>
</div>


</body>

        <!--   Core JS Files   -->
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>


    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../js/scripts.js"></script>
	<script src="../js/classie.js"></script>
	<script src="../js/validate.js"></script>
	<script src="../js/selectFx.js"></script>
	<script>
	  (function() {
	    [].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
	      new SelectFx(el);
	    } );
	  })();
	</script>
	<script>
	  (function() {
	    // trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
	    if (!String.prototype.trim) {
	      (function() {
	        // Make sure we trim BOM and NBSP
	        var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
	        String.prototype.trim = function() {
	          return this.replace(rtrim, '');
	        };
	      })();
	    }

	    [].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
	      // in case the input is already filled..
	      if( inputEl.value.trim() !== '' ) {
	        classie.add( inputEl.parentNode, 'input--filled' );
	      }

	      // events:
	      inputEl.addEventListener( 'focus', onInputFocus );
	      inputEl.addEventListener( 'blur', onInputBlur );
	    } );

	    function onInputFocus( ev ) {
	      classie.add( ev.target.parentNode, 'input--filled' );
	    }

	    function onInputBlur( ev ) {
	      if( ev.target.value.trim() === '' ) {
	        classie.remove( ev.target.parentNode, 'input--filled' );
	      }
	    }
	  })();
	</script>

</html>
