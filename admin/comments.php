<?php
    include "includes/header.php";
?>
<?php if(isset($_SESSION["login"]) && $_SESSION["role"]=="admin"){?>
<?php 
//delete post
deleteComment();
changeCommentStatus();
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
                            <small class="muted">Comments</small>
                        </h1>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Post Title</th>
                                            <th>Author</th>
                                            <th>Email</th>
                                            <th>Content</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Approve/Unapprove</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        //Display Posts
                                        $sql = "SELECT * from comments,posts where comment_post_id = post_id ORDER BY comment_id desc";
                                        $result = $con->query($sql);
                                        if($result->num_rows>0){
                                            $count=0;
                                            while($row = $result->fetch_assoc()){
                                                $count++;
                                                $c_id = $row['comment_id'];
                                                $p_title = $row['post_title'];
                                                $c_text = $row['comment_text'];
                                                $c_email = $row["comment_email"];
                                                $c_author = $row['comment_author'];
                                                $c_status = $row['comment_status'];
                                                $c_date = $row['comment_date'];
                                                echo "<tr>";
                                                echo "<th scope='row'>{$count}</th>";
                                                echo "<td>{$p_title}</td>";
                                                echo "<td>{$c_author}</td>";
                                                echo "<td>{$c_email}</td>";
                                                echo "<td>{$c_text}</td>";
                                                echo "<td class=";
                                                if($c_status == "inactive"){
                                                    echo "'text-danger'";
                                                }
                                                else{
                                                    echo "'text-success'";
                                                }
                                                echo ">{$c_status}</td>";
                                                echo "<td>{$c_date}</td>";
                                                echo "<td><a href='comments.php?statusChange=";
                                                if($c_status == "inactive"){
                                                    echo "active&id={$c_id}' class='text-primary'>approve";
                                                }
                                                else{
                                                    echo "inactive&id={$c_id}'  class='text-danger'>unapprove";
                                                }
                                                echo "</a></td>";
                                                echo "<td><a href='comments.php?delete={$c_id}'>Delete</a></td>";
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
<?php }
else{
    header("Location: ../index.php");
}
?>