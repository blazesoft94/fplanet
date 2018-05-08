<?php
session_start();
include "includes/header.php";
?>
<?php if(isset($_SESSION["admin_login"]) && $_SESSION["role"]=="admin"){?>
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

if(isset($_GET["poll_delete"])){
        $u_id = $_GET["poll_delete"];
        $sql3 = "DELETE from polls where poll_id = '$u_id' ";
        $con->query($sql3);
        header("Location: polls.php");
}

if(isset($_POST["edit_poll"])){
    $id= $_POST["group_id"];
    $name = $_POST["group_name"];
    $about = $_POST["group_about"];
    $auto_added = $_POST["group_auto_added"];    
    $sql = "UPDATE `groups` SET `group_about` = '$about', `group_name` = '$name', `group_auto_added` = '$admin_restricted' WHERE `groups`.`group_id` = '$id';";
    $con->query($sql);
    header("Location: groups.php");
    
}
if(isset($_POST["add_poll"])){
    $group_id= $_POST["group_id"];
    $poll_text = $_POST["poll_text"];
    $total_options_added = (int)$_POST["total_options_added"];
    $options=[];
    for($i=1; $i<=$total_options_added; $i++){
        array_push($options, $_POST[("poll_option".$i)]);
    }

    $sql = "INSERT INTO `polls` (`poll_id`, `poll_group_id`, `poll_text`) VALUES (NULL, '$group_id', '$poll_text');";
    if($con->query($sql)==TRUE){
        $success = true;
        $poll_id = $con->insert_id;
        foreach($options as $opt){
            $sql = "INSERT INTO `poll_options` (`option_id`, `option_poll_id`, `option_text`) VALUES (NULL, '$poll_id', '$opt');";
            $con->query($sql);
        }
        // header("Location: groups.php");
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
                                <button class="btn btn-primary" data-toggle='modal' data-target='#add_poll_modal'>Add Poll</button>
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Id</th>
                                            <th>Poll text</th>
                                            <th>Poll Group</th>
                                            <th>Total Options</th>
                                            <!-- <th>View/Edit</th> -->
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        //Display Posts
                                        $sql = "SELECT * from polls,groups where poll_group_id = group_id  ORDER BY poll_id desc";
                                        $result = $con->query($sql);
                                        if($result->num_rows>0){
                                            $count=0;
                                            while($row = $result->fetch_assoc()){
                                                $count++;
                                                $p_id = $row["poll_id"];
                                                    $sql2 = "SELECT * from poll_options where option_poll_id = '$p_id'";
                                                    $result2 = $con->query($sql2);
                                                $p_total_options = $result2->num_rows;
                                                $p_name = $row['poll_text'];
                                                $p_group = $row['group_name'];
                                                echo "<tr>";
                                                echo "<th scope='row'>{$p_id}</th>";
                                                echo "<td>{$p_name}</td>";
                                                echo "<td>{$p_group}</td>";
                                                echo "<td>{$p_total_options}</td>";
                                                // echo "<td><a href='#' type='button' class='' data-toggle='modal' data-id='$p_id' data-target='#poll_edit_modal' >View</a></td>";
                                                echo "<td><a href='polls.php?poll_delete=$p_id'>Delete</a></td>";
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
                        <p style="background:#ccc;" type disbaled class="form-control" id="group-id">
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
<div class="modal fade" id="add_poll_modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="display:inline;" class="display-3 text-primary modal-title" id="exampleModalLabel">Add Poll</h4>
                <button type="d-inline button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title" class="col-form-label">PollId:</label>
                        <p style="background:#ccc;" type disbaled class="form-control" id="group-id-2">Auto Added</p>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-form-label">Group Name:</label>
                        <select class="form-control" name="group_id" id="">
                            <?php 
                                $group_query = "SELECT * FROM polls right join groups on poll_group_id = group_id where poll_id IS NULL and group_id != 1";
                                $group_result = $con->query($group_query);
                                if($group_result->num_rows>0){
                                    while($group_row = $group_result->fetch_assoc()){
                                        
                                ?>    
                                    <option value="<?php echo $group_row['group_id'] ?>"><?php echo $group_row['group_name'] ?></option>
                                <?php }}?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-form-label">Poll Question:</label><textarea cols="8" rows="3" type="text" class="form-control" id="group-about-2" name="poll_text"></textarea>
                        
                    </div>
                    <div id="options2">
                        <input type="text" name="total_options_added" style="display:none;" value="0" id="total-options-added2">
                    </div>
                    
                    
                    <div class="form-group">
                        <button id="add-option2" class="btn btn-warning">+ Add Option</button>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="add_poll" class="btn btn-primary">Save</button>
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
    $("#add-option2").click(function(e){
        e.preventDefault();
        var tOptions = parseInt($("#total-options-added2").val());
        tOptions+=1;
        $("#total-options-added2").val(tOptions);
        $("#options2").append('<div class="form-group"><label for="title" class="col-form-label">Option '+tOptions+':</label><textarea cols="8" rows="2" type="text" class="form-control" id="" name="poll_option'+tOptions+'"></textarea></div>');

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
