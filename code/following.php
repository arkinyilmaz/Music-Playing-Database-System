<?php

	include_once('server.php'); 
	session_start();

	$query = "select name,time from playlist where username='".$_SESSION['name']."'";   
	$resultOfQuery = mysqli_query($database, $query);
	
	if( isset($_GET['logOut'] ) ) 
	{
		header('location: logout.php');
	}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">HeyListen</a>
        </div>
        <ul class="nav navbar-nav">
            <li ><a href="mainPage.php">Main Page</a></li>
            <li >

                <a href="discover.php">Discover</a>
            </li>
            <li><a href="songs.php">Songs</a></li>
            <li><a href="albums.php">Albums</a></li>


        </ul>
   
        <ul class="nav navbar-nav navbar-right">
            <li ><a href="overview.php?nameOther=<?php echo $_SESSION['name'];?>"><span class="glyphicon glyphicon-user"></span> </a></li>
              <li><a href="overview.php?logOut=<?php echo '1'?>"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
    </div>
</nav>
<div class="container">

   
            <h1><?php echo $_SESSION['qname']; ?> </h1>
  
    <br>
  
    <br>
    <ul class="nav nav-tabs">
        <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/overview.php?nameOther=<?php echo $_SESSION['qname']?>">Overview</a></li>
        <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/playlists.php">Playlists</a></li>
        <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/groups.php">Groups</a></li>
        <li class="active"><a href="#">Following</a></li>
        <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/follower.php">Follower</a></li>
         <?php 
        if($_SESSION['type'] == 2){
         echo '<li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/musicianSong.php">Publish and View Songs</a></li>
        <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/musicianAlbum.php">Publish and View Albums</a></li>';
        }
        ?>
    </ul>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Username <span class="glyphicon glyphicon-user"></span></th>
            <th></th>

        </tr>
        </thead>
        <tbody>
		<?php
					$query = "select followed_id from follow_user where follower_id='".$_SESSION['name']."'";   
					$resultOfQuery = mysqli_query($database, $query);
					while( $row = mysqli_fetch_assoc($resultOfQuery) )
					{ ?>		
						<tr> 
							<td><?php echo $row['followed_id']; ?></td>
							<td>
							<div class="dropdown">
							<span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

								<ul class="dropdown-menu">
									<li><a href="unfollow.php?unfollowername=<?php echo $_SESSION['name']?>&unfollowedname=<?php echo $row['followed_id']?>">Unfollow <span class="glyphicon glyphicon-send "></span></a></li>
								</ul>
							</div>
							</td>
						</tr>
				<?php } ?>
	

        </tbody>
    </table>
</div>
</body>
</html>