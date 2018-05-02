<?php
session_start();
// use Profanity\LeoProfanity as LeoProfanity;
if(isset($_SESSION["login"])){
	if($_SESSION["login"]){
        $id = $_SESSION["id"];
	}
	else{
		header("Location: index.php");
	}
}
else{
	header("Location: index.php");
}
include_once "includes/connect_db.php";


// $sql = "Select * from friends where friend_first_id = '$id'";
// $result = $con->query($sql);
// if($result->num_rows>0){
//     $row = $result->fetch_assoc();
?>


<?php 
	// $id = 1810847; //after login id will be set to user id
	$roll_no = substr_replace($id,"-",2,0);
	$user_name = "";
	$user_image = "";

	// $course = "cscs213";
	// $course_id = ;
	// $course_name = $row["group_name"];
	$course_instrutor = "";


	$sql = "select * from users where user_id = '$id'";
	$result = $con->query($sql);
	if($result->num_rows>0){
		$row = $result->fetch_assoc();
        $user_name = $row["user_name"];
		$user_image = $row["user_image"];
	
	// $sql = "SELECT course_name, user_name from courses,users WHERE course_code = '$course' and course_teacher_id = user_id ";
	// $result = $con->query($sql);
	// if($result->num_rows>0){
	// 	while($row = $result->fetch_assoc()){
	// 		$course_name = $row["course_name"];
	// 		$course_instrutor = $row["user_name"];
	// 	}
	// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "includes/head.php" ?>
	<title>Friends</title>
</head>
<body>

<!-- Fixed Sidebar Left -->
<?php include "includes/left_sidebar.php" ?>
<!-- ... end Fixed Sidebar Left -->


<!-- Fixed Sidebar Right -->
<?php// include "includes/right_sidebar.php" ?>
<!-- ... end Fixed Sidebar Right -->


<!-- Header -->

<header class="header" id="site-header">

	<div class="page-title">
		<h6>Friends</h6>
	</div>
	<?php include "includes/header.php" ?>
</header>
<?php include "includes/header_responsive.php" ?>

<!-- ... end Header -->



<!-- Top Header -->

<div class="container">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
			<div class="ui-block">
				<div class="top-header">
					<!-- <div class="top-header-thumb">
						<img src="img/top-header1.jpg" alt="nature">
					</div> -->
					<div class="profile-section">
						<div class="row">
							<div class="col-lg-5 col-md-5 ">
								<ul class="profile-menu">
									<li>
										<a href="timeline.php" class="active">Timeline</a>
									</li>
									 <li>
										<a href="friends.php">Friends</a>
									</li>
									<!--<li>
										<a href="06-ProfilePage.html">Friends</a>
									</li> -->
								</ul>
							</div>
							
						</div>

					</div>
					<div class="top-header-author">
						<!-- <a href="02-ProfilePage.html" class="author-thumb">
							<img src="img/author-main1.jpg" alt="author">
						</a> -->
						<div class="author-content">
							<a href="#" class="h4 author-name"><?php echo $user_name ?></a>
							<!-- <div class="country">by <?php //echo $course_instrutor ?></div> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- ... end Top Header -->



<div class="container">
<div class="row">
    <?php
        $sql = "SELECT * from friends,users where friend_first_id = '$id' and friend_second_id = user_id";
        $result = $con->query($sql);
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){

    ?>
		<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<div class="ui-block">
				<div class="friend-item">
					<div style="width:318px; height:122px; background-color:#272829" class="friend-header-thumb">
						<!-- <img src="img/friend1.jpg" alt="friend"> -->
					</div>

					<div class="friend-item-content">

						<div class="more">
							<svg class="olymp-three-dots-icon"><use xlink:href="icons/icons.svg#olymp-three-dots-icon"></use></svg>
							<ul class="more-dropdown">
								<li>
									<a href="#">Report Profile</a>
								</li>
								<li>
									<a href="#">Block Profile</a>
								</li>
								<li>
									<a href="#">Turn Off Notifications</a>
								</li>
							</ul>
						</div>
						<div class="friend-avatar">
							<div class="author-thumb">
								<img width="92" height="92" src="img/<?php echo $row["user_image"]?>-sm.jpg" alt="author">
							</div>
							<div class="author-content">
								<a href="#" class="h5 author-name"><?php echo $row["user_name"] ?></a>
								<div class="country"><?php echo substr_replace($row["user_id"],"-",2,0)?></div>
							</div>
						</div>

						<div class="swiper-container" data-slide="fade">
							<div class="swiper-wrapper">
								<div class="swiper-slide">
									<div class="friend-count" data-swiper-parallax="-500">
										<a href="#" class="friend-count-item">
											<div class="h6"><?php 
												$sql2 ="select * from friends where friend_first_id ='". $row['user_id']."'";
												$result2=$con->query($sql);
												echo $result2->num_rows;
											?></div>
											<div class="title">Friends</div>
										</a>
										<a href="#" class="friend-count-item">
											<div class="h6"><?php 
												$sql2 ="select * from posts where post_user_id ='". $row['user_id']."'";
												$result2=$con->query($sql);
												echo $result2->num_rows;
											?></div>
											<div class="title">Posts</div>
										</a>
										<a href="#" class="friend-count-item">
											<div class="h6">16</div>
											<div class="title">Videos</div>
										</a>
									</div>
									<div class="control-block-button" data-swiper-parallax="-100">
										<a href="#" class="btn btn-control bg-blue">
											<svg class="olymp-happy-face-icon"><use xlink:href="icons/icons.svg#olymp-happy-face-icon"></use></svg>
										</a>

										<a href="#" class="btn btn-control bg-purple">
											<svg class="olymp-chat---messages-icon"><use xlink:href="icons/icons.svg#olymp-chat---messages-icon"></use></svg>
										</a>

									</div>
								</div>

							</div>

							<!-- If we need pagination -->
							<div class="swiper-pagination"></div>
						</div>
					</div>
				</div>
			</div>
        </div>
            <?php }} ?>
	</div>
</div>

<!-- Window-popup Update Header Photo -->

<div class="modal fade" id="update-header-photo">
	<div class="modal-dialog ui-block window-popup update-header-photo">
		<a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
			<svg class="olymp-close-icon"><use xlink:href="icons/icons.svg#olymp-close-icon"></use></svg>
		</a>

		<div class="ui-block-title">
			<h6 class="title">Add a Photo</h6>
		</div>

		<a href="#" class="upload-photo-item">
			<svg class="olymp-computer-icon"><use xlink:href="icons/icons.svg#olymp-computer-icon"></use></svg>

			<input type="file"><h6>Upload Photo</h6></input>
			<span>Browse your computer.</span>
		</a>

		<a href="#" class="upload-photo-item" data-toggle="modal" data-target="#choose-from-my-photo">

			<svg class="olymp-photos-icon"><use xlink:href="icons/icons.svg#olymp-photos-icon"></use></svg>

			<h6>Choose from My Photos</h6>
			<span>Choose from your uploaded photos</span>
		</a>
	</div>
</div>



<!-- Window-popup Choose from my Photo -->
<div class="modal fade" id="choose-from-my-photo">
	<div class="modal-dialog ui-block window-popup choose-from-my-photo">
		<a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
			<svg class="olymp-close-icon"><use xlink:href="icons/icons.svg#olymp-close-icon"></use></svg>
		</a>

	<div class="ui-block-title">
		<h6 class="title">Choose from My Photos</h6>

		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-expanded="true">
					<svg class="olymp-photos-icon"><use xlink:href="icons/icons.svg#olymp-photos-icon"></use></svg>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-expanded="false">
					<svg class="olymp-albums-icon"><use xlink:href="icons/icons.svg#olymp-albums-icon"></use></svg>
				</a>
			</li>
		</ul>
	</div>


	<div class="ui-block-content">
		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane active" id="home" role="tabpanel" aria-expanded="true">

				<div class="choose-photo-item" data-mh="choose-item">
					<div class="radio">
						<label class="custom-radio">
							<img src="img/choose-photo1.jpg" alt="photo">
							<input type="radio" name="optionsRadios">
						</label>
					</div>
				</div>
				<div class="choose-photo-item" data-mh="choose-item">
					<div class="radio">
						<label class="custom-radio">
							<img src="img/choose-photo2.jpg" alt="photo">
							<input type="radio" name="optionsRadios">
						</label>
					</div>
				</div>
				<div class="choose-photo-item" data-mh="choose-item">
					<div class="radio">
						<label class="custom-radio">
							<img src="img/choose-photo3.jpg" alt="photo">
							<input type="radio" name="optionsRadios">
						</label>
					</div>
				</div>

				<div class="choose-photo-item" data-mh="choose-item">
					<div class="radio">
						<label class="custom-radio">
							<img src="img/choose-photo4.jpg" alt="photo">
							<input type="radio" name="optionsRadios">
						</label>
					</div>
				</div>
				<div class="choose-photo-item" data-mh="choose-item">
					<div class="radio">
						<label class="custom-radio">
							<img src="img/choose-photo5.jpg" alt="photo">
							<input type="radio" name="optionsRadios">
						</label>
					</div>
				</div>
				<div class="choose-photo-item" data-mh="choose-item">
					<div class="radio">
						<label class="custom-radio">
							<img src="img/choose-photo6.jpg" alt="photo">
							<input type="radio" name="optionsRadios">
						</label>
					</div>
				</div>

				<div class="choose-photo-item" data-mh="choose-item">
					<div class="radio">
						<label class="custom-radio">
							<img src="img/choose-photo7.jpg" alt="photo">
							<input type="radio" name="optionsRadios">
						</label>
					</div>
				</div>
				<div class="choose-photo-item" data-mh="choose-item">
					<div class="radio">
						<label class="custom-radio">
							<img src="img/choose-photo8.jpg" alt="photo">
							<input type="radio" name="optionsRadios">
						</label>
					</div>
				</div>
				<div class="choose-photo-item" data-mh="choose-item">
					<div class="radio">
						<label class="custom-radio">
							<img src="img/choose-photo9.jpg" alt="photo">
							<input type="radio" name="optionsRadios">
						</label>
					</div>
				</div>


				<a href="#" class="btn btn-secondary btn-lg btn--half-width">Cancel</a>
				<a href="#" class="btn btn-primary btn-lg btn--half-width">Confirm Photo</a>

			</div>
			<div class="tab-pane" id="profile" role="tabpanel" aria-expanded="false">

				<div class="choose-photo-item" data-mh="choose-item">
					<figure>
						<img src="img/choose-photo10.jpg" alt="photo">
						<figcaption>
							<a href="#">South America Vacations</a>
							<span>Last Added: 2 hours ago</span>
						</figcaption>
					</figure>
				</div>
				<div class="choose-photo-item" data-mh="choose-item">
					<figure>
						<img src="img/choose-photo11.jpg" alt="photo">
						<figcaption>
							<a href="#">Photoshoot Summer 2016</a>
							<span>Last Added: 5 weeks ago</span>
						</figcaption>
					</figure>
				</div>
				<div class="choose-photo-item" data-mh="choose-item">
					<figure>
						<img src="img/choose-photo12.jpg" alt="photo">
						<figcaption>
							<a href="#">Amazing Street Food</a>
							<span>Last Added: 6 mins ago</span>
						</figcaption>
					</figure>
				</div>

				<div class="choose-photo-item" data-mh="choose-item">
					<figure>
						<img src="img/choose-photo13.jpg" alt="photo">
						<figcaption>
							<a href="#">Graffity & Street Art</a>
							<span>Last Added: 16 hours ago</span>
						</figcaption>
					</figure>
				</div>
				<div class="choose-photo-item" data-mh="choose-item">
					<figure>
						<img src="img/choose-photo14.jpg" alt="photo">
						<figcaption>
							<a href="#">Amazing Landscapes</a>
							<span>Last Added: 13 mins ago</span>
						</figcaption>
					</figure>
				</div>
				<div class="choose-photo-item" data-mh="choose-item">
					<figure>
						<img src="img/choose-photo15.jpg" alt="photo">
						<figcaption>
							<a href="#">The Majestic Canyon</a>
							<span>Last Added: 57 mins ago</span>
						</figcaption>
					</figure>
				</div>


				<a href="#" class="btn btn-secondary btn-lg btn--half-width">Cancel</a>
				<a href="#" class="btn btn-primary btn-lg disabled btn--half-width">Confirm Photo</a>
			</div>
		</div>
	</div>

</div>
</div>

<!-- ... end Window-popup Choose from my Photo -->


<?php include "includes/chat-popup.php" ?>


<!-- jQuery first, then Other JS. -->
<script src="js/jquery-3.2.0.min.js"></script>
<script>
          // Your event
        $('.msg-head').click(function(){
				$("#msgs-list").html("");
               // Get the ID for the element that was clicked
			   var friendId = $(this).attr('id');
			   var userId = $(".header-content-wrapper").attr("id");
			//    alert("popup_chat_ajax.php?user_id="+userId+"&friend_id="+friendId);
			   $.ajax(
					{
						url: "popup_chat_ajax.php?user_id="+userId+"&friend_id="+friendId,
						success: function(data){
							$("#msgs-list").append(data);
							console.log("done");
						}
					}
				)
			   
		});
		$(".send-message").on({
			  "click":function(){
			  	sendMessage();
			  }
		});
		$("#message-textbox").keypress(function(e){
			if(e.which==13){
				sendMessage();
				// document.getElementById("message-textbox").textContent = "";
		}});

		function sendMessage(){
			var data = $(document.getElementById("message-textbox")).val();
			var user_id = $(".header-content-wrapper").attr("id");
			var friend_id = $(document.getElementById("friend-id-input")).val();

			var msgValues = {
				data,
				user_id,
				friend_id
			}
			$.ajax({
				url: "send_message_ajax.php",
				data: msgValues,
				type: "post",
				success: function(data){
					if(data=="-1"){
						alert("Some error");
					}
					else{
						$("#message-textbox").val("");
						
						if($("#last-message").val()=="0"){
							$("#msgs-list li:last-of-type span:last").before("<span class='chat-message-item'> "+msgValues.data+"</span>");
						}
						else{
							$("#msgs-list").append('<li><div class="author-thumb"><img src="img/'+$("#user-image").val()+'-sm.jpg" alt="author" class="mCS_img_loaded"></div><div class="notification-event"><span class="chat-message-item">'+msgValues.data+'</span><span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">Today at 8:29pm</time></span></div></li>');
						}
					}
				},
				error: function(d){
					alert("some error");
				}
			})
		}

	// $(".abcd").click(function(e){
	// 	var id = $(this).attr("id");
	// 	var id2 = e.target.id;
	// 	alert("user id: ",id,id2);
	// });
	

</script>
<!-- Js effects for material design. + Tooltips -->
<script src="js/material.min.js"></script>
<!-- Helper scripts (Tabs, Equal height, Scrollbar, etc) -->
<script src="js/theme-plugins.js"></script>
<!-- Init functions -->
<script src="js/main.js"></script>

<!-- Load more news AJAX script -->
<script src="js/ajax-pagination.js"></script>

<!-- Select / Sorting script -->
<script src="js/selectize.min.js"></script>

<!-- Lightbox popup script-->
<script src="js/jquery.magnific-popup.min.js"></script>

<script src="js/mediaelement-and-player.min.js"></script>
<script src="js/mediaelement-playlist-plugin.min.js"></script>
<script>
    // $("#post-button").click(function(e){
	// 	e.preventDefault();
	// 	if($("#post-text").val()==""){
	// 		alert("Your post text is empty");
	// 	}
	// 	else{

	// 	}
    // });
</script>
</body>
</html>
<?php 
    }
else{
		header("Location: index.php");        
}
?>