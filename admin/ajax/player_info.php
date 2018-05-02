<?php 
include_once "../includes/dbadmin.php";
$player_id = $_GET["player_id"];
$sql = "select * from team_players where player_id__blazeweb = $player_id";
$result = $con->query($sql);
if($result->num_rows>0){
    $row = $result->fetch_assoc();
    // $jersey = $row["player_jerseynumber__blazeweb"];
    // $fname = $row["player_firstname__blazeweb"];
    // $lname = $row["player_lastname__blazeweb"];
    // $position = $row["player_positions__blazeweb"];
    // $height = $row["player_height__blazeweb"];
    // $weight = $row["player_weight__blazeweb"];
    // $sypnosis = $row["player_sypnosis__blazeweb"];
    // $image = $row["player_image__blazeweb"];
    // echo "{
    //     player_jersey : $jersey,
    //     player_fname : $fname,
    //     player_lname : $lname,
    //     player_position : $position,
    //     player_height : $height,
    //     player_weight : $weight,
    //     player_sypnosis : $sypnosis,
    //     player_image : $image
    // }";
    echo json_encode($row);
}

?>