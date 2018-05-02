<?php
header("Location: index.php");
session_start();
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
?>
<?php include_once "includes/connect_db.php" ?>


<?php 
	// $id = 1810847; //after login id will be set to user id
	$roll_no = substr_replace($id,"-",2,0);
	$user_name = "";
	$user_image = "";

	$course = "cscs213";
	$course_id = "2";
	$course_name = "";
	$course_instrutor = "";


	$sql = "select * from users where user_id = '$id'";
	$result = $con->query($sql);
	if($result->num_rows>0){
		while($row = $result->fetch_assoc()){
			$user_name = $row["user_name"];
			$user_image = $row["user_image"];
		}
	}
	$sql = "SELECT course_name, user_name from courses,users WHERE course_code = '$course' and course_teacher_id = user_id ";
	$result = $con->query($sql);
	if($result->num_rows>0){
		while($row = $result->fetch_assoc()){
			$course_name = $row["course_name"];
			$course_instrutor = $row["user_name"];
		}
	}


	class Post {
        public $user_name;
        public $user_image;
		public $text;
		public $no_of_likes;
		public $image;
		public $comments;
		public $liked_by_author;

        public function __construct($user_name, $user_image, $text, $image, $date,$time, $likes,$no_of_comments, $comments, $liked_by_author){
            $this->user_name = $user_name;
            $this->sender_name = $user_name;
            $this->user_image = $user_image;
            $this->date = $date;
            $this->time = $time;
			$this->text = $text;
			$this->image = $image;
			$this->no_of_likes = $likes;
			$this->comments = $comments;
			$this->no_of_comments = $no_of_comments;
			$this->liked_by_author = $liked_by_author;

        }
	}

	class Comment {
		public $user_name;
		public $user_image;
		public $text;
		public $date;
		public $time;
		public $no_of_likes;
		public $liked_by_author;

		public function __construct($user_name, $user_image, $text,$likes, $date, $time,$liked_by_author){
			$this->user_name = $user_name;
			$this->user_image = $user_image;
			$this->text = $text;
			$this->date = $date;
			$this->time = $time;
			$this->no_of_likes = $likes;
			$this->liked_by_author = $liked_by_author;
		}
	}

    // $msg = new Message();
//	m.message_id, m.message_sender_id, u.user_name, m.message_time, m.message_date, u.user_image, m.message_content, u.user_image, m.message_status
	
    $posts = [];
	$sql = "SELECT *
    FROM posts p, users u
    WHERE p.post_user_id = u.user_id ";
    $result = $con->query($sql);
    $c = 0;
	if($result->num_rows>0){
		while($row = $result->fetch_assoc()){
			$post_id = $row["post_id"];
			$comments = [];
			$total_likes = 0;
			$liked_by_author = false;
			// echo $post_id;
			$sql2 = "SELECT count(*) as total from post_likes where like_post_id = '$post_id'";
			$result2 = $con->query($sql2);
			if($result2->num_rows>0){
				while($row2 = $result2->fetch_assoc()){
					$total_likes = $row2["total"];
				}
			}

			$sql2 = "SELECT * from post_likes where like_post_id = '$post_id' and like_user_id = '$id'";
			$result2 = $con->query($sql2);
			if($result2->num_rows>0){
				$liked_by_author = true;
			}

			$sql2 = "SELECT * from post_comments, users where comment_user_id = user_id AND comment_post_id = '$post_id' ";
			$result2 = $con->query($sql2);
			$comment_count=0;
			if($result2->num_rows>0){
				while($row2 = $result2->fetch_assoc()){
					$comment_id = $row2["comment_id"];
					$comment_likes = 0;
					$comment_liked_by_author = false;
					$sql3 = "SELECT * from comment_likes where comment_id = '$comment_id' and comment_like_user_id = '$id'";
					$result3 = $con->query($sql3);
					if($result3->num_rows>0){
						$comment_liked_by_author = true;
					}


					$sql3 = "SELECT count(*) as total from comment_likes where comment_id = '$comment_id'";
					$result3 = $con->query($sql3);
					if($result3->num_rows>0){
						while($row3 = $result3->fetch_assoc()){
							$comment_likes = $row3["total"];
						}
					}
					$com = new Comment($row2["user_name"],$row2["user_image"],$row2["comment_text"],$comment_likes,$row2["comment_date"],$row2["comment_time"], $comment_liked_by_author);
					array_push($comments, $com);
					$comment_count++;
				}
			}
			$post = new POST($row["user_name"],$row["user_image"],$row["post_text"],$row["post_image"],$row["post_date"],$row["post_time"],$total_likes,$comment_count,$comments,$liked_by_author);
			array_push($posts, $post);
                // $msg = new Message($row["message_sender_id"],$row["user_name"],$row["user_image"], $row["message_content"], $row["message_date"], $row["message_time"],$row["message_status"]);
                // $messages[$c]= $msg;
                // $c+=1;
            
            // if($row["message_status"]=="unread")
			// $new_messages +=1;
		}
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "includes/head.php" ?>
	<title>Group Page</title>
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
		<h6>Group Page</h6>
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
										<a href="02-Profile.php" class="active">Timeline</a>
									</li>
									<!-- <li>
										<a href="05-ProfilePage-About.html">About</a>
									</li>
									<li>
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
							<a href="02-ProfilePage.html" class="h4 author-name"><?php echo $course_name ?></a>
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

		<!-- Main Content -->

		<div class="col-xl-6 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-xs-12">
			<input id="user-image" value="<?php echo $user_image ?>" style="display:none;" >
			<div id="newsfeed-items-grid">
				<div class="ui-block">
					<article class="hentry">
							<div class="news-feed-form">
									<!-- Nav tabs -->
									<ul class="nav nav-tabs" role="tablist">
										<li class="nav-item">
											<a class="nav-link inline-items active show" data-toggle="tab" href="#home-1" role="tab" aria-expanded="true" aria-selected="true">
								
												<svg class="olymp-status-icon">
														<svg id="olymp-status-icon" viewBox="0 0 36 32">
																<title>status-icon</title>
																<path d="M32-0.002h-28.444c-1.963 0-3.556 1.593-3.556 3.557v21.332h3.554v0.004h28.444v-3.557h-28.443v-17.778h28.444v24.889h-24.889v3.556h24.889c1.963 0 3.556-1.593 3.556-3.556v-24.889c0-1.964-1.593-3.557-3.556-3.557zM0 32h3.556v-3.556h-3.556v3.556zM7.109 7.111v3.557h10.667v-3.557h-10.667zM7.109 17.778h21.333v-3.556h-21.333v3.556z"></path>
														</svg>
												</svg>
								
												<span>Status</span>
											<div class="ripple-container"></div></a>
										</li>
										
									</ul>
								
									<!-- Tab panes -->
									<div class="tab-content">
										<div class="tab-pane active show" id="home-1" role="tabpanel" aria-expanded="true">
											<form>
												<div class="author-thumb">
													<img src="img/<?php echo $user_image?>-sm.jpg" alt="author">
												</div>
												<div class="form-group with-icon label-floating is-empty">
													<label class="control-label">Share what you are thinking here...</label>
													<textarea class="form-control" placeholder=""></textarea>
												<span class="material-input"></span></div>
												<div class="add-options-message">
													<a href="#" class="options-message" data-toggle="tooltip" data-placement="top" data-original-title="ADD PHOTOS">
														<svg class="olymp-camera-icon" data-toggle="modal" data-target="#update-header-photo">
																<svg id="olymp-camera-icon" viewBox="0 0 43 32">
																		<title>camera-icon</title>
																		<path d="M21.333 10.667c-3.927 0-7.111 3.182-7.111 7.111 0 3.927 3.184 7.111 7.111 7.111s7.111-3.184 7.111-7.111c0-3.929-3.184-7.111-7.111-7.111zM21.333 21.337c-1.963 0-3.556-1.593-3.556-3.556s1.593-3.556 3.556-3.556 3.556 1.593 3.556 3.556-1.593 3.556-3.556 3.556zM35.556 3.556h-3.556c0-1.964-1.593-3.556-3.556-3.556h-14.222c-1.963 0-3.556 1.591-3.556 3.556h-3.556c-3.927 0-7.111 3.184-7.111 7.111v14.222c0 3.929 3.184 7.111 7.111 7.111 0 0 6.924 0 15.89 0h0.11v-3.556h-16c-1.963 0-3.556-1.593-3.556-3.556v-14.222c0-1.963 1.593-3.556 3.556-3.556h7.111v-3.556h14.222v3.556h7.111c1.963 0 3.556 1.593 3.556 3.556v14.222c0 1.963-1.593 3.556-3.556 3.556h-1.778v3.556c1.122 0 1.778 0 1.778 0 3.927 0 7.111-3.182 7.111-7.111v-14.222c0-3.927-3.184-7.111-7.111-7.111zM26.667 32h3.556v-3.556h-3.556v3.556z"></path>
																</svg>
														</svg>
													</a>
								
													<button class="btn btn-primary btn-md-2">Post Status</button>
													
								
												</div>
								
											</form>
										</div>
									</div>
								</div>

					</article>
				</div>
				<?php foreach($posts as $post){ ?>
				<div class="ui-block">
						
					
					<article class="hentry post">
					
						<div class="post__author author vcard inline-items">
							<img src="img/<?php echo $post->user_image ?>-sm.jpg" alt="author">
					
							<div class="author-date">
								<a class="h6 post__author-name fn" href="#"><?php echo $post->user_name ?></a>
								<div class="post__date">
									<time class="published" datetime="2004-07-24T18:18">
										9 hours ago
									</time>
								</div>
							</div>
					
							<div class="more"><svg class="olymp-three-dots-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>
								<ul class="more-dropdown">
									<!-- <li>
										<a href="#">Edit Post</a>
									</li> -->
									<li>
										<a href="#">Delete Post</a>
									</li>
								</ul>
							</div>
					
						</div>
					
						<p><?php echo $post->text ?></p>
						<?php if($post->image){ ?>
						<div class="post-thumb">
							<img src="img/<?php echo $post->image ?>.jpg" alt="photo">
						</div>
						<?php } ?>
					
						<div class="post-additional-info inline-items">
					
							<a href="#" class="post-add-icon <?php if($post->liked_by_author) echo "active" ?> inline-items">
								<svg class="olymp-heart-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="svg-icons/sprites/icons.svg#olymp-heart-icon"></use></svg>
								<span><?php echo $post->no_of_likes ?></span>
							</a>
					
							
							
					
					
							<div class="comments-shared">
								<a href="#" class="post-add-icon inline-items">
									<svg class="olymp-speech-balloon-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="svg-icons/sprites/icons.svg#olymp-speech-balloon-icon"></use></svg>
									<span><?php echo $post->no_of_comments ?></span>
								</a>
							</div>
					
					
						</div>
					
						
					</article>
					
					<!-- Comments -->
					
					<ul class="comments-list">
						<ul class="comments-title">
							<li ><svg class="comment-title-icon"
							viewBox="0 -15 75 70">
							
							<g
								id="g12"><path
								id="path2"
								d="M44,18.394v21.141c0,2.722-2.207,4.929-4.929,4.929L22,44.535l-10,11v-11H4.929   C2.207,44.535,0,42.328,0,39.606l0-21.141c0-2.722,2.207-4.929,4.929-4.929l34.141-0.071C41.793,13.465,44,15.672,44,18.394z"
								style="fill:#EBBA16;" /><path
								id="path4"
								d="M22,24.465H9c-0.553,0-1-0.448-1-1s0.447-1,1-1h13c0.553,0,1,0.448,1,1S22.553,24.465,22,24.465z"
								style="fill:#FFFFFF;" /><path
								id="path6"
								d="M35,30.465H9c-0.553,0-1-0.448-1-1s0.447-1,1-1h26c0.553,0,1,0.448,1,1S35.553,30.465,35,30.465z"
								style="fill:#FFFFFF;" /><path
								id="path8"
								d="M35,36.465H9c-0.553,0-1-0.448-1-1s0.447-1,1-1h26c0.553,0,1,0.448,1,1S35.553,36.465,35,36.465z"
								style="fill:#FFFFFF;" /><path
								id="path10"
								d="M53.071,2.535l-34.141-0.07C16.207,2.465,14,4.672,14,7.394v6.122l25.071-0.052   c2.722,0,4.929,2.207,4.929,4.93v18.441l7,7.7v-11h2.071c2.722,0,4.929-2.207,4.929-4.929V7.465   C58,4.742,55.793,2.535,53.071,2.535z"
								style="fill:#FC852E;" /></g><g
								id="g14" /><g
								id="g16" /><g
								id="g18" /><g
								id="g20" /><g
								id="g22" /><g
								id="g24" /><g
								id="g26" /><g
								id="g28" /><g
								id="g30" /><g
								id="g32" /><g
								id="g34" /><g
								id="g36" /><g
								id="g38" /><g
								id="g40" /><g
								id="g42" /></svg>
								<span>Comments</span>
							</li></ul>
						<?php  foreach($post->comments as $comment){ ?>
						<li>
							<div class="post__author author vcard inline-items">
								<img src="img/<?php echo $comment->user_image ?>-sm.jpg" alt="author">
					
								<div class="author-date">
									<a class="h6 post__author-name fn" href="02-ProfilePage.html"><?php echo $comment->user_name?></a>
									<div class="post__date">
										<time class="published" datetime="2004-07-24T18:18">
											38 mins ago
										</time>
									</div>
								</div>
					
								<a href="#" class="more"><svg class="olymp-three-dots-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg></a>
					
							</div>
					
							<p><?php echo $comment->text ?></p>
					
							<a href="#" class="post-add-icon <?php if($post->liked_by_author) echo "active" ?> inline-items">
								<svg class="olymp-heart-icon">
										<svg id="olymp-heart-icon" viewBox="0 0 36 32">
												<title>heart-icon</title>
												<path d="M23.111 21.333h3.556v3.556h-3.556v-3.556z"></path>
												<path d="M32.512 2.997c-2.014-2.011-4.263-3.006-7.006-3.006-2.62 0-5.545 2.089-7.728 4.304-2.254-2.217-5.086-4.295-7.797-4.295-2.652 0-4.99 0.793-6.937 2.738-4.057 4.043-4.057 10.599 0 14.647 1.157 1.157 12.402 13.657 12.402 13.657 0.64 0.638 1.481 0.958 2.32 0.958s1.678-0.32 2.318-0.958l1.863-2.012-2.523-2.507-1.655 1.787c-2.078-2.311-11.095-12.324-12.213-13.442-1.291-1.285-2-2.994-2-4.811 0-1.813 0.709-3.518 2-4.804 1.177-1.175 2.54-1.698 4.425-1.698 0.464 0 2.215 0.236 5.303 3.273l2.533 2.492 2.492-2.532c2.208-2.242 4.201-3.244 5.196-3.244 1.769 0 3.113 0.588 4.496 1.97 1.289 1.284 1.998 2.99 1.998 4.804 0 1.815-0.709 3.522-1.966 4.775-0.087 0.085-0.098 0.094-1.9 2.041l-0.156 0.167 2.523 2.51 0.24-0.26c0 0 1.742-1.881 1.774-1.911 4.055-4.043 4.055-10.603-0.002-14.644z"></path>
										</svg>
								</svg>
								<span><?php echo $comment->no_of_likes ?></span>
							</a>
						</li>
						<?php }?>
					</ul>
					
					<!-- ... end Comments -->

					<!-- <a href="#" class="more-comments">View more comments <span>+</span></a> -->

					
					<!-- Comment Form  -->
					
					<form class="comment-form inline-items">
					
						<div class="post__author author vcard inline-items">
							<img src="img/<?php echo $user_image ?>-sm.jpg" alt="author">
					
							<div class="form-group with-icon-right is-empty">
								<textarea class="form-control" placeholder=""></textarea>
								<div class="add-options-message">
									<a href="#" class="options-message" data-toggle="modal" data-target="#update-header-photo">
										<svg class="olymp-camera-icon">
											<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="svg-icons/sprites/icons.svg#olymp-camera-icon"></use>
										</svg>
									</a>
								</div>
							<span class="material-input"></span></div>
						</div>
					
						<button class="btn btn-md-2 btn-primary">Post Comment</button>
					
						<button class="btn btn-md-2 btn-border-think c-grey btn-transparent custom-color">Cancel</button>
					
					</form>
					
					<!-- ... end Comment Form  -->
			</div>
				<?php } ?>
				
			</div>

			<!-- <a id="load-more-button" href="#" class="btn btn-control btn-more" data-load-link="items-to-load.html" data-container="newsfeed-items-grid"><svg class="olymp-three-dots-icon"><use xlink:href="icons/icons.svg#olymp-three-dots-icon"></use></svg></a> -->
		</div>

		<!-- ... end Main Content -->


		<!-- Left Sidebar -->

		<div class="col-xl-3 order-xl-1 col-lg-6 order-lg-2 col-md-6 col-sm-12 col-xs-12">
			<div class="ui-block">
				<div class="ui-block-title">
					<h6 class="title">Group Intro</h6>
				</div>
				<div class="ui-block-content">
					<ul class="widget w-personal-info item-block">
						<li>
							<span class="title">About Group:</span>
							<span class="text">This is a web development class group.</span>
						</li>
						
						
					</ul>
				</div>
			</div>

		</div>

		<!-- ... end Left Sidebar -->


		<!-- Right Sidebar -->

		<div class="col-xl-3 order-xl-3 col-lg-6 order-lg-3 col-md-6 col-sm-12 col-xs-12">
			<div class="ui-block">
				<div class="ui-block-title">
					<h6 class="title">Group Photos</h6>
				</div>
				<div class="ui-block-content">
					<ul class="widget w-last-photo js-zoom-gallery">
					<?php foreach($posts as $post){if($post->image){ ?>
						<li>
							<a href="img/<?php echo "$post->image" ?>.jpg">
								<img src="img/<?php echo "$post->image" ?>.jpg" alt="photo">
							</a>
						</li>
					<?php } }?>
						
					</ul>
				</div>
			</div>

			
			<div class="ui-block">
				<div class="ui-block-title">
					<h6 class="title">Group's Poll</h6>
				</div>
				<div class="ui-block-content">
					<ul class="widget w-pool">
						<li>
							<p>President  </p>
						</li>
						<?php
						// $sql = "SELECT * From polls where poll_course_id = '$course_id' ";
						// $result = $con->query($sql);
						// if($result->num_rows>0){
						// 	while($row = $result->fetch_assoc()){
						// 		$user_name = $row["user_name"];
						// 		$user_image = $row["user_image"];
						// 	}
						// }
						
						?>
						<li>
							<div class="skills-item">
								<div class="skills-item-info">
									<span class="skills-item-title">

										<span class="radio">
											<label>
												<input type="radio" name="optionsRadios">
											Muzammil Ahmad
											</label>
										</span>
									</span>
									<span class="skills-item-count"><span class="count-animate" data-speed="1000" data-refresh-interval="50" data-to="62" data-from="0"></span><span class="units">62%</span></span>
								</div>
								<div class="skills-item-meter">
									<span class="skills-item-meter-active bg-primary" style="width: 62%"></span>
								</div>
							</div>
						</li>

						<li>
							<div class="skills-item">
								<div class="skills-item-info">
									<span class="skills-item-title">

										<span class="radio">
											<label>
												<input type="radio" name="optionsRadios">
											Php Laravel
											</label>
										</span>
									</span>
									<span class="skills-item-count"><span class="count-animate" data-speed="1000" data-refresh-interval="50" data-to="27" data-from="0"></span><span class="units">27%</span></span>
								</div>
								<div class="skills-item-meter">
									<span class="skills-item-meter-active bg-primary" style="width: 27%"></span>
								</div>
								<div class="counter-friends">7 friends voted for this</div>

								<ul class="friends-harmonic">
									<li>
										<a href="#">
											<img src="img/friend-harmonic7.jpg" alt="friend">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="img/friend-harmonic8.jpg" alt="friend">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="img/friend-harmonic9.jpg" alt="friend">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="img/friend-harmonic10.jpg" alt="friend">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="img/friend-harmonic11.jpg" alt="friend">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="img/friend-harmonic12.jpg" alt="friend">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="img/friend-harmonic13.jpg" alt="friend">
										</a>
									</li>
								</ul>
							</div>
						</li>

						<li>
							<div class="skills-item">
								<div class="skills-item-info">
									<span class="skills-item-title">
										<span class="radio">
											<label>
												<input type="radio" name="optionsRadios">
											Ruby on rails
											</label>
										</span>
									</span>
									<span class="skills-item-count"><span class="count-animate" data-speed="1000" data-refresh-interval="50" data-to="11" data-from="0"></span><span class="units">11%</span></span>
								</div>
								<div class="skills-item-meter">
									<span class="skills-item-meter-active bg-primary" style="width: 11%"></span>
								</div>

								<div class="counter-friends">2 people voted for this</div>

								<ul class="friends-harmonic">
									<li>
										<a href="#">
											<img src="img/friend-harmonic14.jpg" alt="friend">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="img/friend-harmonic15.jpg" alt="friend">
										</a>
									</li>
								</ul>
							</div>
						</li>
					</ul>
					<a href="#" class="btn btn-md-2 btn-border-think custom-color c-grey full-width">Vote Now!</a>
				</div>
			</div> -->
		</div>

		<!-- ... end Right Sidebar -->

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


<div class="window-popup playlist-popup">

	<a href="" class="icon-close js-close-popup">
		<svg class="olymp-close-icon"><use xlink:href="icons/icons.svg#olymp-close-icon"></use></svg>
	</a>

	<table class="playlist-popup-table">

		<thead>

		<tr>

			<th class="play">
				PLAY
			</th>

			<th class="cover">
				COVER
			</th>

			<th class="song-artist">
				SONG AND ARTIST
			</th>

			<th class="album">
				ALBUM
			</th>

			<th class="released">
				RELEASED
			</th>

			<th class="duration">
				DURATION
			</th>

			<th class="spotify">
				GET IT ON SPOTIFY
			</th>

			<th class="remove">
				REMOVE
			</th>
		</tr>

		</thead>

		<tbody>
		<tr>
			<td class="play">
				<a href="#" class="play-icon">
					<svg class="olymp-music-play-icon-big"><use xlink:href="icons/icons-music.svg#olymp-music-play-icon-big"></use></svg>
				</a>
			</td>
			<td class="cover">
				<div class="playlist-thumb">
					<img src="img/playlist19.jpg" alt="thumb-composition">
				</div>
			</td>
			<td class="song-artist">
				<div class="composition">
					<a href="#" class="composition-name">We Can Be Heroes</a>
					<a href="#" class="composition-author">Jason Bowie</a>
				</div>
			</td>
			<td class="album">
				<a href="#" class="album-composition">Ziggy Firedust</a>
			</td>
			<td class="released">
				<div class="release-year">2014</div>
			</td>
			<td class="duration">
				<div class="composition-time">
					<time class="published" datetime="2017-03-24T18:18">6:17</time>
				</div>
			</td>
			<td class="spotify">
				<i class="fa fa-spotify composition-icon" aria-hidden="true"></i>
			</td>
			<td class="remove">
				<a href="#" class="remove-icon">
					<svg class="olymp-close-icon"><use xlink:href="icons/icons.svg#olymp-close-icon"></use></svg>
				</a>
			</td>
		</tr>

		<tr>
			<td class="play">
				<a href="#" class="play-icon">
					<svg class="olymp-music-play-icon-big"><use xlink:href="icons/icons-music.svg#olymp-music-play-icon-big"></use></svg>
				</a>
			</td>
			<td class="cover">
				<div class="playlist-thumb">
					<img src="img/playlist6.jpg" alt="thumb-composition">
				</div>
			</td>
			<td class="song-artist">
				<div class="composition">
					<a href="#" class="composition-name">The Past Starts Slow and Ends</a>
					<a href="#" class="composition-author">System of a Revenge</a>
				</div>
			</td>
			<td class="album">
				<a href="#" class="album-composition">Wonderize</a>
			</td>
			<td class="released">
				<div class="release-year">2014</div>
			</td>
			<td class="duration">
				<div class="composition-time">
					<time class="published" datetime="2017-03-24T18:18">6:17</time>
				</div>
			</td>
			<td class="spotify">
				<i class="fa fa-spotify composition-icon" aria-hidden="true"></i>
			</td>
			<td class="remove">
				<a href="#" class="remove-icon">
					<svg class="olymp-close-icon"><use xlink:href="icons/icons.svg#olymp-close-icon"></use></svg>
				</a>
			</td>
		</tr>

		<tr>
			<td class="play">
				<a href="#" class="play-icon">
					<svg class="olymp-music-play-icon-big"><use xlink:href="icons/icons-music.svg#olymp-music-play-icon-big"></use></svg>
				</a>
			</td>
			<td class="cover">
				<div class="playlist-thumb">
					<img src="img/playlist7.jpg" alt="thumb-composition">
				</div>
			</td>
			<td class="song-artist">
				<div class="composition">
					<a href="#" class="composition-name">The Pretender</a>
					<a href="#" class="composition-author">Kung Fighters</a>
				</div>
			</td>
			<td class="album">
				<a href="#" class="album-composition">Warping Lights</a>
			</td>
			<td class="released">
				<div class="release-year">2014</div>
			</td>
			<td class="duration">
				<div class="composition-time">
					<time class="published" datetime="2017-03-24T18:18">6:17</time>
				</div>
			</td>
			<td class="spotify">
				<i class="fa fa-spotify composition-icon" aria-hidden="true"></i>
			</td>
			<td class="remove">
				<a href="#" class="remove-icon">
					<svg class="olymp-close-icon"><use xlink:href="icons/icons.svg#olymp-close-icon"></use></svg>
				</a>
			</td>
		</tr>

		<tr>
			<td class="play">
				<a href="#" class="play-icon">
					<svg class="olymp-music-play-icon-big"><use xlink:href="icons/icons-music.svg#olymp-music-play-icon-big"></use></svg>
				</a>
			</td>
			<td class="cover">
				<div class="playlist-thumb">
					<img src="img/playlist8.jpg" alt="thumb-composition">
				</div>
			</td>
			<td class="song-artist">
				<div class="composition">
					<a href="#" class="composition-name">Seven Nation Army</a>
					<a href="#" class="composition-author">The Black Stripes</a>
				</div>
			</td>
			<td class="album">
				<a href="#" class="album-composition ">Icky Strung (LIVE at Cube Garden)</a>
			</td>
			<td class="released">
				<div class="release-year">2014</div>
			</td>
			<td class="duration">
				<div class="composition-time">
					<time class="published" datetime="2017-03-24T18:18">6:17</time>
				</div>
			</td>
			<td class="spotify">
				<i class="fa fa-spotify composition-icon" aria-hidden="true"></i>
			</td>
			<td class="remove">
				<a href="#" class="remove-icon">
					<svg class="olymp-close-icon"><use xlink:href="icons/icons.svg#olymp-close-icon"></use></svg>
				</a>
			</td>
		</tr>

		<tr>
			<td class="play">
				<a href="#" class="play-icon">
					<svg class="olymp-music-play-icon-big"><use xlink:href="icons/icons-music.svg#olymp-music-play-icon-big"></use></svg>
				</a>
			</td>
			<td class="cover">
				<div class="playlist-thumb">
					<img src="img/playlist9.jpg" alt="thumb-composition">
				</div>
			</td>
			<td class="song-artist">
				<div class="composition">
					<a href="#" class="composition-name">Leap of Faith</a>
					<a href="#" class="composition-author">Eden Artifact</a>
				</div>
			</td>
			<td class="album">
				<a href="#" class="album-composition">The Assassins’s Soundtrack</a>
			</td>
			<td class="released">
				<div class="release-year">2014</div>
			</td>
			<td class="duration">
				<div class="composition-time">
					<time class="published" datetime="2017-03-24T18:18">6:17</time>
				</div>
			</td>
			<td class="spotify">
				<i class="fa fa-spotify composition-icon" aria-hidden="true"></i>
			</td>
			<td class="remove">
				<a href="#" class="remove-icon">
					<svg class="olymp-close-icon"><use xlink:href="icons/icons.svg#olymp-close-icon"></use></svg>
				</a>
			</td>
		</tr>

		<tr>
			<td class="play">
				<a href="#" class="play-icon">
					<svg class="olymp-music-play-icon-big"><use xlink:href="icons/icons-music.svg#olymp-music-play-icon-big"></use></svg>
				</a>
			</td>
			<td class="cover">
				<div class="playlist-thumb">
					<img src="img/playlist10.jpg" alt="thumb-composition">
				</div>
			</td>
			<td class="song-artist">
				<div class="composition">
					<a href="#" class="composition-name">Killer Queen</a>
					<a href="#" class="composition-author">Archiduke</a>
				</div>
			</td>
			<td class="album">
				<a href="#" class="album-composition ">News of the Universe</a>
			</td>
			<td class="released">
				<div class="release-year">2014</div>
			</td>
			<td class="duration">
				<div class="composition-time">
					<time class="published" datetime="2017-03-24T18:18">6:17</time>
				</div>
			</td>
			<td class="spotify">
				<i class="fa fa-spotify composition-icon" aria-hidden="true"></i>
			</td>
			<td class="remove">
				<a href="#" class="remove-icon">
					<svg class="olymp-close-icon"><use xlink:href="icons/icons.svg#olymp-close-icon"></use></svg>
				</a>
			</td>
		</tr>
		</tbody>
	</table>

	<audio id="mediaplayer" data-showplaylist="true">
		<source src="mp3/Twice.mp3" title="Track 1" data-poster="track1.png" type="audio/mpeg">
		<source src="mp3/Twice.mp3" title="Track 2" data-poster="track2.png" type="audio/mpeg">
		<source src="mp3/Twice.mp3" title="Track 3" data-poster="track3.png" type="audio/mpeg">
		<source src="mp3/Twice.mp3" title="Track 4" data-poster="track4.png" type="audio/mpeg">
	</audio>

</div>

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


</body>
</html>