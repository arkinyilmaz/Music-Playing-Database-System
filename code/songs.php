<?php
	include_once('server.php'); 
	session_start();

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
            <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/songs.php">Songs</a></li>
            <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/albums.php">Albums</a></li>
          


        </ul>
        
        <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="overview.php?nameOther=<?php echo $_SESSION['name'];?>"><span class="glyphicon glyphicon-user"></span> </a></li>
            <li><a href="overview.php?logOut=<?php echo '1'?>"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
    </div>
</nav>
<div class="container">

    <h1>Your Music Library</h1>
    <br>
    
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th>Artist / Band</th>
            <th>Album</th>
            <th><span class="glyphicon glyphicon-time"></span></th>

        </tr>
        </thead>
        <tbody>
		<?php
			$querySongs = "select
			  t.name as title,
			  D.name as artistname,
			  B.name as albumname,
			  t.duration as duration,
			  t.ID as idSong,
			  A.albumID as IDalbum
			from
			  song_album A,
			  items B,
			  has_Song C,
			  artist D,
			  (
				select
				  I.name,
				I.ID,
				  S.duration
				from
				  buy B,
				  song S,
				  items I
				where
				  B.buyer = '".$_SESSION['name']."'
				  and B.bought_for = '".$_SESSION['name']."'
				  and B.itemID = I.ID
				  and S.ID = I.ID
			  ) t
			where
			  t.ID = A.songID
			  and B.ID = A.albumID
			  and C.songID = t.ID
			  and D.ID = C.artistID
			";   
			$resultOfQuerySongs = mysqli_query($database, $querySongs);
			while( $row = mysqli_fetch_assoc($resultOfQuerySongs) )
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
                    <li><a href="song.php?nameOfSong=<?php echo $row['title']?> & IDofSong=<?php echo $row['idSong']?>">View Song</a></li>
                    <li><a href="#">Add to Playlist:</a></li>
					<li><form method = "post" action="addToPL.php?stitle=<?php echo $row['title']?> & idSong=<?php echo $row['idSong']?> & name=<?php echo $_POST['playlistName'] ?> & creator=<?php echo $_SESSION['name'] ?>">
					
					<li><input type="text" class="form-control" placeholder="Enter Playlist Name:" name="playlistName"> </input> </li>
						<li> <button type="submit" name = "addToPlayList" class="btn btn-primary" >
							<i class="glyphicon glyphicon-ok"></i>
						</button> </li>
					
					</form></li>
                    <li><a href="#">Share <span class="glyphicon glyphicon-share "></span></a> </li>
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