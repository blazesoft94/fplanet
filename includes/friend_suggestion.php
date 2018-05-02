<div class="ui-block">
				<div class="ui-block-title">
					<h6 class="title">Friend Suggestions</h6>
					<a href="#" class="more"><svg class="olymp-three-dots-icon"><use xlink:href="#olymp-three-dots-icon"></use></svg></a>
				</div>

				<ul class="widget w-friend-pages-added notification-list friend-requests">
					<?php
						$sql = "select * from users where user_id in ( SELECT friend_second_id FROM `friends` WHERE friend_first_id in ( select friend_second_id from friends where friend_first_id = '$id') and friend_second_id != '$id' and friend_second_id not in ( select friend_second_id from friends where friend_first_id = '$id') and friend_second_id not in (select request_to_id from friend_requests WHERE request_from_id = '$id' ) group by friend_second_id order by  COUNT(friend_second_id) desc)";
						$result = $con->query($sql);
						if($result->num_rows>0){
							$count = 0;
							while($row = $result->fetch_assoc() and $count<10){

							
					?>

					<li class="inline-items">
						<div class="author-thumb">
							<img src="img/<?php echo $row["user_image"] ?>-sm.jpg" alt="author">
						</div>
						<div class="notification-event">
							<a href="#"  class="h6 notification-friend"><?php echo $row["user_name"] ?></a>
							<!-- <span class="chat-message-item">6 Friends in Common</span> -->
						</div>
						<span class="notification-icon">
							<a href="#" data-toggle="modal" data-target="#request-sent" id="friend-suggestion-<?php echo $row["user_id"]?>" data-id="<?php echo $row["user_id"]?>" class="accept-request send-request">
								<span class="icon-add without-text">
									<svg class="olymp-happy-face-icon"><use xlink:href="#olymp-happy-face-icon"></use></svg>
								</span>
							</a>
						</span>

					</li>
							<?php }} ?>

				</ul>

</div>
<div class="modal fade" id="request-sent">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Friend Request Sent</h4>
            </div>
            <!-- <div class="modal-body">
                <p>Sent.</p>
            </div> -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>