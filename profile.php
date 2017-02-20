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
	if(!($user->is_in_cycle())){
		if (isset($_POST["cycle"])) {
			$user->cycle();
		}
	}
	if ($user->is_in_ph() && $user->not_paired()) {
			$user->check();
	}

 ?>


<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Great Funds</title>

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
		</style>
</head>
<body>
<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">

    <!--   you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple" -->


    	<div class="sidebar-wrapper">
            <div class="logo">
                <a class="simple-text">
                    Great Funds
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
										<?php
										if(!($user->is_in_cycle())){
											?>
											<a class="navbar-brand">Welcome!, click on <strong>Recycle</strong> to begin</a>
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
									<?php if(!($user->is_in_cycle())){ ?>
									<div class="cycle">
										<form class="" action="profile.php" method="post">
											<button type="submit" name="cycle">Recycle</button>
										</form>
									</div>
									<?php } ?>
								<?php if($user->is_in_ph()){ ?>
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
																						<form class="pop" action="profile.php" method="post" onsubmit=" return $scope.test();">
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
                    <div class="col-md-12">
                        <div class="card card-plain">
                            <div class="header">
                                <h4 class="title">Payed By</h4>
                                <p class="category">You are going to be payed by the following users, kindly confirm payment before clicking on the <strong>" CONFIRM "</strong> button next to the users</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover">
                                    <thead>
																			<th>UserName</th>
                                    	<th>Account Number</th>
                                    	<th>Account Name</th>
                                    	<th>Bank</th>
                                    	<th>Phone number</th>
																			<th>confirmation</th>
                                    </thead>
                                    <tbody>
																			<tr ng-repeat="user in prohelp">
																				<td>{{user.name}} </td>
																				<td>{{user.phone_number}}</td>
																				<td>{{user.account_name}}</td>
																				<td>{{user.bank_name}}</td>
																				<td>{{user.number}}</td>
																				<td ng-show="{{field}}">
																					<form class="pop" action="profile.php" method="post" onsubmit=" return $scope.test();">
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
                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="http://www.greatfunds.com">Greatfunds</a>
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


</html>
