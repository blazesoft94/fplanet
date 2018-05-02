<?php
include "../includes/connect_db.php";
session_start();
$id = $_SESSION["id"];
$friend = $_GET["user_id"];
$curr_time = date("H:i:s");
$curr_date = date("Y-m-d");
$sql = "INSERT INTO `friend_requests` (`request_id`, `request_from_id`, `request_to_id`, `request_date`, `request_time`) VALUES (NULL, '$id', '$friend', '$curr_date', '$curr_time')";
if($con->query($sql) == TRUE){
    echo "sent";
}
else{
    echo "error";
}


// echo "sent";

?>