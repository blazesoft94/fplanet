<?php 
    $new_messages = 0;
    $new_notifications = 0;
	$new_requests = 0;

    class Message {
        public $sender_id;
        public $sender_name;
        public $sender_image;
        public $text;
        public $date;
		public $time;
		public $status;

        public function __construct($sender,$sender_name,$sender_image,$text,$date,$time,$status){
            $this->sender_id = $sender;
            $this->sender_name = $sender_name;
            $this->sender_image = $sender_image;
            $this->date = $date;
            $this->time = $time;
			$this->text = $text;
			$this->status = $status;

        }
    }

    // $msg = new Message();
//	m.message_id, m.message_sender_id, u.user_name, m.message_time, m.message_date, u.user_image, m.message_content, u.user_image, m.message_status
	
    $messages = [];
	$sql = "SELECT *
    FROM messages m, users u
    WHERE m.message_sender_id = u.user_id AND message_id in (
        SELECT MAX(message_id)
        FROM messages
        WHERE message_reciever_id = '$id'
        GROUP BY message_sender_id
    ) 
    GROUP BY (message_sender_id)";
    $result = $con->query($sql);
    $c = 0;
	if($result->num_rows>0){
		while($row = $result->fetch_assoc()){
            if($c<4){
                $msg = new Message($row["message_sender_id"],$row["user_name"],$row["user_image"], $row["message_content"], $row["message_date"], $row["message_time"],$row["message_status"]);
                $messages[$c]= $msg;
                $c+=1;
            }
            if($row["message_status"]=="unread")
			$new_messages +=1;
		}
    }
    

    class Notification {
        public $sender_id;
        public $sender_name;
        public $sender_image;
		public $origination_group;
		public $post_id;
        public $text;
        public $date;
        public $time;

        public function __construct($sender_id,$sender_name, $sender_image,$origination_group,$text,$date,$time, $post_id){
            $this->sender_id = $sender_id;
            $this->sender_name = $sender_name;
            $this->sender_image = $sender_image;
            $this->origin_id = $origination_group;
            $this->date = $date;
            $this->time = $time;
			$this->text = $text;
			$this->post_id = $post_id;

        }
    }

    $notifications = [];
	$sql = "SELECT notification_sender_id,user_name,user_image,notification_origin_id,notification_text,notification_date,notification_time, notification_status,notification_location FROM notifications n, users u
    where  n.notification_reciever_id = '$id' and n.notification_sender_id = u.user_id ORDER BY n.notification_id DESC";
    $result = $con->query($sql);
    $c = 0;
	if($result->num_rows>0){
		while($row = $result->fetch_assoc()){
            if($c<4){
                $notif = new Notification($row["notification_sender_id"],$row["user_name"],$row["user_image"],$row["notification_origin_id"],$row["notification_text"], $row["notification_date"], $row["notification_time"],$row["notification_location"]);
                $notifications[$c]= $notif;
                $c+=1;
            }       
            if($row['notification_status']=="unread") $new_notifications +=1;
		}
    }
    
    class Request {
		public $request_id;
        public $sender_id;
        public $sender_name;
        public $sender_image;
        public $date;
        public $time;

        public function __construct($request_id,$sender_id,$sender_name,$sender_image,$date,$time){
			$this->request_id = $request_id;
            $this->sender_id = $sender_id;
            $this->sender_name = $sender_name;
            $this->sender_image = $sender_image;
            $this->date = $date;
            $this->time = $time;
            $this->sender_id = $sender_id;
        }
    }


    $requests = [];
	$sql = "select * from friend_requests f, users u where f.request_from_id = u.user_id and request_to_id = '$id' ORDER BY request_id desc";
    $result = $con->query($sql);
    $c = 0;
	if($result->num_rows>0){
		while($row = $result->fetch_assoc()){
            if($c<4){
                $req = new Request($row["request_id"],$row["user_id"],$row["user_name"],$row["user_image"], $row["request_date"], $row["request_time"]);
                $requests[$c]= $req;
                $c+=1;
            }
            $new_requests +=1;
		}
	}

?>
	<div id="<?php echo $id?>" class="header-content-wrapper">
		<form class="search-bar w-search notification-list friend-requests">
			<div class="form-group with-button">
				<input class="form-control js-user-search" placeholder="Search here people or pages..." type="text">
				<button>
					<svg class="olymp-magnifying-glass-icon"><use xlink:href="icons/icons.svg#olymp-magnifying-glass-icon"></use></svg>
				</button>
			</div>
		</form>

		<!-- <a href="#" class="link-find-friend">Find Friends</a> -->

		<div class="control-block">

			<div class="control-icon more has-items">
				<svg class="olymp-happy-face-icon"><use xlink:href="icons/icons.svg#olymp-happy-face-icon"></use></svg>
				<div class="label-avatar bg-blue"><?php echo $new_requests ?></div>

				<div class="more-dropdown more-with-triangle triangle-top-center">
					<div class="ui-block-title ui-block-title-small">
						<h6 class="title">FRIEND REQUESTS</h6>
						<a href="#">Find Friends</a>
						<a href="#">Settings</a>
					</div>

					<div class="mCustomScrollbar" data-mcs-theme="dark">
						<ul class="notification-list friend-requests">
							<?php 
								foreach($requests as $request){
									
							?>
							<li>
								<div class="author-thumb">
									<img src="img/<?php echo $request->sender_image?>-sm.jpg" alt="author">
								</div>
								<div class="notification-event">
									<a href="#" class="h6 notification-friend"><?php echo $request->sender_name;?></a>
									<!-- <span class="chat-message-item">Mutual Friend: Sarah Hetfield</span> -->
								</div>
								<span class="notification-icon">
									<a href="#" data-requestid="<?php echo $request->request_id?>" data-id="<?php echo $request->sender_id?>" id = "friend-request-<?php echo $request->sender_id?>" class="accept-request done-request">
										<span class="icon-add without-text">
											<svg class="olymp-happy-face-icon"><use xlink:href="icons/icons.svg#olymp-happy-face-icon"></use></svg>
										</span>
									</a>

									<a href="#" class="accept-request request-del">
										<span class="icon-minus">
											<svg class="olymp-happy-face-icon"><use xlink:href="icons/icons.svg#olymp-happy-face-icon"></use></svg>
										</span>
									</a>

								</span>

								<div class="more">
									<svg class="olymp-three-dots-icon"><use xlink:href="icons/icons.svg#olymp-three-dots-icon"></use></svg>
								</div>
							</li>
								<?php } ?>
<!-- 
							<li class="accepted">
								<div class="author-thumb">
									<img src="img/avatar57-sm.jpg" alt="author">
								</div>
								<div class="notification-event">
									You and <a href="#" class="h6 notification-friend">Mary Jane Stark</a> just became friends. Write on <a href="#" class="notification-link">her wall</a>.
								</div>
								<span class="notification-icon">
									<svg class="olymp-happy-face-icon"><use xlink:href="icons/icons.svg#olymp-happy-face-icon"></use></svg>
								</span>

								<div class="more">
									<svg class="olymp-three-dots-icon"><use xlink:href="icons/icons.svg#olymp-three-dots-icon"></use></svg>
									<svg class="olymp-little-delete"><use xlink:href="icons/icons.svg#olymp-little-delete"></use></svg>
								</div>
							</li> -->

						</ul>
					</div>

					<a href="#" class="view-all bg-blue">Check all your Requests</a>
				</div>
			</div>

			<div class="control-icon more has-items">
				<svg class="olymp-chat---messages-icon"><use xlink:href="icons/icons.svg#olymp-chat---messages-icon"></use></svg>
				<div class="label-avatar bg-purple"><?php echo "$new_messages"?></div>

				<div class="more-dropdown more-with-triangle triangle-top-center">
					<div class="ui-block-title ui-block-title-small">
						<h6 class="title">Chat / Messages</h6>
						<a href="#">Mark all as read</a>
						<a href="#">Settings</a>
					</div>

					<div class="mCustomScrollbar" data-mcs-theme="dark">
						<ul class="notification-list chat-message">
							<?php foreach($messages as $message){ ?>
							<li id="<?php echo $message->sender_id?>" class="<?php if($message->status =="unread") echo "message-unread" ?> msg-head js-chat-open">
								<div class="author-thumb">
									<img src="img/<?php echo $message->sender_image ?>-sm.jpg" alt="author">
								</div>
								<div class="notification-event">
									<a href="#" class="h6 notification-friend"><?php echo $message->sender_name?></a>
									<span class="chat-message-item"><?php echo $message->text?></span>
									<span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">4 hours ago</time></span>
								</div>
								<span class="notification-icon">
									<svg class="olymp-chat---messages-icon"><use xlink:href="icons/icons.svg#olymp-chat---messages-icon"></use></svg>
								</span>
								<div class="more">
									<svg class="olymp-three-dots-icon"><use xlink:href="icons/icons.svg#olymp-three-dots-icon"></use></svg>
								</div>
							</li>
							<?php }?>
<!-- 							
							<li class="chat-group">
								<div class="author-thumb">
									<img src="img/avatar11-sm.jpg" alt="author">
									<img src="img/avatar12-sm.jpg" alt="author">
									<img src="img/avatar13-sm.jpg" alt="author">
									<img src="img/avatar10-sm.jpg" alt="author">
								</div>
								<div class="notification-event">
									<a href="#" class="h6 notification-friend">You, Faye, Ed &amp; Jet +3</a>
									<span class="last-message-author">Ed:</span>
									<span class="chat-message-item">Yeah! Seems fine by me!</span>
									<span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">March 16th at 10:23am</time></span>
								</div>
									<span class="notification-icon">
										<svg class="olymp-chat---messages-icon"><use xlink:href="icons/icons.svg#olymp-chat---messages-icon"></use></svg>
									</span>
								<div class="more">
									<svg class="olymp-three-dots-icon"><use xlink:href="icons/icons.svg#olymp-three-dots-icon"></use></svg>
								</div>
							</li> -->
						</ul>
					</div>

					<a href="#" class="view-all bg-purple">View All Messages</a>
				</div>
			</div>

			<div class="control-icon more has-items">
				<svg class="olymp-thunder-icon"><use xlink:href="icons/icons.svg#olymp-thunder-icon"></use></svg>

				<div class="label-avatar bg-primary"><?php echo "$new_notifications" ?></div>

				<div class="more-dropdown more-with-triangle triangle-top-center">
					<div class="ui-block-title ui-block-title-small">
						<h6 class="title">Notifications</h6>
						<a href="#">Mark all as read</a>
						<a href="#">Settings</a>
					</div>

					<div class="mCustomScrollbar" data-mcs-theme="dark">
						<ul class="notification-list">
                            <?php foreach($notifications as $notif_obj){ ?>
							<li>
								<div class="author-thumb">
									<img src="img/<?php echo $notif_obj->sender_image ?>-sm.jpg" alt="author">
								</div>
								<div class="notification-event">
									<div><a href="#" class="h6 notification-friend"><?php echo $notif_obj->sender_name ?></a> <?php echo $notif_obj->text ?> 
									<a href="#" class="notification-link"> your post</a>.
								</div>
									<span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">4 hours ago</time></span>
								</div>
									<span class="notification-icon">
										<svg class="olymp-comments-post-icon"><use xlink:href="icons/icons.svg#olymp-comments-post-icon"></use></svg>
									</span>

								<div class="more">
									<svg class="olymp-three-dots-icon"><use xlink:href="icons/icons.svg#olymp-three-dots-icon"></use></svg>
									<svg class="olymp-little-delete"><use xlink:href="icons/icons.svg#olymp-little-delete"></use></svg>
								</div>
							</li>
                            <?php } ?>

							<!-- <li class="un-read">
								<div class="author-thumb">
									<img src="img/avatar63-sm.jpg" alt="author">
								</div>
								<div class="notification-event">
									<div>You and <a href="#" class="h6 notification-friend">Nicholas Grissom</a> just became friends. Write on <a href="#" class="notification-link">his wall</a>.</div>
									<span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">9 hours ago</time></span>
								</div>
									<span class="notification-icon">
										<svg class="olymp-happy-face-icon"><use xlink:href="icons/icons.svg#olymp-happy-face-icon"></use></svg>
									</span>

								<div class="more">
									<svg class="olymp-three-dots-icon"><use xlink:href="icons/icons.svg#olymp-three-dots-icon"></use></svg>
									<svg class="olymp-little-delete"><use xlink:href="icons/icons.svg#olymp-little-delete"></use></svg>
								</div>
							</li>

							<li class="with-comment-photo">
								<div class="author-thumb">
									<img src="img/avatar64-sm.jpg" alt="author">
								</div>
								<div class="notification-event">
									<div><a href="#" class="h6 notification-friend">Sarah Hetfield</a> commented on your <a href="#" class="notification-link">photo</a>.</div>
									<span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">Yesterday at 5:32am</time></span>
								</div>
									<span class="notification-icon">
										<svg class="olymp-comments-post-icon"><use xlink:href="icons/icons.svg#olymp-comments-post-icon"></use></svg>
									</span>

								<div class="comment-photo">
									<img src="img/comment-photo1.jpg" alt="photo">
									<span>“She looks incredible in that outfit! We should see each...”</span>
								</div>

								<div class="more">
									<svg class="olymp-three-dots-icon"><use xlink:href="icons/icons.svg#olymp-three-dots-icon"></use></svg>
									<svg class="olymp-little-delete"><use xlink:href="icons/icons.svg#olymp-little-delete"></use></svg>
								</div>
							</li>

							<li>
								<div class="author-thumb">
									<img src="img/avatar65-sm.jpg" alt="author">
								</div>
								<div class="notification-event">
									<div><a href="#" class="h6 notification-friend">Green Goo Rock</a> invited you to attend to his event Goo in <a href="#" class="notification-link">Gotham Bar</a>.</div>
									<span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">March 5th at 6:43pm</time></span>
								</div>
									<span class="notification-icon">
										<svg class="olymp-happy-face-icon"><use xlink:href="icons/icons.svg#olymp-happy-face-icon"></use></svg>
									</span>

								<div class="more">
									<svg class="olymp-three-dots-icon"><use xlink:href="icons/icons.svg#olymp-three-dots-icon"></use></svg>
									<svg class="olymp-little-delete"><use xlink:href="icons/icons.svg#olymp-little-delete"></use></svg>
								</div>
							</li>

							<li>
								<div class="author-thumb">
									<img src="img/avatar66-sm.jpg" alt="author">
								</div>
								<div class="notification-event">
									<div><a href="#" class="h6 notification-friend">James Summers</a> commented on your new <a href="#" class="notification-link">profile status</a>.</div>
									<span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">March 2nd at 8:29pm</time></span>
								</div>
									<span class="notification-icon">
										<svg class="olymp-heart-icon"><use xlink:href="icons/icons.svg#olymp-heart-icon"></use></svg>
									</span>

								<div class="more">
									<svg class="olymp-three-dots-icon"><use xlink:href="icons/icons.svg#olymp-three-dots-icon"></use></svg>
									<svg class="olymp-little-delete"><use xlink:href="icons/icons.svg#olymp-little-delete"></use></svg>
								</div>
							</li> -->
						</ul>
					</div>

					<a href="#" class="view-all bg-primary">View All Notifications</a>
				</div>
			</div>

			<div class="author-page author vcard inline-items more">
				<div class="author-thumb">
					<img alt="author" src="img/<?php echo $user_image ?>-sm.jpg" class="avatar">
					<span class="icon-status online"></span>
					<div class="more-dropdown more-with-triangle">
						<div class="mCustomScrollbar" data-mcs-theme="dark">
							<div class="ui-block-title ui-block-title-small">
								<h6 class="title">Your Account</h6>
							</div>

							<ul class="account-settings">
								<!-- <li>
									<a href="29-YourAccount-AccountSettings.html">

										<svg class="olymp-menu-icon"><use xlink:href="icons/icons.svg#olymp-menu-icon"></use></svg>

										<span>Profile Settings</span>
									</a>
								</li> -->
								<li>
									<a id="logout-button" href="#">
										<svg class="olymp-logout-icon"><use xlink:href="icons/icons.svg#olymp-logout-icon"></use></svg>

										<span>Log Out</span>
									</a>
								</li>
							</ul>
							<script>
								document.getElementById("logout-button").addEventListener("click",function(){
									window.location.href="logout.php";
								});
							</script>

							<!-- <div class="ui-block-title ui-block-title-small">
								<hf6 class="title">Custom Status</h6>
							</div>

							<form class="form-group with-button custom-status">
								<input class="form-control" placeholder="" type="text" value="Space Cowboy">

								<button class="bg-purple">
									<svg class="olymp-check-icon"><use xlink:href="icons/icons.svg#olymp-check-icon"></use></svg>
								</button>
							</form> -->

							<div class="ui-block-title ui-block-title-small">
								<h6 class="title">About FPlanet</h6>
							</div>

							<ul>
								<li>
									<a href="#">
										<span>Terms and Conditions</span>
									</a>
								</li>
								<li>
									<a href="#">
										<span>FAQs</span>
									</a>
								</li>
								<li>
									<a href="#">
										<span>Careers</span>
									</a>
								</li>
								<li>
									<a href="#">
										<span>Contact</span>
									</a>
								</li>
							</ul>
						</div>

					</div>
				</div>
				<a  class="author-name fn">
					<div class="author-title">
						<?php echo $user_name ?> <svg class="olymp-dropdown-arrow-icon"><use xlink:href="icons/icons.svg#olymp-dropdown-arrow-icon"></use></svg>
					</div>
					<span class="author-subtitle"><?php echo $roll_no ?></span>
				</a>
			</div>

		</div>
	</div>
	<script>
		var script = document.createElement('script');
		script.type = 'text/javascript';
		script.src = 'js/accept_request.js';
		document.body.appendChild(script);
	</script>



