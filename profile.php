<?php
	require_once 'class.db.php';

	if(!($user->is_loggedin()))
	{
			$user->redirect('login.php');
	}
	if (isset($_POST["logout"])) {
		if($user->logout()){
			$user->redirect('login.php');
		}
	}
	if($user->is_in_cycle()){
		if (isset($_POST["cycle"])) {
			return false;
		}
	}
	else {
		if (isset($_POST["cycle"])) {
			$user->cycle();
		}
	}

	if ($user->is_in_ph() && $user->not_paired()) {
			$user->check();
	}

	if (isset($_POST["pop_button"])) {
		$imgName = $_FILES["pop"]["name"];
		$imgTmp = $_FILES["pop"]["tmp_name"];
		$imgSize = $_FILES["pop"]["size"];
		$user->upload_pop($imgName,$imgTmp,$imgSize);
	}
	if (isset($_POST["confirm"])) {
      $name = $_POST["confirm"];
		$user->confirm($name);
	}

 ?>


<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>OpenPay</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
		<script src="js/angular.min.js"></script>
		<style>
			.logbot{
				background: transparent;
				border: none;
				padding:0px;
			}
			.cycle button{
				border: none;
				background: purple;
				color: white;
				padding: 20px 50px;
				margin-top: 30vh;
				margin-left: 30vw;
				box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.75);
				letter-spacing: 2px;
				font-size: 20px;
			}
			.pop button{
				border: none;
				margin: 5px;
				padding: 5px 30px;
				background-color: rgb(152, 0, 152);
				color: white;
				box-shadow: 2px 3px 10px black;
			}
			.notification{
				text-align: center;
				margin: 30px;
				font-size: 17px;
			}
			i.pe-7s-refresh-2{
				font-size: 40px;
				position: relative;
				top: 10px;
				left: 10px;
			}
			.timer-content{
				text-align: center;
				font-size: 20px;
				padding: 30px;
			}
			.block-card{
				text-align: center;
				box-shadow: 3px 3px 5px grey;
				margin-top: 9%;
				letter-spacing: 2px;
			}
			.block-card .category{
				line-height: 30px;
			}
			.pop-image{
				padding: 10px;
				margin-top: 20px;
				background-color: rgb(239, 67, 92);
				color: white;
				cursor: pointer;
				width: 120px;
				text-align: center
			}

			/*Properties Modal Images*/
			#Fromcaptioon{
			  letter-spacing: 2px;
			}
			.myImg {
			    border-radius: 5px;
			    cursor: pointer;
			    transition: 0.3s;
			}

			.myImg:hover {opacity: 0.7;}

			/* The Modal (background) */
			.modal {
			    display: none; /* Hidden by default */
			    position: fixed; /* Stay in place */
			    z-index: 1; /* Sit on top */
			    padding-top: 100px; /* Location of the box */
			    left: 0;
			    top: 0;
			    width: 100%; /* Full width */
			    height: 100%; /* Full height */
			    overflow: auto; /* Enable scroll if needed */
			    background-color: rgb(0,0,0); /* Fallback color */
			    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
			}

			/* Modal Content (image) */
			.modal-content {
			    margin: auto;
			    display: block;
			    width: 80%;
			    max-width: 700px;
			    height: auto;
			}

			/* Caption of Modal Image */
			#caption {
			    margin: auto;
			    display: block;
			    width: 80%;
			    max-width: 700px;
			    text-align: center;
			    color: #ccc;
			    padding: 10px 0;
			}

			/* Add Animation */
			.modal-content, #caption {
			    -webkit-animation-name: zoom;
			    -webkit-animation-duration: 0.6s;
			    animation-name: zoom;
			    animation-duration: 0.6s;
			}

			@-webkit-keyframes zoom {
			    from {transform:scale(0)}
			    to {transform:scale(1)}
			}

			@keyframes zoom {
			    from {transform:scale(0)}
			    to {transform:scale(1)}
			}

			/* The Close Button */
			.close {
			    position: absolute;
			    top: 15px;
			    right: 35px;
			    color: white;
			    background-color: white;
			    font-size: 40px;
			    font-weight: bold;
			    transition: 0.3s;
			}
			.close:hover,
			.close:focus {
			    color: #bbb;
			    text-decoration: none;
			    cursor: pointer;
			}
			.properties .container{
			  margin-bottom: 50px;
			}
			/* 100% Image Width on Smaller Screens */
			@media only screen and (max-width: 700px){
			    .modal-content {
			        width: 100%;
			    }
			}
		</style>
</head>
<body>
<div class="wrapper">
	<?php if(!($user->is_blocked())){ ?>
    <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">

    <!--   you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple" -->
    	<div class="sidebar-wrapper">
            <div class="logo">
                <a class="simple-text">
                    OpenPay
                </a>
            </div>

            <ul class="nav">
								<li class="active">
										<a href="profile.php">
												<i class="pe-7s-note2"></i>
												<p>Cycle List</p>
										</a>
								</li>
                <li>
                    <a href="user.php">
                        <i class="pe-7s-user"></i>
                        <p>User Profile</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>
		<?php } ?>

    <div class="main-panel" style="width:<?php if($user->is_blocked()){echo "100%" ;} ?>">
		<nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
										<?php
										if(!($user->is_in_cycle() || $user->is_blocked())){
											?>
											<a class="navbar-brand">Welcome!, click on <strong>Recycle</strong> to begin</a>
											<?php
										}
										?>
										<?php
										if($user->is_blocked()){
											?>
											<a class="navbar-brand">Sorry, you have been <strong>blocked</strong></a>
											<?php
										}
										?>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                           <a href="">
                               <p>Community</p>
                            </a>
                        </li>
                        <li>
                            <a>
															<form action="profile.php" method="post">
																<input type="submit" name="logout" value="Log out" class="logbot">
															</form>
                            </a>
                        </li>
						<li class="separator hidden-lg hidden-md"></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content" ng-app="greatfunds" ng-controller="profilectrl">
            <div class="container-fluid">
                <div class="row">
									<?php if($user->not_paired() && ($user->is_in_ph())){ ?>
										<div class="notification" ng-hide="{{field}}" id="demo">
											Please Hold on, while our system is trying to pair you <i class="pe-7s-refresh-2"></i>
										</div>
										<?php } ?>
									<?php if(!($user->is_in_cycle() || $user->is_blocked())){ ?>
									<div class="cycle">
										<form class="" action="profile.php" method="post">
											<button type="submit" name="cycle">Recycle</button>
										</form>
									</div>
									<?php } ?>
								<?php if($user->is_in_ph()){ ?>
									<div class="timer-content" id="timer">
									</div>

                    <div class="col-md-12" id="ph-table">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Pay To {{paired_user}}</h4>
                                <p class="category"> have been paired with the folowing user, kindly pay to them and upload proof of payment to earn 100% profit.</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                      <th>Username</th>
																			<th>Phone number</th>
                                    	<th>Account Name</th>
                                    	<th>Bank</th>
																			<th>Account Number</th>
																			<th>Proof of payment</th>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="user in prohelp">
                                        	<td>{{user.name}} </td>
																					<td>{{user.phone_number}}</td>
																					<td>{{user.account_name}}</td>
																					<td>{{user.bank_name}}</td>
																					<td>{{user.number}}</td>
                                        	<td ng-show="{{field}}">
																						<form class="pop" action="profile.php" enctype="multipart/form-data" method="post" onsubmit=" return $scope.test();">
																						<input type="file" name="pop">
																						<button type="submit" name="pop_button">send</button>
                                        	</form>
																				</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

										<?php } ?>

										<?php if($user->is_in_gh()){ ?>
                    <div class="col-md-12" id="gh-table">
                        <div class="card card-plain">
                            <div class="header">
                                <h4 class="title">Payed By</h4>
                                <p class="category">You are going to be payed by the following users, kindly confirm payment before clicking on the <strong>" CONFIRM "</strong> button next to the users</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover">
                                    <thead>
																			<th>UserName</th>
																			<th>Phone number</th>
																			<th>Account Name</th>
																			<th>Bank</th>
                                    	<th>Account Number</th>
																			<th>confirmation</th>
                                    </thead>
                                    <tbody>
																			<tr ng-repeat="user in gethelp">
																				<td>{{user.name}} </td>
																				<td>{{user.phone_number}}</td>
																				<td>{{user.account_name}}</td>
																				<td>{{user.bank_name}}</td>
																				<td>{{user.number}}</td>
																				<td ng-show="{{field}}">
																					<form class="pop" action="profile.php" method="post">
																					<button type="submit" name="confirm" value="{{user.name}}">Confirm</button>
																				</form>
																				<div class="pop-image myImg" ng-show="{{user.pop}}" data-image="{{user.pop}}">
																					View P.O.P <i class="pe-7s-news-paper"></i>
																				</div>
																			</td>
																			</tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

										<!-- The Modal Image -->

										<div id="myModal" class="modal">
										 <span class="close"><span class="glyphicon glyphicon-remove"></span></span>
										 <img class="modal-content" id="img01">
										 <div id="caption"></div>
										</div>


										<?php } ?>
										<?php if ($user->is_blocked() && $user->is_in_blockedlist()) { ?>
										<div class="col-md-12">
												<div class="card block-card">
														<div class="header">
																<p class="category"> Dear <?php echo $_SESSION['user_session'];?>, you have been blocked for a minimum of 2weeks due to your inability to adhere to our policy and pay up whom you were paired to pay, at the given time of 24hours. Due to this block on your account, you will be unable to <strong>Recycle</strong> until the time duration is expired. If you have been blocked unjustly or have paid and was blocked, kindly write to our support team ,<strong>support@openpay.com</strong>. include your username when you are writing to us and we will get back to you within two days. <strong>Thanks #TeamOpenPay</strong>.</p>
														</div>
														<div class="content table-responsive table-full-width">

														</div>
												</div>
										</div>
										<?php } ?>

                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Company
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Portfolio
                            </a>
                        </li>
                        <li>
                            <a href="#">
                               Blog
                            </a>
                        </li>
                    </ul>
                </nav>
                <p class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="http://www.openpay.com">OpenPay</a>
                </p>
            </div>
        </footer>


    </div>
</div>


</body>
    <!--   Core JS Files   -->
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!-- <script src="js/myscript.js"></script> -->
	<script src="js/app.js"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js"></script>

</html>
