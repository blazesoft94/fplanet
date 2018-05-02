<?php 
include "../includes/connect_db.php";
$group_id = $_GET["group_id"];
$sql = "DELETE FROM `groups` WHERE group_id = '$group_id'";
$con->query($sql);
header("Location: groups.php");


?>