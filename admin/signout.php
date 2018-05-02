<?php 
session_start();
$_SESSION["admin_login"]=false;
$_SESSION["role"]="";

header("Location: login.php");
?>