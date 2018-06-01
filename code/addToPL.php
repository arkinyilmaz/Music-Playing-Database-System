<?php
ob_start();
	include_once('server.php');
	include_once('playlist.php');
	session_start();
	
	if( isset($_POST['addToPlayList']))
	{
		$name = $_POST['playlistName'];
	}
	
	$stitle = $_GET['stitle'];
	$idSong = $_GET['idSong'];
	//$name = $_GET['playlistName'];
	$creator = $_GET['creator'];
	
	$queryPlaylist = "insert into playlist_includes  values('$creator', '$name', '$idSong') "; // 0 indicates not private
	$resultOfQueryAddPlaylist = mysqli_query($database, $queryPlaylist);
	//echo $queryPlaylist;

        header('location: playlists.php');
        ob_end_flush();
        exit();
	echo'<h2>'.$queryPlaylist.'';
?>