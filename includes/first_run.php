<?php 
$server = "localhost";
$username  = "root";
$password = "";
//   $url=parse_url(getenv("CLEARDB_DATABASE_URL"));
//   $server = $url["host"];
//   $username = $url["user"];
//   $password = $url["pass"];
$dbName = "fplanet";
$con = "";
//Connecting to db
$con = new mysqli($server, $username, $password);
if($con->connect_error){
    echo "connection error! <br>";
}

//Creating and selecting database 
$sql = "CREATE DATABASE " .$dbName;
if($con->query($sql) == TRUE){
    echo "Database created <hr>";
}
else{
    echo "Database creation error<hr/>";
}

$sql = "USE " .$dbName;
if($con->query($sql) == TRUE){
    echo "Database selected <hr>";
}
else{
    echo "Database selection error<hr>";
}


//TABLES


$sql = "CREATE table users (
    user_id INT(7) primary key,
    user_name varchar(255) NOT NULL,
    user_email varchar(255),
    user_image text,
    user_type varchar(1),
    user_password varchar (255)
)";

if($con->query($sql) == TRUE){
    echo "users table created<hr>";
}
else{
    echo "users table creation failed<hr>";
}

$sql = "CREATE table friends (
    friend_id INT(7) primary key AUTO_INCREMENT,
    friend_first_id int(7),
    friend_second_id int(7),
    FOREIGN KEY (friend_first_id) references users(user_id),
    FOREIGN KEY (friend_second_id) references users(user_id)
)";

if($con->query($sql) == TRUE){
    echo "friends table created<hr>";
}
else{
    echo "friends table creation failed<hr>";
}

$sql = "CREATE table friend_requests (
    request_id INT(7) primary key AUTO_INCREMENT,
    request_from_id int(7) NOT NULL,
    request_to_id int(7),
    foreign key (request_from_id) references users(user_id),
    foreign key (request_to_id) references users(user_id)
)";

if($con->query($sql) == TRUE){
    echo "friend requests table created<hr>";
}
else{
    echo "friend requests table creation failed<hr>";
}


//COURSES


$sql = "CREATE table courses (
    course_id INT(3) primary key AUTO_INCREMENT,
    course_code varchar(25),
    course_section varchar(255) NOT NULL,
    course_teacher_id int(7),
    course_session varchar(20),
    course_about text,
    course_year int(4),
    course_name varchar (255),
    FOREIGN KEY (course_teacher_id) references users(user_id)
)";

if($con->query($sql) == TRUE){
    echo "courses table created<hr>";
}
else{
    echo "courses table creation failed<hr>";
}



$sql = "CREATE table registrations (
    registration_id INT(5) primary key AUTO_INCREMENT,
    registration_course_id int(3),
    registration_student_id int(7),
    FOREIGN KEY (registration_course_id) references courses(course_id),
    FOREIGN KEY (registration_student_id) references users(user_id)
)";

if($con->query($sql) == TRUE){
    echo "registrations table created<hr>";
}
else{
    echo "registrations table creation failed<hr>";
}


//POST

$sql = "CREATE table posts (
    post_id INT(7) primary key AUTO_INCREMENT,
    post_user_id int(7),
    post_text text,
    post_date date,
    post_image text,
    post_time time,
    foreign key (post_user_id) references users(user_id)
)";

if($con->query($sql) == TRUE){
    echo "posts table created<hr>";
}
else{
    echo "posts table creation failed<hr>";
}


$sql = "CREATE table post_likes (
    like_id INT(7) primary key AUTO_INCREMENT,
    like_post_id int(7),
    like_user_id int(7),
    foreign key (like_user_id) references users(user_id),
    foreign key (like_post_id) references posts(post_id)
)";

if($con->query($sql) == TRUE){
    echo "post likes table created<hr>";
}
else{
    echo "post likes table creation failed<hr>";
}



$sql = "CREATE table post_comments (
    comment_id INT(7) primary key AUTO_INCREMENT,
    comment_post_id int(7),
    comment_user_id int(7),
    comment_text text,
    comment_date date,
    comment_time time,
    foreign key (comment_user_id) references users(user_id),
    foreign key (comment_post_id) references posts(post_id)
)";

if($con->query($sql) == TRUE){
    echo "post comments table created<hr>";
}
else{
    echo "post comments table creation failed<hr>";
}

$sql = "CREATE table comment_likes (
    comment_like_id INT(7) primary key AUTO_INCREMENT,
    comment_id int(7),
    comment_like_user_id int(7),
    foreign key (comment_like_user_id) references users(user_id),
    foreign key (comment_id) references post_comments(comment_id)
)";

if($con->query($sql) == TRUE){
    echo "post comment likes table created<hr>";
}
else{
    echo "post comment likes table creation failed<hr>";
}

//POLL

$sql = "CREATE table polls (
    poll_id INT(5) primary key AUTO_INCREMENT,
    poll_course_id int(5),
    poll_text text,
    FOREIGN KEY (poll_course_id) references courses(course_id)
)";

if($con->query($sql) == TRUE){
    echo "polls table created<hr>";
}
else{
    echo "polls table creation failed<hr>";
}



$sql = "CREATE table poll_options (
    option_id INT(5) primary key AUTO_INCREMENT,
    option_poll_id int(5),
    option_text varchar(255),
    FOREIGN KEY (option_poll_id) references polls(poll_id)
)";

if($con->query($sql) == TRUE){
    echo "poll options table created<hr>";
}
else{
    echo "poll options table creation failed<hr>";
}

$sql = "CREATE table poll_votes (
    vote_id INT(5) primary key AUTO_INCREMENT,
    vote_poll_id int(5),
    vote_user_id int(7),
    vote_option_id int(5),
    FOREIGN KEY (vote_poll_id) references polls(poll_id),
    FOREIGN KEY (vote_user_id) references users(user_id),
    FOREIGN KEY (vote_option_id) references poll_options(option_id)

)";

if($con->query($sql) == TRUE){
    echo "poll votes table created<hr>";
}
else{
    echo "poll votes table creation failed<hr>";
}



$sql = "CREATE table messages (
    message_id INT(5) primary key AUTO_INCREMENT,
    message_sender_id int(7),
    message_reciever_id int(7),
    message_content text,
    message_date date,
    message_image text,
    message_time time,
    message_status varchar(10) DEFAULT 'unread',
    FOREIGN KEY (message_sender_id) references users(user_id),
    FOREIGN KEY (message_reciever_id) references users(user_id)
)";

if($con->query($sql) == TRUE){
    echo "messages table created<hr>";
}
else{
    echo "messages table creation failed<hr>";
}

$sql = "CREATE table notifications (
    notification_id INT(5) primary key AUTO_INCREMENT,
    notification_reciever_id int(7),
    notification_text text,
    notification_date date,
    notification_time time,
    notification_status varchar(20) DEFAULT 'unread',
    notification_origin_id int(7),
    FOREIGN KEY (notification_reciever_id) references users(user_id),
    FOREIGN KEY (notification_origin_id) references courses(course_id)
)";

if($con->query($sql) == TRUE){
    echo "notifications table created<hr>";
}
else{
    echo "notifications table creation failed<hr>";
}


?>