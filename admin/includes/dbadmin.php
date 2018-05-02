<?php
    $server = "localhost";
    $username  = "root";
    $password = "";
    $dbName = "fhbasketball";
    $con = "";
    $con = new mysqli($server, $username, $password);
    
    $sql = "USE " .$dbName;
    $con->query($sql);
?>