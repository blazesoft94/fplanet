<?php
session_start();
include "includes/header.php";
?>
<?php if(isset($_SESSION["login"]) && $_SESSION["role"]=="admin"){?>
<?php 

if(isset($_GET["user_delete"])){
    if($_GET["user_delete"]){
        $u_id = $_GET["user_id"];
        $g_id = $_GET["group_id"];
        $sql3 = "DELETE from registrations where (registration_user_id = '$u_id' and registration_group_id = '$g_id')";
        $con->query($sql3);
        header("Location: groups.php");
    
    }
}

if(isset($_POST["edit_title"])){
    $id= $_POST["group_id"];
    $name = $_POST["group_name"];
    $about = $_POST["group_about"];
    $auto_added = $_POST["group_auto_added"];    
    $sql = "UPDATE `groups` SET `group_about` = '$about', `group_name` = '$name', `group_auto_added` = '$admin_restricted' WHERE `groups`.`group_id` = '$id';";
    $con->query($sql);
    header("Location: groups.php");
    
}
if(isset($_POST["add_group"])){
    // $id= $_POST["group_id"];
    $name = $_POST["group_name-2"];
    $about = $_POST["group_about-2"];
    $auto_added = $_POST["group_auto_added"];
    $group_type = $_POST["group_type"];
    $admin_restricted = $_POST["group_admin_restricted"];
    $sql = "INSERT INTO `groups` (`group_id`, `group_about`, `group_name`,`group_type`,`group_auto_added`,`group_admin_restricted`) VALUES (NULL, '$name', '$about','$group_type','$auto_added','$admin_restricted');";
    if($con->query($sql)==TRUE){
        header("Location: groups.php");
    }
    
}
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
                                <button class="btn btn-primary" data-toggle='modal' data-target='#add_group_modal'>Add Group</button>
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Id</th>
                                            <th>Group Name</th>
                                            <th>Group About</th>
                                            <th>Total users</th>
                                            <th>View/Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        //Display Posts
                                        $sql = "SELECT * from groups ORDER BY group_id desc";
                                        $result = $con->query($sql);
                                        if($result->num_rows>0){
                                            $count=0;
                                            while($row = $result->fetch_assoc()){
                                                $count++;
                                                $p_id = $row["group_id"];
                                                    $sql2 = "SELECT * from registrations where registration_group_id = '$p_id'";
                                                    $result2 = $con->query($sql2);
                                                $p_users = $result2->num_rows;
                                                $p_name = $row['group_name'];
                                                $p_about = $row['group_about'];
                                                echo "<tr>";
                                                echo "<th scope='row'>{$p_id}</th>";
                                                echo "<td>{$p_name}</td>";
                                                echo "<td>{$p_about}</td>";
                                                echo "<td><a href='#' class='view-users-group' data-toggle='modal' data-target='#user_group_modal' data-groupid='$p_id'> {$p_users}</a></td>";
                                                echo "<td><a href='#' type='button' class='' data-toggle='modal' data-id='$p_id' data-target='#player_edit_modal' data-name='$p_name'  data-about='$p_about' >View</a></td>";
                                                echo "<td><a href='delete_group.php?group_id=$p_id'>Delete</a></td>";
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
                <h4 style="display:inline;" class="display-3 text-primary modal-title" id="exampleModalLabel">View/Edit Group</h4>
                <button type="d-inline button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title" class="col-form-label">Group Id:</label>
                        <p style="background:#ccc;x" type disbaled class="form-control" id="group-id">
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-form-label">Group Name:</label>
                        <input type="text" class="form-control" id="group-name" name="group_name">
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-form-label">Group About:</label>
                        <input type="text" class="form-control" id="group-about" name="group_about">
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-form-label">User Auto Added:</label>
                        <select type="text" class="form-control" id="group-auto-added" name="group_auto_added">
                                <option id="first-auto-added" value=""></option>
                                <option id="second-auto-added" value=""></option>
                        </select>
                    </div>
                    
                    <input style="display:none;" type="text" class="d-none" name="group_id" id="group_id">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="edit_title" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="add_group_modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="display:inline;" class="display-3 text-primary modal-title" id="exampleModalLabel">Add Group</h4>
                <button type="d-inline button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title" class="col-form-label">Group Id:</label>
                        <p style="background:#ccc;x" type disbaled class="form-control" id="group-id-2">Auto Added</p>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-form-label">Group Name:</label>
                        <input type="text" class="form-control" id="group-name-2" name="group_name-2">
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-form-label">Group About:</label>
                        <input type="text" class="form-control" id="group-about-2" name="group_about-2">
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-form-label">User Auto Added:</label>
                        <select type="text" class="form-control" id="group-auto-added2" name="group_auto_added">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-form-label">Only Admin Can Post</label>
                        <select class="form-control" id="group-admin-restricted" name="group_admin_restricted">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-form-label">Group Type:</label>
                        <select type="text" class="form-control" id="group-type" name="group_type">
                                <option value="Major">Major</option>
                                <option value="Society">Society</option>
                                <option value="General">General</option>
                        </select>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="add_group" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="user_group_modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="display:inline;" class="display-3 text-primary modal-title" id="exampleModalLabel">View Users</h4>
                <button type="d-inline button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div id="user-group-modal-body" class="modal-body">
                   
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="user_group" class="btn btn-primary">Save</button>
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
<script src="js/groups.js"></script>

<script src="image_uploader/assets/js/jquery.knob.js"></script>

<!-- jQuery File Upload Dependencies -->
<script src="image_uploader/assets/js/jquery.min.js"></script>
<script src="image_uploader/assets/js/jquery.ui.widget.js"></script>
<script src="image_uploader/assets/js/jquery.iframe-transport.js"></script>
<script src="image_uploader/assets/js/jquery.fileupload.js"></script>

<!-- file upload main JS file -->
<script src="image_uploader/assets/js/script.js"></script>
<script>
    $(".view-users-group").click(function(){
        $("#user-group-modal-body").text("");
        var groupId = $(this).data("groupid");
        $.ajax({
            url: "ajax/group_users.php?group_id="+groupId,
            method : "get",
            success: function(data){
                $("#user-group-modal-body").append(data);
            },
            error: function(e){
                console.log("error",e);
            }
        })
    });

</script>

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
