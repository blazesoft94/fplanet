<!-- Window-popup-CHAT for responsive min-width: 768px -->
<?php include_once "includes/connect_db.php" ?>
<!-- <div class="ui-block popup-chat popup-chat-responsive"> -->
    <?php 
        $user_id = $_GET["user_id"];
        $friend_id = $_GET["friend_id"];
        // $user_image = "";
        // $friend_image = "";
        
        // $sql = "SELECT * from users where user_id = '$user_id'";
        // $result = $con->query($sql);
        // if($result->num_rows>0){
        //     while($row= $result->fetch_assoc()){
        //         $user_image = $row["user_image"];
        //     }
        // }

        // $sql = "SELECT * from users where user_id = '$friend_id'";
        // $result = $con->query($sql);
        // if($result->num_of_rows>0){
        //     while($row= $result->fetch_assoc()){
        //         $friend_image = $row["user_image"];
        //     }
        // }


        $sql = "SELECT * from messages m,users s where (s.user_id = message_sender_id ) and  ((message_sender_id = '$friend_id' and message_reciever_id = '$user_id' ) or (message_sender_id = '$user_id' and message_reciever_id = '$friend_id' ) )";
        $result = $con->query($sql);
        $c = 0;
        $time ="";
        $date="";
        $prev = null;
        if($result->num_rows>0){
            while($row= $result->fetch_assoc()){
                if($c==0){
                    if($row["message_sender_id"]==$user_id){
                        echo "<li></li>";
                    }
                }
                else if($prev){
                    if($prev["message_sender_id"]==$row["message_sender_id"]){
                        echo '<span class="chat-message-item">'.$row["message_content"].'</span>';
                        continue;
                    }
                    else{
                        echo '<span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">'.$date. " at ".$time.'</time></span>
                        </div>
                    </li>';
                    }
                }
                
                
                $c++;
                $prev = $row;
                $message=$row["message_content"];
                $time = $row["message_time"];
                $date = $row["message_date"];
                echo '<li>
                <div class="author-thumb">
                    <img src="img/'.$row["user_image"].'-sm.jpg" alt="author" class="mCS_img_loaded">
                </div>
                <div class="notification-event">
                    <span class="chat-message-item">'.$message.'</span>';


                // $curr = $result->fetch_assoc();
                // if($curr){
                //     if($curr["message_sender_id"]==$row["message_sender_id"]){
                        
                //     }
                // }
            }
            echo '<span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">'.$date. " at ".$time.'</time></span>
            </div>
        </li>';
            echo "<input style='display:none;' id='friend-id-input' type='text' value='$friend_id' name='friend_id' >";
            $last_msg = -1; //-1 means some error 1 means friends last message, 0 means the author
            if($prev["user_id"]==$user_id){
                $last_msg = 0;
            }
            else if($prev["user_id"]==$friend_id){
                $last_msg = 1;
            }
            
            echo "<input style='display:none;' id='last-message' type='text' value='$last_msg' name='last-message' >";
       
        }
         
    ?>
<!-- <li>
    <div class="author-thumb">
        <img src="img/avatar14-sm.jpg" alt="author" class="mCS_img_loaded">
    </div>
    <div class="notification-event">
        <span class="chat-message-item">Hi James! Please remember to buy the food for tomorrow! I’m gonna be handling the gifts and Jake’s gonna get the drinks</span>
        <span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">Yesterday at 8:10pm</time></span>
    </div>
</li> -->
<!-- </div> -->

<!-- ... end Window-popup-CHAT for responsive min-width: 768px -->
