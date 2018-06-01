<?php
	include_once('server.php');
	include_once('discover.php');
	session_start();
	
	if( isset($_POST['addToPlayList']))
	{
		$name = $_POST['playlistName'];
	}
	
	$stitle = $_GET['title'];
	$idSong = $_GET['idSong'];
	$creator = $_SESSION['name'];
	
	$buycheckquery = "select * from buy 
					where buyer = '".$_SESSION['name']."'
					and bought_for = '".$_SESSION['name']."'
					and itemId = '$idSong'";
	
	$buyResult = mysqli_query($database, $buycheckquery);
	$num_rows = mysqli_num_rows( $buyResult );
	
	if($num_rows == 0){
		echo '<script type="text/javascript">';
		echo'alert("You must buy the song first.");';
		echo 'window.location = "./discover.php";';
		echo '</script>';
	}
	
	else{
		$queryPlaylist = "insert into playlist_includes  values('$creator', '$name', '$idSong') "; // 0 indicates not private
		$resultOfQueryAddPlaylist = mysqli_query($database, $queryPlaylist);
		echo '<script type="text/javascript">';
		echo'alert("Added to playlist.");';
		echo 'window.location = "./discover.php";';
		echo '</script>';
	}
?>