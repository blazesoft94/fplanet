<?php
	include_once "includes/connect_db.php";
    $user_id = $_POST["user_id"]; 
	$friend_id = $_POST["friend_id"];
	$msg_content = $_POST["data"];

	$current_date = date("Y-m-d");
	// echo "$current_date";
	$current_time = "06:55:32";

	$sql = "INSERT INTO `messages`(`message_sender_id`, `message_reciever_id`, `message_content`, `message_date`, `message_time`) VALUES ('$user_id','$friend_id','$msg_content','$current_date','$current_time')";
	if($con->query($sql) == TRUE){
		echo "0";
	}
	else{
		echo "-1";
	}

    
?>
