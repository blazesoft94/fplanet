<?php 
ob_start();
session_start();
    include_once "../includes/connect_db.php";
    if(isset($_SESSION["admin_login"])){
        if($_SESSION["admin_login"] == true){
            header("Location: index.php");
        }
    }
    $incorrect = false;
    if(isset($_POST["login"])){
        $uname = $_POST["uname"];
        $pass = $_POST["pass"];
        $stmt = $con->prepare("select * from users where user_name = ? and user_password = ? and user_type='admin'");
        $stmt->bind_param('ss', $uname,$pass);
        // $stmt->bind_param('s', $pass);
        
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows>0){
            // echo "MATCHEDDDDD";
            $_SESSION["admin_login"] = true;
            $_SESSION["role"] = "admin";
            header("Location: index.php");
        }
        else{
            $incorrect = true;
        }
    }
// session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.js"></script>
    <title>Admin Login</title>
</head>
<body>
<div class="container" style="margin:0 auto!important;">
<div class="row" style="margin-top:50px;">

</div>
<div class="row">
    <div class="col-md-3"></div>
   <div class="col-md-6">
   <div class="panel with-nav-tabs panel-info">
      <div class="panel-heading">
         <ul class="nav nav-tabs">
            <li class="active"><a href="#login" data-toggle="tab"> Login </a></li>
         </ul>
      </div>

      <div class="panel-body">
         <div class="tab-content">
            <div id="login" class="tab-pane fade in active register">
               <div class="container-fluid">
                  <div class="row">
                        <h2 class="text-center" style="color: #5cb85c;"> <strong> FHBasketball | Admin Login </strong></h2><hr />
                        <?php echo ($incorrect) ? '<p class="text-danger">*Your username or password is wrong</p>':"" ?>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <div class="row">
                           <div class="col-xs-12 col-sm-12 col-md-12">
                              <div class="form-group">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <span class="glyphicon glyphicon-user"></span>
                                    </div>
                                    <input type="text" placeholder="User Name" name="uname" class="form-control">
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-xs-12 col-sm-12 col-md-12">
                              <div class="form-group">
                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <span class="glyphicon glyphicon-lock"></span>
                                    </div>

                                    <input type="password" placeholder="Password" name="pass" class="form-control">
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                           <div class="col-xs-6 col-sm-6 col-md-6">
                              <div class="form-group">
                                 <input type="checkbox" name="check" checked> Remember Me
                              </div>
                           </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                              <div class="form-group">
                                 <a href="#forgot" data-toggle="modal"> Forgot Password? </a>
                              </div>
                           </div>
                        </div> -->
                        <hr />
                        <div class="row">
                           <div class="col-xs-12 col-sm-12 col-md-12">
                              <button type="submit" name="login" class="btn btn-success btn-block btn-lg"> Login </button>
                           </div>
                        </div>
</form>
                  </div>
               </div> 
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-3"></div>
   
</div>
</div>
</div>


<div class="modal fade" id="forgot">
<div class="modal-dialog">
   <div class="modal-content">
      <div class="modal-header">
         <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
         <h4 class="modal-title" style="font-size: 32px; padding: 12px;"> Recover Your Password </h4>
      </div>

      <div class="modal-body">
         <div class="container-fluid">
            <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                     <div class="input-group">
                        <div class="input-group-addon iga2">
                           <span class="glyphicon glyphicon-envelope"></span>
                        </div>
                        <input type="email" class="form-control" placeholder="Enter Your E-Mail ID" name="email">
                     </div>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                     <div class="input-group">
                        <div class="input-group-addon iga2">
                           <span class="glyphicon glyphicon-lock"></span>
                        </div>
                        <input type="password" class="form-control" placeholder="Enter Your New Password" name="newpwd">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="modal-footer">
         <div class="form-group">
            <button type="submit" class="btn btn-lg btn-info"> Save <span class="glyphicon glyphicon-saved"></span></button>

            <button type="button" data-dismiss="modal" class="btn btn-lg btn-default"> Cancel <span class="glyphicon glyphicon-remove"></span></button>
         </div>
      </div>
   </div>
</div>
</div>
<script>
    $(document).ready(function(){
        
    });

</script>
</body>
</html>