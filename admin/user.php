<?php
	require_once '../class.db.php';

	if(!($admin->is_loggedin()))
	{
			$user->redirect('login.php');
	}
	if (isset($_POST["logout"])) {
		if($admin->logout()){
			$admin->redirect('login.php');
		}
	}
 ?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>OpenPay Investments</title>

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


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
		<script src="../js/angular.min.js"></script>
		<style media="screen">
			.search-form{
				width: 100%;
				padding: 0px 10px 30px 10px;
				text-align: center;
			}
			.search-form .col-md-6{
				float: none;
				margin: auto;
			}
			.pop button{
				border: none;
				margin: 5px;
				padding: 5px 30px;
				background-color: rgb(152, 0, 152);
				color: white;
				box-shadow: 2px 3px 10px black;
			}
			#bank{
				height: 40px;
				border-radius: 0px;
				padding: 10px 50px;
				border: 1px solid grey;
				margin-bottom: 10px;
			}
			@media only screen and (max-width: 450px) {
			    #bank{
						width: 80%;
					}
			}
		.number_of_cycles{
			text-align: center;
			font-size: 20px;
			letter-spacing: 3px;
		}
		.pop-image{
			clear: both;
			position: relative;
			padding-top: 20%;
			width: 300px;
			height: 400px;
			background-color: black;
			margin:auto;
		}
		.pop-image img{
			position: absolute;
			width: 100%;
			height: 100%;
			top: 0;
			right: 0;
			left: 0;
			bottom: 0;
			object-fit: contain;
		}
		.blocked_user{
			padding: 10px;
			background-color: red;
			color: white;
			width: 110px;
			margin: auto;
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
                    <a class="navbar-brand" href="#">View Users</a>
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
                            <a>
															<form action="dashboard.php" method="post">
																<input type="submit" name="logout" value="Log out" class="logbot" >
															</form>
                            </a>
                        </li>
						<li class="separator hidden-lg hidden-md"></li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content" ng-app="openpay" ng-controller="Dashboardctrl">
					<?php if(isset($_GET['user']) && $_GET['user'] != null){
							$uname = $_GET['user'];
							$select = $database->db->prepare("SELECT * FROM users WHERE username=:uname");
							$select->execute(array(':uname'=>$uname));
							$userRow = $select->fetch(PDO::FETCH_ASSOC);
							$username = $userRow['username'];
							$phone_number = $userRow['phone_number'];
							$account_name = $userRow['account_name'];
							$account_number = $userRow['account_number'];
							$bank_name = $userRow['bank_name'];
							$email = $userRow['email'];
							$cycle = $userRow['number_of_cycles'];
						?>
						<div class="container-fluid">
								<div class="row">
										<div class="col-md-12" style="margin:auto">
												<div class="card">
														<div class="header">
															<?php if($user->ad_blockedlist($uname) || $user->ad_blocked($uname)){
																echo "<div class='blocked_user'>
																	Blocked User
																</div>";
															} ?>
																<h4 class="title"><?php echo $username; ?>'s Profile</h4>
														</div>
														<div class="content">
																<form action="user.php?user=<?php echo $username; ?>" method="get" >
																		<div class="row">
																				<div class="col-md-4">
																						<div class="form-group">
																								<label>Username</label>
																								<input type="text" name="username" id="username" class="form-control" placeholder="enter username" value="<?php echo $username; ?>" required disabled>
																						</div>
																				</div>
																				<div class="col-md-4">
																						<div class="form-group">
																								<label>Email</label>
																								<input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" value="<?php echo $email; ?>" required disabled>
																						</div>
																				</div>
																				<div class="col-md-4">
																						<div class="form-group">
																								<label for="exampleInputEmail1">Phone Number</label>
																								<input type="text" name="pnumber" id="pnumber" class="form-control" placeholder="Enter Number" value="<?php echo $phone_number; ?>" required disabled>
																						</div>
																				</div>
																		</div>

																		<div class="row">
																				<div class="col-md-4">
																						<div class="form-group">
																								<label>Account Number</label>
																								<input type="text" name="accnumber" id="accnumber" class="form-control" placeholder="Enter Account Number" value="<?php echo $account_number; ?>" required disabled>
																						</div>
																				</div>
																				<div class="col-md-4">
																						<div class="form-group">
																								<label>Account Name</label>
																								<input type="text" name="accname" id="accname" class="form-control" placeholder="Enter Account Name" value="<?php echo $account_name; ?>" required disabled>
																						</div>
																				</div>
																				<div class="col-md-4">
																					<div class="form-group">
																						<label>Bank Name</label>
																						<select name="bank" class="cs-select cs-skin-elastic col-md-12 col-sm-12" id="bank" disabled>
																							<option value="<?php echo $bank_name; ?>"selected><?php echo $bank_name; ?></option>
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

																				</div>
																		</div>
																		<?php
																			$select = $database->db->prepare("SELECT * FROM prohelp WHERE username=:uname");
																			$select->execute(array(':uname'=>$uname));
																			$userRow = $select->fetch(PDO::FETCH_ASSOC);
																			if($select->rowCount() > 0){
																				$time_start = date("Y-m-d H:i:s",strtotime($userRow["paired_time"]));
															          $end_time = date("Y-m-d H:i:s", strtotime("+ 8 hours", strtotime($time_start)));
																				$paired_time = $end_time;
														              ?>
																						<div class="row">
																								<div class="col-md-6">
																										<div class="form-group">
																												<label>Paired With</label>
																												<input type="text" class="form-control" value="<?php echo $userRow['paired_with']; ?>" disabled>
																										</div>
																								</div>
																								<div class="col-md-6">
																										<div class="form-group">
																													<label>Paired Time</label>
																												<input type="text" class="form-control"  value="<?php echo $paired_time; ?>" disabled>
																										</div>
																								</div>
																								<h3 style="font-family:futura;text-align:center;">Proof Of Payment</h3>
																								<div class="pop-image">
																									<img <?php if($userRow['pop'] != null){ echo 'src ="../uploads/'.$userRow['pop'].'"';} else{?> src ="../img/no_image.jpeg"<?php } ?>  alt="pop-image">
																								</div>
																						</div>
																					<?php
														          }
													            else{
																				$select = $database->db->prepare("SELECT * FROM gethelp WHERE username=:uname");
																				$select->execute(array(':uname'=>$uname));
																				$userRow = $select->fetch(PDO::FETCH_ASSOC);
													             if($select->rowCount() > 0){
																				  $time_start = date("Y-m-d H:i:s",strtotime($userRow["time"]));
	 															          $end_time = date("Y-m-d H:i:s", strtotime("+ 8 hours", strtotime($time_start)));
	 																				$time = $end_time;
																				 ?>
																				 <div class="col-md-3">
 																						<div class="form-group">
 																								<label>User ID</label>
 																								<input type="text" class="form-control" value="<?php echo $userRow['userid']; ?>" required disabled>
 																						</div>
 																				</div>
 																				<div class="col-md-3">
 																						<div class="form-group">
 																								<label>Number Of pair</label>
 																								<input type="text" class="form-control" value="<?php echo $userRow['num_of_pair']; ?>" required disabled>
 																						</div>
 																				</div>
																				<div class="col-md-3">
																					 <div class="form-group">
																							 <label>Is Confirmed</label>
																							 <input type="text" class="form-control" value="<?php echo $userRow['is_confirmed']; ?>" required disabled>
																					 </div>
																			 </div>
																			 <div class="col-md-3">
																					 <div class="form-group">
																							 <label>Time</label>
																							 <input type="text" class="form-control" value="<?php echo $time; ?>" required disabled>
																					 </div>
																			 </div>
																				 <?php
																			 }
													            }
																		 ?>
																		 <?php if($user->ad_blocked($username) || $user->ad_blockedlist($username)){ ?>
																			 <button type="submit" class="btn btn-info btn-fill pull-right" name="btn-unblock" value="<?php echo $username; ?>">Unblock User</button>
																			 <?php }
																			 else{ ?>
																				 <button type="submit" class="btn btn-danger btn-fill pull-right" name="btn-block" value="<?php echo $username; ?>">Block User</button>
																				 <?php } ?>
																		<div class="clearfix"></div>
																</form>

														</div>
												</div>
												<div class="number_of_cycles">
													<?php echo $cycle;  ?> Cycles.
												</div>
										</div>

								</div>
						</div>
					<?php }else{
						if(isset($_GET['btn-block'])){
							$uname = $_GET['btn-block'];
							if($user->ad_blockedlist($uname) || $user->ad_blocked($uname)){
								echo "$uname has already been blocked";
							}
							else{
									$user->ad_block_user($uname);
									echo "$uname has been blocked";
							}
						}
						if(isset($_GET['btn-unblock'])){
							$uname = $_GET['btn-unblock'];
							if($user->ad_blockedlist($uname) || $user->ad_blocked($uname)){
								$user->ad_unblock($uname);
								echo "$uname has been unblocked";
							}
						}
						?>
					<form class="search-form">
						<div class="col-md-6">
								<div class="form-group">
										<label>Search All users</label>
										<input type="text" class="form-control"  placeholder="Search users" ng-model="search.name">
								</div>
						</div>
						<div style="clear:both"></div>
					</form>
            <div class="container-fluid">
                <div class="row">
									<div class="col-md-12" id="user-table">
											<div class="card card-plain">
													<div class="content table-responsive table-full-width">
															<table class="table table-hover">
																	<thead>
																		<th>UserName</th>
																		<th>Phone number</th>
																		<th>Email</th>
																		<th>Registered</th>
																		<th>Number Of Cycles</th>
																		<th>View</th>
																	</thead>
																	<tbody>
																		<tr ng-repeat="user in utable|filter:search|limitTo : 10">
																			<td>{{user.name}} </td>
																			<td>{{user.phone_number}}</td>
																			<td>{{user.email}}</td>
																			<td>{{user.registered}}</td>
																			<td>{{user.cycles}}</td>
																			<td>
																				<form class="pop" action="user.php" method="get">
																				<button type="submit" name="user" value="{{user.name}}" >View User Profile</button>
																			</form>
																		</td>
																		</tr>
																	</tbody>
															</table>

													</div>
											</div>
									</div>

                </div>
            </div>
						<?php } ?>
        </div>


        <?php include 'include/footer.php'; ?>

    </div>
</div>


</body>

    <!--   Core JS Files   -->
	<script src="../js/app.js"></script>
  <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>

</html>
