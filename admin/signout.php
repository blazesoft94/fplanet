<?php 
session_start();
$_SESSION["admin_login"]=false;
$_SESSION["role"]="";
session_destroy();
header("Location: login.php");
?>