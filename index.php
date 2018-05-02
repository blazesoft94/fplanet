<?php
session_start();
// include_once "includes/connect_db.php";
if(isset($_SESSION["login"])){
	if($_SESSION["login"]){
		header("Location: timeline.php");
	}
	
}
include_once "includes/connect_db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<title>FPlanet</title>

	<!-- Required meta tags always come first -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">

	<!-- Main Font -->
	<script src="js/webfontloader.min.js"></script>

	<script>
		WebFont.load({
			google: {
				families: ['Roboto:300,400,500,700:latin']
			}
		});
	</script>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" type="text/css" href="Bootstrap/dist/css/bootstrap-reboot.css">
	<link rel="stylesheet" type="text/css" href="Bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="Bootstrap/dist/css/bootstrap-grid.css">

	<!-- Theme Styles CSS -->
	<link rel="stylesheet" type="text/css" href="css/theme-styles.css">
	<link rel="stylesheet" type="text/css" href="css/blocks.css">
	<link rel="stylesheet" type="text/css" href="css/fonts.css">

	<!-- Styles for plugins -->
	<link rel="stylesheet" type="text/css" href="css/jquery.mCustomScrollbar.min.css">
	<link rel="stylesheet" type="text/css" href="css/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-select.css">


</head>
<!-- rgba(27, 27, 135, 0.8); -->
<body style="background-color: #4589BA ">

<div class="content-bg-wrap">
	<div class="content-bg"></div>
</div>


<!-- Landing Header -->

<div class="container">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div id="site-header-landing" class="header-landing">
				<div style="color:white!important; display:inline-block!important; margin: 0 auto!important;">
				<a href="02w-ProfilePage.html" class="logo-2" >
					<img src="img/logo.png" alt="Olympus">
					<h5 style="color:white!important;font-size:50px!important;" class="logo-title-2">FPlanet</h5>
				</a>
				</div>
				<div style="float:right;">	
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#signupModal">
						SignUp
					</button>
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#signinModal">
						SignIn
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- ... end Landing Header -->

<!-- Login-Registration Form  -->

<div class="container">
	<div class="row display-flex">
		<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12" >
			<img src="img/IMG-2427.JPG" width="450" height="450" alt="">
		</div>

		<div class="col-xl-5 col-lg-6 col-md-12 col-sm-12 col-xs-12">
			
			<!-- <div class="registration-login-form">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#home" role="tab">
								<div class="text"> <span>Sign up</span></div>
		
							
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#profile" role="tab">
								<div class="text"> <span>Login</span></div>								
						</a>
					</li>
				</ul>

				<div class="tab-content">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
										Launch demo modal
										</button>

					
				</div>
			</div>
		</div> -->
	</div>
</div>
<!-- Modal Signup -->
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
	<div class="modal-header">
	  <h5 class="modal-title" id="exampleModalLabel">Signup</h5>
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	  </button>
	</div>
	<div class="modal-body">
		<div class="tab-pane active" id="home" role="tabpanel" data-mh="log-tab">
			<div class="title h6">Register to FPlanet</div>
			<form class="signup-form" class="content" method="post" action="signup.php" >
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="form-group label-floating is-empty">
							<label class="control-label">First Name</label>
							<input name="firstname" class="form-control" placeholder="" type="text">
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="form-group label-floating is-empty">
							<label class="control-label">Last Name</label>
							<input name="lastname" class="form-control" placeholder="" type="text">
						</div>
					</div>
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="form-group label-floating is-empty">
							<label class="control-label"> Your FCC Email</label>
							<input id="email" class="form-control" placeholder="" type="email" name="email">
						</div>
						<div class="form-group label-floating is-empty">
							<label class="control-label">Your Password</label>
							<input id="pass" class="form-control" placeholder="" type="password" name="pass">
						</div>

						<div class="form-group label-floating is-select">
							<label class="control-label">Your Major</label>
							<select name="major" class="selectpicker form-control" size="auto">
								<?php
									$sql = "select * from groups where group_type = 'Major'";
									$result = $con->query($sql);
									if($result->num_rows>0){
										while($row=$result->fetch_assoc()){
									
								?>
									<option value="<?php echo $row["group_id"] ?>"><?php echo $row["group_name"] ?></option>
										<?php }}?>
							</select>
						</div>

						<div class="form-group label-floating is-select">
							<label class="control-label">Societies (Up-to 2)</label>
							<select name="societies[]" id="society" class="selectpicker form-control" size="auto" multiple>
								<?php
									$sql = "select * from groups where group_type = 'Society'";
									$result = $con->query($sql);
									if($result->num_rows>0){
										while($row=$result->fetch_assoc()){
									
								?>
									<option value="<?php echo $row["group_id"] ?>"><?php echo $row["group_name"] ?></option>
										<?php }}?>
							</select>
							</select>
						</div>

						<div class="remember">
							<div class="checkbox">
								<label>
									<input name="optionsCheckboxes" type="checkbox">
									I accept the <a href="#">Terms and Conditions</a>
								</label>
							</div>
						</div>
						
						<a id="signup-button" href="#" class="btn btn-purple btn-lg full-width">Complete Registration!</a>
					</div>
				</div>
			</form>
		</div>
	</div>
  </div>
</div>
</div>


<!-- Modal Signin -->
<div class="modal fade" id="signinModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
	<div class="modal-header">
	  <h5 class="modal-title" id="exampleModalLabel">SignIn</h5>
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	  </button>
	</div>
	<div class="modal-body">
						<div class="title h6">Login to your Account</div>
						<form class="content">
							<div class="row">
								<div class="col-xl-12 col-lg-12 col-md-12">
									<p><span id="incorrect-warning" class="text-warning" style="color:red!important;"></span></p>
									<div class="form-group label-floating is-empty">
										<label class="control-label">Your FCC ID</label>
										<input id="user_id" name="id" class="form-control" placeholder="" type="email">
									</div>
									<div class="form-group label-floating is-empty">
										<label class="control-label">Your Password</label>
										<input id="user_password" name="password" class="form-control" placeholder="" type="password">
									</div>

									<div class="remember">

										<div class="checkbox">
											<label>
												<input name="optionsCheckboxes" type="checkbox">
												Remember Me
											</label>
										</div>
										<a href="#" class="forgot">Forgot my Password</a>
									</div>

									<a id="login-button" href="#" class="btn btn-lg btn-primary full-width">Login</a>

									
									<p>Don’t you have an account? <a href="#">Register Now!</a> it’s really simple and you can start enjoing all the benefits!</p>
								</div>
							</div>
						</form>
	</div>
	<!-- <div class="modal-footer">
	  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	</div> -->
  </div>
</div>
</div>


<!-- ... end Login-Registration Form  -->





<!-- jQuery first, then Other JS. -->
<script src="js/jquery-3.2.0.min.js"></script>
<!-- Js effects for material design. + Tooltips -->
<script src="js/material.min.js"></script>
<!-- Helper scripts (Tabs, Equal height, Scrollbar, etc) -->
<script src="js/theme-plugins.js"></script>
<!-- Init functions -->
<script src="js/main.js"></script>

<!-- Select / Sorting script -->
<script src="js/selectize.min.js"></script>

<!-- Swiper / Sliders -->
<script src="js/swiper.jquery.min.js"></script>

<!-- Datepicker input field script-->
<script src="js/moment.min.js"></script>
<script src="js/daterangepicker.min.js"></script>

<script src="js/mediaelement-and-player.min.js"></script>
<script src="js/mediaelement-playlist-plugin.min.js"></script>

<script>
		// console.log($("ul.dropdown-menu.inner li")[0]);
		var selectedArray = [];
		setTimeout(function(){
			console.log("ready");
			$("ul.dropdown-menu.inner li").click(function(){
				clickedElem = this;
				myc = 0;
				sameClicked = false;
				for(var myc=0; myc<selectedArray.length; myc++){
					if(selectedArray[myc]==clickedElem){
						console.log("same clicked");
						selectedArray.splice(myc,1);
						sameClicked=true;
						break;
					}
				}
				if(!sameClicked){
					if(selectedArray.length>=2){
						$(selectedArray[0]).addClass("selected");
						$(selectedArray[0]).removeClass("selected");
						selectedIndex = $(selectedArray[0]).attr("data-original-index");
						$($("#society option")[selectedIndex]).prop("selected",false);
						selectedArray.splice(0,1);
						
					}
					console.log("adding to selected array");
					selectedArray.push(this);
					
				}
				
				
				console.log(selectedArray);
			});
			
		
		},3000);
		$("#signup-button").click(function () {
			$(".signup-form").submit();
		});

		$("#login-button").click(function(){
			var userID = $("#user_id").val(); 
			var userPass = $("#user_password").val(); 
			$.ajax({
				url : "ajax/login.php?id="+userID+"&pass="+userPass,
				method: "post",
				success: function(data){
					var obj = JSON.parse(data);
					console.log(obj.login);
					if(obj.login=="true"){
						location.reload();
					}
					if(obj.login == "false"){
						console.log("its false");
						document.getElementById("incorrect-warning").innerHTML =  "*Incorrect id or password";
						// $("#incorrect-warning").innerHTML = "*Incorrect id or password";
					}
				}
			})
		});
</script>


</body>
</html>