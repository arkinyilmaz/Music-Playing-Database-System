<?php
	include_once('server.php'); 
	session_start();
	
		$unfollower = $_GET['unfollowername'];
		$unfollowed = $_GET['unfollowedname'];
	
		$unfQuery = "delete from follow_user where followed_id='$unfollowed' and follower_id='$unfollower'";   
		$resultOfUnf = mysqli_query($database, $unfQuery);
		header('location: following.php');
?>