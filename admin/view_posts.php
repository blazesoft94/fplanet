<?php
session_start();
include "includes/header.php";
?>
<?php if(isset($_SESSION["login"]) && $_SESSION["role"]=="admin"){?>
<?php 
//delete post
deletePost();
    
?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php
            include "includes/navigation.php";
        ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Admin Panel
                            <small class="muted">Categories</small>
                        </h1>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Jersey</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Position</th>
                                            <th>Image</th>
                                            <th>Height</th>
                                            <th>Weight</th>
                                            <th>View/Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        //Display Posts
                                        $sql = "SELECT * from team_players ORDER BY player_id__blazeweb desc";
                                        $result = $con->query($sql);
                                        if($result->num_rows>0){
                                            $count=0;
                                            while($row = $result->fetch_assoc()){
                                                $count++;
                                                $p_id = $row["player_id__blazeweb"];
                                                $p_jersey = $row['player_jerseynumber__blazeweb'];
                                                $p_fname = $row['player_firstname__blazeweb'];
                                                $p_lname = $row['player_lastname__blazeweb'];
                                                $p_position = $row['player_positions__blazeweb'];
                                                $p_image = $row['player_image__blazeweb'];
                                                $p_height = $row['player_height__blazeweb'];
                                                $p_weight = $row['player_weight__blazeweb'];
                                                echo "<tr>";
                                                echo "<th scope='row'>{$p_jersey}</th>";
                                                echo "<td>{$p_fname}</td>";
                                                echo "<td>{$p_lname}</td>";
                                                echo "<td>{$p_position}</td>";
                                                echo "<td><img width='100' src='../img/players/{$p_image}'></img></td>";
                                                echo "<td>{$p_height}</td>";
                                                echo "<td>{$p_weight}</td>";
                                                echo "<td><a href='#' type='button' class='' data-toggle='modal' data-id='$p_id' data-target='#player_edit_modal' data-jersey='$p_jersey'  data-fname='$p_fname' data-lname='$p_lname' data-position='$p_position' data-height='$p_height' data-weight='$p_weight' >View</a></td>";
                                                echo "<td><a href='view_posts.php?delete={$p_id}'>Delete</a></td>";
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
                
                
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <div class="modal fade" id="player_edit_modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="display:inline;" class="display-3 text-primary modal-title" id="exampleModalLabel">View/Edit Player</h4>
                <button type="d-inline button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title" class="col-form-label">Jersey Number:</label>
                        <input type="text" class="form-control" id="player-jersey" name="player_jersey">
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-form-label">First Name:</label>
                        <input type="text" class="form-control" id="player-fname" name="player_fname">
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-form-label">Last Name:</label>
                        <input type="text" class="form-control" id="player-lname" name="player_lname">
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-form-label">Position:</label>
                        <input type="text" class="form-control" id="player-position" name="player_position">
                    </div>
                    <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title" class="col-form-label">Image:</label>
                                            <img src="" width="250" id="player-image" alt="">
                                            <!-- <input type="text" class="form-control" id="player-image" name="player_image"> -->
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="upload">
                                            <label for="title" class="col-form-label">Upload different image:</label>
                                                <div id="drop">
                                                    Drop Here

                                                    <a>Browse</a>
                                                    <input type="file" name="upl" />
                                                </div>

                                                <ul>
                                                    <!-- The file uploads will be shown here -->
                                                </ul> 
                                    </div></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="title" class="col-form-label">Height:</label>
                        <input type="text" class="form-control" id="player-height" name="player_height">
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-form-label">Weight:</label>
                        <input type="text" class="form-control" id="player-weight" name="player_weight">
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-form-label">Player Sypnosis:</label>
                        <textarea type="text" rows="8" class="form-control" id="player-sypnosis" name="cat_title"></textarea>
                    </div>
                    
                    <input style="display:none;" type="text" class="d-none" name="player_id" id="player-id">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="edit_title" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var linkElement = document.createElement("link");
    linkElement.rel = "stylesheet";
    linkElement.href = "image_uploader/assets/css/style.css"; //Replace here

    document.head.appendChild(linkElement);

</script>
<script src="js/players.js"></script>

<script src="image_uploader/assets/js/jquery.knob.js"></script>

<!-- jQuery File Upload Dependencies -->
<script src="image_uploader/assets/js/jquery.min.js"></script>
<script src="image_uploader/assets/js/jquery.ui.widget.js"></script>
<script src="image_uploader/assets/js/jquery.iframe-transport.js"></script>
<script src="image_uploader/assets/js/jquery.fileupload.js"></script>

<!-- file upload main JS file -->
<script src="image_uploader/assets/js/script.js"></script>

<script>
    // $("img").click(function(){
    //     $("form").submit();
    // })
</script>
<?php
    include "includes/footer.php";
?>
<?php }
else{
    header("Location: login.php");
}
?>