<?php
include_once "includes/connect_db.php"; 
    $id = mysql_escape_string( htmlspecialchars($_GET["id"]));
    $hash = mysql_escape_string( htmlspecialchars($_GET["hash"]));
    $sql = "UPDATE `users` SET `user_activated` = '1' WHERE `users`.`user_id` = '$id' and `users`.`user_hash` = '$hash'";
    if($con->query($sql) == TRUE){
        echo "Account Activated";
    }
    else{
        echo "Unable to Activate Account";
    }
    
?>