<?php
session_start();
    include "includes/header.php";
?>
<?php if(isset($_SESSION["login"]) && $_SESSION["role"]=="admin"){?>
<?php 
//delete category
    deleteCategory();
    editCategory();
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
                            <div class="col-md-4">
                                <?php //Add category
                                    addCategory(); 
                                ?>
                                <form action="" method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="cat_title">
                                    </div>
                                    <div class="form-group">
                                        <input class="btn btn-primary" type="submit" name="submit" value="Add category">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Delete</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        //Display all categories
                                        displayCategory();
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
    <div class="modal fade" id="cat_edit_modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
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
    </div>
<?php
    include "includes/footer.php";
?>
<script src="js/categories.js"></script>
<?php }
else{
    header("Location: ../index.php");
}
?>