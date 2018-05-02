<?php

function get_words($sentence, $count = 10) {
    // preg_match("/(?:\w+(?:\W+|$)){0,$count}/", $sentence, $matches);
    // return $matches[0];
    return implode(' ', array_slice(explode(' ', preg_replace('#<[^>]+>#', ' ', $sentence)), 0, $count));
  }

function addCategory(){
    global $con;
    if(isset($_POST["submit"])){
        $cat_title = myValidator($_POST['cat_title']);
        if($cat_title == "" || empty($cat_title)){
            echo "<div><p class='text-danger'>* The input field must not be empty</p></div>";
        }
        else{
            $sql = "INSERT into categories (cat_title) values ('$cat_title')";
            $con->query($sql);
        }
    }
}

function editCategory(){
    global $con;
    if(isset($_POST["edit_title"])){
        $cat_title = $_POST["cat_title"];
        $cat_id = $_POST["cat_id"];
        $sql = "UPDATE categories set cat_title = '{$cat_title}' WHERE cat_id = $cat_id";
        $con->query($sql);
    }
}

function deleteCategory(){
    global $con;
    if(isset($_GET['delete'])){
        $cat_id = $_GET['delete'];
        $sql = "DELETE FROM categories WHERE cat_id = {$cat_id}";
        $con->query($sql);
        header("Location: categories.php");
    }
}

function displayCategory(){
    global $con;
    $sql = "SELECT * from categories";
    $result = $con->query($sql);
    if($result->num_rows>0){
        $count =0;
        while($row = $result->fetch_assoc()){
            $count++;
            $cat_title = $row['cat_title'];
            $cat_id = $row['cat_id'];
            echo "<tr><th scope='row'>$count</th><td>$cat_title</td>";
            echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
            echo '<td><a href="#" type="button" class="" data-toggle="modal" data-id="' .$cat_id .'"data-target="#cat_edit_modal" data-title="' .$cat_title .'">Edit</a></td></tr>';
        }
    }
}

function deletePost(){
    global $con;
    if(isset($_GET['delete'])){
        $post_id = $_GET['delete'];
        $sql = "DELETE FROM posts WHERE post_id = {$post_id}";
        $con->query($sql);
        header("Location: view_posts.php");
    }
}
function deleteComment(){
    global $con;
    if(isset($_GET['delete'])){
        $c_id = $_GET['delete'];
        $sql = "DELETE FROM comments WHERE comment_id = {$c_id}";
        $con->query($sql);
        header("Location: comments.php");
    }
}
function changeCommentStatus(){
    global $con;
    if(isset($_GET['statusChange'])){
        $c_id = $_GET["id"];
        $c_status = $_GET['statusChange'];
        $sql = "UPDATE comments set comment_status = '{$c_status}' WHERE comment_id = $c_id";
        $con->query($sql);
        // header("Location: comments.php");
    }
}

function addComment(){
    global $con;
    if(isset($_POST["submit"])){
        $c_author = myValidator($_POST['author']);
        $c_email = myValidator($_POST['email']);
        $c_text = myValidator($_POST['content']);
        if($c_author == "" || empty($c_author)){
            echo "<script> alert('The name must not be empty');</script>";
        }
        elseif($c_email == "" || empty($c_email)){
            echo "<script> alert('The email must not be empty');</script>";
        }
        elseif($c_text == "" || empty($c_text)){
            echo "<script> alert('Commenting without a comment? Nice try!');</script>";
        }
        else{
            $c_post_id = $_POST['post_id'];
            $c_date = date('Y-m-d');
            $c_time = date("H:i:s");
            $sql = "INSERT into comments (comment_post_id,comment_author,comment_email,comment_text,comment_date,comment_time,comment_status) values ('$c_post_id','$c_author','$c_email','$c_text','$c_date','$c_time','inactive')";
            $con->query($sql);
            $link = $_POST["link"];
            header("Location: $link");
        }
    }
}

function displayComments(){
    global $con;
    $p_id = $_GET["post_id"];
    $sql = "SELECT * from comments where comment_post_id = $p_id and comment_status = 'active' order by comment_id desc";
    $result = $con->query($sql);
    if($result->num_rows>0){
        while($row = $result->fetch_assoc()){
            $c_author = $row['comment_author'];
            $c_text = $row['comment_text'];
            $c_date = $row['comment_date'];
            $c_time = $row["comment_time"];
            $c_email = $row["comment_email"];
            // $c_time = date("h:i:sa",$c_time);
            echo "<div class='media'><div class='media-body'><h4 class='media-heading lead'><u><a href='mailto:$c_email'>$c_author</a></u> <small> $c_date at $c_time </small></h4><blockquote><p>$c_text</p></blockquote></div></div> ";
        }
    }
}

function deleteUser(){
    global $con;
    if(isset($_GET['delete'])){
        $u_id = $_GET['delete'];
        $sql = "DELETE FROM users WHERE user_id = {$u_id}";
        $con->query($sql);
        header("Location: users.php");
    }
}
function editUser(){
    global $con;
    if(isset($_POST["edit_user"])){
        $user_role = $_POST["user_role"];
        echo "<br>user role is $user_role<br><br>";
        $user_id = $_POST["user_id"];
        $sql = "UPDATE users set user_role = '{$user_role}' WHERE user_id = $user_id";
        $con->query($sql);
    }
}
function signIn(){
    global $con;
    if(isset($_POST["signin"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $sql = "SELECT * from users where user_username = '$username' and user_password = '$password'";
        $result = $con->query($sql);
        if($result->num_rows>0){
            $row = $result->fetch_assoc();
            $_SESSION["role"] = $row["user_role"];
            $_SESSION["username"]= $row["user_username"];
            $_SESSION["login"] = true;
            $_SESSION["user_id"] = $row["user_id"];
            header("Location: index.php");
        }
    }
}

?>
