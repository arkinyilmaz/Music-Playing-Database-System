<?php
	include_once('server.php');
	session_start();
	
	$queryDeleteGroup = "delete from groups where admin = '".$_GET['deletor']."' and admin = '".$_GET['groupadmin']."' and name = '".$_GET['groupname']."'";	
	$resultOfQueryDeleteGroup = mysqli_query($database, $queryDeleteGroup);
	$count = mysqli_affected_rows($database);
	if( $count == 0){
		echo '<script type="text/javascript">';
		echo'alert("Only admin can delete the group");';
		echo 'window.location = "./groups.php";';
		echo '</script>';
	}
	else
		header('location: groups.php');
?>