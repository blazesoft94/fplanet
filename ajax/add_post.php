<?php
session_start();
    $post_text = $_GET["post_text"];
    $user_id = $_SESSION["id"];
    $group_id = $_GET["group_id"];

    $sql = "INSERT INTO `posts` (`post_id`, `post_user_id`, `post_group_id`, `$post_text`, `post_date`, `post_image`, `post_time`) VALUES (NULL, '$id', '$group_id', 'Hello how are you', '2018-04-18', NULL, '08:00:00');"

?>