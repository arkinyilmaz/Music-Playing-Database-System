<?php
	include_once('server.php'); 
	session_start();
	$_SESSION['pname'] = $_GET['name'];
	$queryLikePlaylist ="asdfasd";
	
	if( isset($_GET['logOut'] ) ) 
	{
		header('location: logout.php');
	}

	if( isset($_POST['setPrivacy']))
	{
		$queryUpdatePrivacy = "update playlist set isPrivate = '".$_POST['radio']."' where username = '".$_SESSION['name']."' and  name = '".$_GET['name']."'";
		$resultOfQueryDeletePlaylist = mysqli_query($database, $queryUpdatePrivacy);
		
	}
	
	if( isset ( $_GET['stitle']) && !isset ( $_GET['addP']) )
	{
		$queryRemoveSong = "delete from playlist_includes where name = '".$_SESSION['pname']."' and username = '".$_SESSION['name']."' and songID = '".$_GET['idSong']."'";
		
		$resultOfQueryDeletePlaylist = mysqli_query($database, $queryRemoveSong);
	}
	
	if(isset ($_POST['like_button']))
	{
		$queryLikePlaylist = "insert into follow_like_playlist values('".$_SESSION['name']."','".$_GET['creator']."','".$_GET['name']."', 2,CURRENT_TIMESTAMP())";


		$result = mysqli_query($database, $queryLikePlaylist);
		$str = "playlist.php?name=". $_GET['name']."& creator=".$_GET['creator'];
		#header('location: '.$str);

	}
	if(isset ($_POST['dislike_button']))
	{
		
		$queryLikePlaylist = "insert into follow_like_playlist values('".$_SESSION['name']."','".$_GET['creator']."','".$_GET['name']."', 1 ,CURRENT_TIMESTAMP())";


		$result = mysqli_query($database, $queryLikePlaylist);
		$str = "playlist.php?name=". $_GET['name']."& creator=".$_GET['creator'];
		#header('location: '.$str);
	}
	
	if(isset ($_GET['idArtist']))
	{
		$queryArtistBand = "select count(*) as count from band_member where bandID='".$_GET['idArtist']."'";
		$result = mysqli_query($database, $queryArtistBand);
		$count = mysqli_fetch_assoc($result);
		
		if($count['count'] > 0){
			header("location: band.php?name=".$_GET['nameArtist']."");
		}
		else{
			header("location: artist.php?name= ".$_GET['nameArtist']."");
		}
	}
		if(isset ($_POST['followButton']))
	{
				$queryFollowPlaylist = "insert into follow_like_playlist values('".$_SESSION['name']."','".$_GET['creator']."','".$_GET['name']."', 3,CURRENT_TIMESTAMP())";


		$result = mysqli_query($database, $queryFollowPlaylist);
	}
	if(isset ($_POST['unfollowButton']))
	{
				$queryUnfollowPlaylist = "delete from follow_like_playlist where userUsername= '".$_SESSION['name']."' and creatorUsername ='".$_GET['creator']."' and playlistName= '".$_GET['name']."' and type = 3";


		$result = mysqli_query($database, $queryUnfollowPlaylist);
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
            <li class="active"><a href="overview.php?nameOther=<?php echo $_SESSION['name'];?>"><span class="glyphicon glyphicon-user"></span> </a></li>
            <li><a href="overview.php?logOut=<?php echo '1'?>"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
    </div>
</nav>
<div class="container">

    <h1>Playlist: <?php echo $_SESSION['pname']; ?></h1>
    <br>
    <h2>Creator: <?php echo $_GET['creator']; ?></h2>

    <h4> Number of Followers: <font face="verdana" >  <?php  
   	 	$queryNumberOfFollowers = " select count(*) as count from follow_like_playlist where type = 3  and creatorUsername='".$_GET['creator']."' and playlistName= '".$_GET['name']."'";
    	$res = mysqli_query($database, $queryNumberOfFollowers); 
    	$row = mysqli_fetch_assoc($res); 
		echo $row['count'];

    ?>  

     </font> </h4>
    <form method="post">
      <div class="btn-group">
<button type="submit"  name = "followButton" class="btn btn-success">Follow <span class="glyphicon glyphicon-send "></span></button>
<button type="submit"  name = "unfollowButton" class="btn btn-warning">Unfollow <span class="glyphicon glyphicon-remove-circle "></span></button>
</div>
</form>
    <br>
		<div class="dropdown">
		<span class="glyphicon glyphicon-lock dropdown-toggle" data-toggle="dropdown">
			<font face="verdana" >  Make private</font>
		</span>
			<ul class="dropdown-menu">
			<li><form method="post" >
			<div class="container top7">
                    <label class="radio-inline"><input type="radio" name="radio" value = "1">Private</label>
                    <label class="radio-inline"><input type="radio" name="radio" value = "2">Public</label>
					<button class="btn" name = "setPrivacy" type="submit" >
						<i class="glyphicon glyphicon-user"></i>
					</button>
            </div>
			</form></li>
			</ul>
		</div>
    </br>
	<br>
	 <ul class="nav nav-tabs">
	 	<li class = "active"><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/playlist.php">View</a></li>
		<li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/comment.php?creator=<?php echo $_GET['creator']?> & pname=<?php echo $_SESSION['pname']?>"><span class="glyphicon glyphicon-comment"></span>Comment</a></li>
		<form method = "post"  >
			<button  type="submit"  name="like_button" class="glyphicon glyphicon-thumbs-up"> 
				<font face="verdana" color="green"> 
					<?php $queryLike = " select count(*) as count from follow_like_playlist where type = 2  and creatorUsername='".$_GET['creator']."' and playlistName= '".$_GET['name']."'"; 
					$res = mysqli_query($database, $queryLike); $row = mysqli_fetch_assoc($res); 
					echo $row['count']; ?>
				</font>
			</button>
	    	<button  type="submit"   name="dislike_button" class="glyphicon glyphicon-thumbs-down">
	    		<font face="verdana" color="green"> 
					<?php $queryLike =  " select count(*) as count from follow_like_playlist where type = 1  and creatorUsername='".$_GET['creator']."' and playlistName= '".$_GET['name']."'"; 
					$res = mysqli_query($database, $queryLike); $row = mysqli_fetch_assoc($res); 
					echo $row['count']; ?>
				</font>

	    	</button>
    	</form>
	</ul>
	
   
        <br>
    </br>


    <table class="table table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th>Artist / Band</th>
            <th>Album</th>
			

            <th><span class="glyphicon glyphicon-time"></span></th>
			<?php 
			echo $_SESSION['name'];
			echo $_SESSION['pname'];
			$queryPrivacy = "select isPrivate from playlist where username = '".$_SESSION['name']."' and name ='".$_SESSION['pname']."'";
			$resultOfPrivacy = mysqli_query($database, $queryPrivacy);
			$rowPrivacy = mysqli_fetch_assoc($resultOfPrivacy);
			
			?>
        </tr>
        </thead>
        <tbody>
			<?php
				$query = "select
						  t.name as title,
						  D.name as artistname,
						  B.name as albumname,
						  t.duration,
						  t.price,
						  t.ID as idSong,
						  A.albumID as IDalbum,
						  D.ID as artistid
						from
						  song_album A,
						  items B,
						  has_Song C,
						  artist D,
						  (
							select
							  I.name,
							  S.duration,
							  S.ID,
							  I.price
							from
							  playlist_includes P,
							  song S,
							  items I
							where
							  I.ID = S.ID
							  and P.songID = S.ID
							  and P.username = '".$_GET['creator']."'
							  and P.name = '".$_SESSION['pname']."' 
						  ) t
						where
						  t.ID = A.songID
						  and B.ID = A.albumID
						  and C.songID = t.ID
						  and D.ID = C.artistID";
				$resultOfQuery = mysqli_query($database, $query);
				while( $row = mysqli_fetch_assoc($resultOfQuery) )
				{ ?> 
					<tr> 
					<td><?php echo $row['title']; ?></td>
					<td><?php echo $row['artistname']; ?></td>
					<td><?php echo $row['albumname']; ?></td>
					<td><?php echo $row['duration']; ?></td>
					<td>
						<div class="dropdown">
							<span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

							<ul class="dropdown-menu">
								<li><a href="album.php?nameAlbum=<?php echo $row['albumname']?> & nameArtist=<?php echo $row['artistname']?> & idAlbum=<?php echo $row['IDalbum']?>">View Album</a></li>
								<li><a href="#">Add to Playlist:</a></li>
								<li> <form method = "post" action="addToPL.php?stitle=<?php echo $row['title']?> & idSong=<?php echo $row['idSong']?> & name=<?php echo $_POST['playlistName'] ?> & creator=<?php echo $_GET['creator'] ?>">
								
								<input type="text" class="form-control" placeholder="Enter Playlist Name:" name="playlistName"> </input> 
									<button type="submit" name = "addToPlayList" class="btn btn-primary" >
										<i class="glyphicon glyphicon-ok"></i>
									</button> 
								
								</form></li>
								<li><a href="playlist.php?stitle=<?php echo $row['title']?> & idSong=<?php echo $row['idSong']?> & name=<?php echo $_GET['name'] ?> & creator=<?php echo $_GET['creator'] ?>" class="btn" type = "submit" role = "button" name= "removeSong" >Remove <span class="glyphicon glyphicon-fire "></span>
								</a></li>
								<li><a href="overview.php?stitle=<?php echo $row['title']?> & idSong=<?php echo $row['idSong']?> & name=<?php echo $_GET['name'] ?> & creator=<?php echo $_GET['creator'] ?>">Share <span class="glyphicon glyphicon-share "></span></a> </li>
								<li><a href="#">Share in Group <span class="glyphicon glyphicon-share "></span></a> </li>
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