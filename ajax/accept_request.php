<?php
session_start();
include "../includes/connect_db.php";
$user_id = $_SESSION["id"];
$friend_id = $_GET["friend_id"];
$request_id = $_GET["request_id"];
$success = false;
$sql = "select * from friends where friend_first_id = '$user_id' and friend_second_id = '$friend_id'";
$result = $con->query($sql);
if($result->num_rows==0){
    $sql = "INSERT INTO `friends` (`friend_id`, `friend_first_id`, `friend_second_id`) VALUES (NULL, '$user_id', '$friend_id'), (NULL, '$friend_id', '$user_id')";
    if($con->query($sql) == TRUE){
        $success = TRUE;
        $sql = "DELETE FROM `friend_requests` WHERE `friend_requests`.`request_id` = $request_id";
        if($con->query($sql) == TRUE){
            $success = TRUE;
        }
    }
}
else{
    $sql = "DELETE FROM `friend_requests` WHERE `friend_requests`.`request_id` = $request_id";
    if($con->query($sql) == TRUE){
        $success = TRUE;
    }
}


if($success){
    echo "success";
}
else{
    echo "some error";
}



?>