<?php 
if(isset($_POST["firstname"])){
   $fname = mysql_escape_string(htmlspecialchars($_POST["firstname"]));
   $lname = mysql_escape_string(htmlspecialchars($_POST["lastname"]));
   $email = mysql_escape_string(htmlspecialchars($_POST["email"]));
   $pass = mysql_escape_string(htmlspecialchars($_POST["pass"]));
   $societies = $_POST["societies"];
   $major = mysql_escape_string(htmlspecialchars($_POST["major"]));
   $society1 = "";
   $society2 = "";
   $name = $fname." ".$lname;
   
   if(isset($societies[0])){
       $society1 = mysql_escape_string(htmlspecialchars($societies[0]));
   }
   
   if(isset($societies[1])){
       $society2 = mysql_escape_string(htmlspecialchars($societies[1]));
   }
   echo $society1."<hr>";
   echo $society2."<hr>";
   if(empty($society2)){
       echo "SOCIETY 2 empty<hr>";
   }
//    $ mysql_escape_string(htmlspecialchars($_POST["firstname"]));

    if(empty($fname) || empty($lname) || empty($email) || empty($pass) || empty($major)){
        echo "Please fill in all the fields";
    }
    else{

include_once "includes/connect_db.php";
$id = substr($email, 0,2). substr($email,3,5);
echo "$email $id $fname $lname $name $pass $major<hr>";
$sql = "SELECT * from users where user_id = '$id'";
$result = $con->query($sql);
if($result->num_rows>0){
    echo "USER ALREADY EXISTS";
}
else{

$hash = md5(rand(0,1000));
echo $hash;
$sql = "INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_image`, `user_password`, `user_hash`, `user_activated`, `user_society1`, `user_society2`) VALUES ('$id', '$name', '$email', NULL, '$pass', '$hash', '0','$society1','$society2');";
if($con->query($sql) == TRUE){
    $headers = 'From:noreply@fhbasketball.epizy.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    $msg = "Please activate your account with the following link: \n\n http://www.fplanet.epizy.com/activate.php?id=$id&hash=$hash";
    $x = mail($email, "account activation", $msg, $headers); // Send our email
    if($x == 1){
        echo "Please check your mail to reactivate";
    }
    else{
        echo "Sorry, something wrong has happened";
    }
}
else{
    echo "unable to add values";
}

}



// };
    // $headers = 'From:noreply@fhbasketball.epizy.com' . "\r\n" .
    // 'X-Mailer: PHP/' . phpversion();
    // $x = mail("", "account activation", "Please activate your account", $headers); // Send our email
    // echo "mail sent ".$x;
}}
?>