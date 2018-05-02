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

$sql = "USE " .$dbName;
if($con->query($sql) == TRUE){
    echo "Database selected <hr>";
}
else{
    echo "Database selection error<hr>";
}




// INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_image`, `user_type`, `user_password`) VALUES ('1811071', 'Abdul Rehman', '18-11071@formanite.fccollege.edu.pk', 'avatar1', 's', 'fplanet');
// INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_image`, `user_type`, `user_password`) VALUES ('1811070', 'Nehal Asif', '18-11070@formanite.fccollege.edu.pk', 'avatar2', 's', 'fplanet');
// INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_image`, `user_type`, `user_password`) VALUES ('1810847', 'Sohaib Asghar', '18-10847@formanite.fccollege.edu.pk', 'avatar3', 's', 'fplanet');
// INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_image`, `user_type`, `user_password`) VALUES ('1810672', 'Muzzamal Ahmad', '18-10672@formanite.fccollege.edu.pk', 'avatar4', 's', 'fplanet');
// INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_image`, `user_type`, `user_password`) VALUES ('1810648', 'Ziam Siddique', '18-10648@formanite.fccollege.edu.pk', 'avatar5', 's', 'fplanet');
// INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_image`, `user_type`, `user_password`) VALUES ('2011055', 'Alveena Malik', '20-11055@formanite.fccollege.edu.pk', 'avatar6', 's', 'fplanet');
// INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_image`, `user_type`, `user_password`) VALUES ('5510667', 'Sara Asif', 'saraasif@fccollege.edu.pk', 'avatar7', 't', 'fplanet');
// INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_image`, `user_type`, `user_password`) VALUES ('5510872', 'Nosheen Sabahat', 'nosheensabahat@gmail.com', 'avatar8', 't', 'fplanet');
// INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_image`, `user_type`, `user_password`) VALUES ('5511086', 'Atif Alvi', 'atifalvi@fccollege.edu.pk', 'avatar8', 't', 'fplanet');
// INSERT INTO `courses` (`course_id`, `course_code`, `course_section`, `course_teacher_id`, `course_session`, `course_about`, `course_year`, `course_name`) VALUES (NULL, 'cscs302', 'A', '5510667', 'Fall', 'An intro to the theory of Automata.
// Regular expressions, state machines and what not.', '2018', 'Theory of Automata'), (NULL, 'Cscs213', 'A', '5510872', 'Fall', 'A practical class of web application development.
// We''ll start with front-end then move towards back-end', '2018', 'Web Application Development');


// INSERT INTO `friends` (`friend_id`, `friend_first_id`, `friend_second_id`) VALUES (NULL, '1811071', '1810847'), (NULL, '1811071', '1810672'), (NULL, '1811071', '1810648'), (NULL, '1810672', '1810648');
// INSERT INTO `messages` (`message_id`, `message_sender_id`, `message_reciever_id`, `message_content`, `message_date`, `message_image`, `message_time`, `message_status`) VALUES (NULL, '1810672', '1811071', 'Hello, How are you?', '2018-03-28', NULL, '16:00:00', 'unread'), (NULL, '1810847', '1811071', 'Sup, boy', '2018-03-27', NULL, '20:24:38', 'unread'), (NULL, '1810847', '1811071', 'Hello, are you there?', '2018-03-28', NULL, '13:40:55', 'unread'), (NULL, '1811071', '1810672', 'Whats up homie?', '2018-03-26', NULL, '04:56:33', 'unread'), (NULL, '2011055', '1811071', 'Are you the same guy?', '2018-03-26', NULL, '08:25:05', 'read'), (NULL, '1811071', '2011055', 'No. What are you taking about', '2018-03-26', NULL, '09:11:12', 'unread'), (NULL, '1811071', '2011055', 'Oh, never mind! So whats going on these days? Are you having fun in the university?', '2018-03-27', NULL, '14:56:33', 'unread');
// INSERT INTO `notifications` (`notification_id`, `notification_reciever_id`, `notification_text`, `notification_date`, `notification_time`, `notification_status`, `notification_origin_id`) VALUES (NULL, '1811071', 'Sohaib Asghar liked your post', '2018-03-28', '14:18:27', 'unread', '2');
// INSERT INTO `posts` (`post_id`, `post_user_id`, `post_text`, `post_date`, `post_image`, `post_time`) VALUES (NULL, '1810672', 'I''m not sure if there should be class tomorrow.', '2018-03-27', NULL, '19:37:44');
// INSERT INTO `posts` (`post_id`, `post_user_id`, `post_text`, `post_date`, `post_image`, `post_time`) VALUES (NULL, '1811071', 'This is a nice graffiti', '2018-03-25', 'photo-item1', '04:19:14');
// INSERT INTO `post_comments` (`like_id`, `comment_post_id`, `comment_user_id`, `comment_text`, `comment_date`, `comment_time`) VALUES (NULL, '1', '1811071', 'Yes, I second that!', '2018-03-28', '13:07:13'), (NULL, '1', '1810847', 'You''re right about that.', '2018-03-28', '17:11:22'), (NULL, '2', '1810648', 'It''s beautiful', '2018-03-28', '16:22:56');
// INSERT INTO `post_likes` (`like_id`, `like_post_id`, `like_user_id`) VALUES (NULL, '1', '1811071'), (NULL, '2', '1811071'), (NULL, '1', '1810648'), (NULL, '1', '1810672'), (NULL, '1', '1811070'), (NULL, '2', '1810847'), (NULL, '2', '1810672');
// INSERT INTO `comment_likes` (`comment_like_id`, `comment_id`, `comment_like_user_id`) VALUES (NULL, '2', '2011055');
// INSERT INTO `comment_likes` (`comment_like_id`, `comment_id`, `comment_like_user_id`) VALUES (NULL, '3', '1811071'), (NULL, '1', '1811071');
// INSERT INTO `registrations` (`registration_id`, `registration_course_id`, `registration_student_id`) VALUES (NULL, '1', '1810648'), (NULL, '1', '1810672'), (NULL, '1', '1810847'), (NULL, '1', '1811070'), (NULL, '2', '1810648'), (NULL, '2', '1810672'), (NULL, '2', '1810847'), (NULL, '2', '1811070'), (NULL, '2', '1811071'), (NULL, '2', '2011055'), (NULL, '1', '1811071');
// UPDATE `users` SET `user_image` = 'avatar6' WHERE `users`.`user_id` = 1810648; UPDATE `users` SET `user_image` = 'avatar9' WHERE `users`.`user_id` = 1810847; UPDATE `users` SET `user_image` = 'avatar1' WHERE `users`.`user_id` = 1811070; UPDATE `users` SET `user_image` = 'avatar2' WHERE `users`.`user_id` = 1811071; UPDATE `users` SET `user_image` = 'avatar17' WHERE `users`.`user_id` = 2011055; UPDATE `users` SET `user_image` = 'avatar30' WHERE `users`.`user_id` = 5510667; UPDATE `users` SET `user_image` = 'avatar23' WHERE `users`.`user_id` = 5510872; UPDATE `users` SET `user_image` = 'avatar20' WHERE `users`.`user_id` = 5511086;
// ALTER TABLE `notifications` ADD `notification_sender_id` INT(7)
// ALTER TABLE `notifications` ADD FOREIGN KEY (notification_sender_id) REFERENCES users(user_id)
// ALTER TABLE `notifications` ADD `notification_location` INT(7) NOT NULL AFTER `notification_origin_id`;
// UPDATE `notifications` SET `notification_location` = '1' WHERE `notifications`.`notification_id` = 1; UPDATE `notifications` SET `notification_location` = '2' WHERE `notifications`.`notification_id` = 2;
//ALTER table notifications Add FOREIGN KEY (notification_location) REFERENCES posts(post_id)
