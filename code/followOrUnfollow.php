<?php
	include_once('server.php'); 
	session_start();
	include_once('follower.php');
	
	$follower = $_GET['followername'];
	$followed = $_GET['followedname'];
	
	if($numberOfRows == 1){
		//unfollow
		$unfQuery = "delete from follow_user where followed_id='$followed' and follower_id='$follower'";   
		$resultOfUnf = mysqli_query($database, $unfQuery);
		header('location: follower.php');
	}
	else{
		//follow
		$followQuery = "insert into follow_user values('$follower','$followed', CURRENT_TIMESTAMP())";   
		$resultOfFollow = mysqli_query($database, $followQuery);
		//echo $followQuery;
		header('location: follower.php');
	}
	

?>