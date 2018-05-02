<?php
session_start();
include_once "../includes/connect_db.php";


$email = mysql_escape_string(htmlspecialchars( $_GET["id"]));
$pass = mysql_escape_string(htmlspecialchars( $_GET["pass"]));

if(!empty($email) && !empty($pass)){
    $id = substr($email, 0,2). substr($email,3,5);
    $sql = "select * from users where user_id = '$id' and user_password = '$pass'";
    $result = $con->query($sql);
    if($result->num_rows==1){
        echo '{
            "login" : "true"
        }';
        $_SESSION["login"]= true;
        $_SESSION["id"]= $id;
    }
    else{
        echo '{"login":"false"}';
    }
}




?>