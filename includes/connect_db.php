<?php 
$server = "localhost";
$username  = "root";
$password = "";
$dbName = "fplanet";
$con = "";
//Connecting to db
$con = new mysqli($server, $username, $password);
if($con->connect_error){
    echo "connection error! <br>";
}

//selecting database 

$sql = "USE " .$dbName;
if($con->query($sql) == TRUE){
    // echo "Database selected <hr>";
}
else{
    // echo "Database selection error<hr>";
}

?>