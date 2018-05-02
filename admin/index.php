<?php 
ob_start();
session_start(); ?>
<?php
    include "includes/header.php";
// $_SESSION["login"]=true;
// $_SESSION["role"]=="admin";
//
?>
<?php if(isset($_SESSION["admin_login"]) && $_SESSION["role"]=="admin"){?>
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
                            <small class="muted">Dashboard</small>
                        </h1>
                        
                        <!-- <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol> -->
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->

</body>

</html>
<?php }
else{
    header("Location: login.php");
}
?>