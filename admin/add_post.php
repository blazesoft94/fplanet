<?php ob_start() ?>
<?php 
    include_once "../includes/db.php";
    include_once "includes/functions.php";
?>
<?php if(isset($_SESSION["login"]) && $_SESSION["role"]=="admin"){?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous"> -->

    <!-- Custom CSS -->
    <link href="css/admin-styles.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

     <!-- jQuery -->
     <script src="js/jquery.js"></script> 
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/plugins/simditor.css" />

    <!-- <script type="text/javascript" src="[script path]/jquery.min.js"></script> -->
    <script type="text/javascript" src="js/plugins/module.js"></script>
    <script type="text/javascript" src="js/plugins/hotkeys.js"></script>
    <script type="text/javascript" src="js/plugins/simditor.js"></script>
</head>
<?php 
    $post_added = FALSE;
    if(isset($_POST['post_submit'])){
        $post_title = $_POST["p_title"];
        $post_cat_id = $_POST["p_cat_id"];
        $post_author = $_POST["p_author"];
        $post_image = $_FILES["p_image"]['name'];
        $post_image_temp = $_FILES["p_image"]['tmp_name'];
        $post_tags = $_POST["p_tags"];
        $post_text = $_POST["p_text"];
        $post_date = date('Y-m-d');
        echo "$post_date";
        
        $sql = "INSERT into posts(post_cat_id,post_title,post_author,post_date,post_image,post_text,post_tags) values ('$post_cat_id','$post_title','$post_author','$post_date','$post_image','$post_text','$post_tags')";
        $con->query($sql);
        move_uploaded_file($post_image_temp,"../images/{$post_image}");
        $post_added = TRUE;
    }
    
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
                            <small class="muted">Add Post</small>
                        </h1>
                        <?php if($post_added){
                            echo "<div class='row'><h3 class='lead text-success'>Post added</h3></div>";
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-8 col-lg-6">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="form-group"><label for="p_title">Title</label><input name="p_title" type="text" class="form-control w-25 w-lg-50"></div>
                                    <div class="form-group">
                                        <label for="p_cat_id">Category</label>
                                        <select name="p_cat_id" class="form-control" >
                                            <?php
                                                $sql = "SELECT * from categories";
                                                $result = $con->query($sql);
                                                if($result->num_rows>0){
                                                    $count = 0;
                                                    $selected="";
                                                    while($row = $result->fetch_assoc()){
                                                        $cat_id = $row['cat_id'];
                                                        $cat_title = $row['cat_title'];
                                                        if($count==0){
                                                            $select = "selected";
                                                        }
                                                        else{
                                                            $select = "";
                                                        }
                                                        echo "<option value={$cat_id} {$select}>{$cat_title}</option>";
                                                        $count++;
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group"><label for="p_author">Author</label><input  name="p_author" type="text" class="form-control"></div>
                                    <div class="form-group"><label for="p_image">Image</label><input name="p_image" type="file" class="form-control-file"></div>
                                    <div class="form-group"><label for="p_tags">Tags</label><input name="p_tags" type="text" class="form-control"></div>
                                    <div class="form-group"><label for="p_text">Content</label><textarea id="editor" name="p_text" autofocus></textarea></div>
                                    <div class="form-group"><input name="post_submit" type="submit" class="btn btn-primary"></div>
                                    <!-- <div class="form-group"><label for=""></label><input type="text" class="form-control"></div> -->
                                </form>
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
    <!-- <div class="modal fade" id="cat_edit_modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 style="display:inline;" class="display-3 text-primary modal-title" id="exampleModalLabel">Edit Category</h4>
                    <button type="d-inline button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="categories.php" method="POST">
                    <div class="modal-body">
                        
                        <div class="form-group">
                            <label for="title" class="col-form-label">Title:</label>
                            <input type="text" class="form-control" id="cat_title" name="cat_title">
                        </div>
                        <input style="display:none;" type="text" class="d-none" name="cat_id" id="cat_id">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="edit_title" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div> -->
<?php
    include "includes/footer.php";
?>
<script>
    $(document).ready(function() {
        Simditor.locale = 'en-US';
        var editor = new Simditor({
        textarea: $('#editor')
        //optional options
        });
    });
</script>
<?php }
else{
    header("Location: ../index.php");
}
?>