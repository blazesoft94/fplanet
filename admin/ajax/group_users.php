<?php

$group_id = $_GET["group_id"]; 
include "../../includes/connect_db.php";

?>
<div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <!-- <th>Activated</th> -->
                                            <!-- <th>Change Role</th> -->
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        //Display Posts
                                        $sql = "SELECT * FROM registrations, users where registration_group_id = '$group_id' and registration_user_id = user_id ORDER BY registration_id desc";
                                        $result = $con->query($sql);
                                        $count = 0;
                                        if($result->num_rows>0){
                                            while($row = $result->fetch_assoc()){
                                                $count++;
                                                $u_id = $row['user_id'];
                                                $u_username = $row['user_name'];
                                                $u_email = $row["user_email"];
                                                // $u_activated = $row['user_activated'];
                                                // $u_lastname = $row['user_lastname__blazeweb'];
                                                // $u_role = $row["user_type__blazeweb"];
                                                echo "<tr>";
                                                echo "<th scope='row'>{$u_id}</th>";
                                                echo "<td>{$u_username}</td>";
                                                echo "<td>{$u_email}</td>";
                                                // echo "<td class=";                                                
                                                // if($u_activated == "1"){
                                                //     echo "'text-success'>Activated</td>";
                                                // }
                                                // else{
                                                //     echo "'text-danger'>Not Activated</td>";
                                                // }
                                                // echo ">{$u_activated}</td>";                                                
                                                // echo "<td><a href='#' type='button' class='' data-toggle='modal' data-id='$u_id' data-target='#user_edit_role' data-role='$u_role' >Edit</a></td>";
                                                echo "<td><a href='groups.php?user_delete=true&user_id=$u_id&group_id=$group_id'>Delete</a></td>";
                                                echo "</tr>";
                                            }
                                        }
                                    ?>  
                                        <!-- <tr>
                                            <th scope="row">1</th>
                                            <td>John</td>
                                        </tr> -->
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
