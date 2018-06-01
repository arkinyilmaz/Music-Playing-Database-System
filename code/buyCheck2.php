<?php
	include_once('server.php');
	include_once('song.php');
	session_start();
	
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	
	if( isset($_POST['addToPlayList']))
	{
		$name = $_POST['playlistName'];
	}
	
	$stitle = $_GET['stitle'];
	$idSong = $_GET['idSong'];
	$creator = $_SESSION['name'];
	
	$buycheckquery = "select * from buy 
					where buyer = '".$_SESSION['name']."'
					and bought_for = '".$_SESSION['name']."'
					and itemId = '$idSong'";
	
	$buyResult = mysqli_query($database, $buycheckquery);
	$num_rows = mysqli_num_rows( $buyResult );
	
	if($num_rows == 0){
	}
	
	else{
		$queryPlaylist = "insert into playlist_includes  values('$creator', '$name', '$idSong') "; // 0 indicates not private
		$resultOfQueryAddPlaylist = mysqli_query($database, $queryPlaylist);
		header('location: playlist.php?name='.$stitle.' & creator='.$creator);
	}
?>