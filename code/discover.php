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
            <li><a href="songs.php">Songs</a></li>
            <li><a href="albums.php">Albums</a></li>


        </ul>
     
        <ul class="nav navbar-nav navbar-right">
            <li><a href="overview.php?nameOther=<?php echo $_SESSION['name'];?>"><span class="glyphicon glyphicon-user"></span> </a></li>
            <li><a href="overview.php?logOut=<?php echo '1'?>"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
    </div>
</nav>
<div class="container">

    <h1>Popular Songs</h1>
    <br>
    <div class="dropdown">
        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Group By
            <span class="caret"></span>
		</button>
        <ul class="dropdown-menu">
		<form method="post">
            <li class="dropdown-header">Region</li>
            <li><button class="btn btn-primary" name="regionbutton" type="submit" value="world">Worldwide</button></li>
            <li><button class="btn btn-primary" name="regionbutton" type="submit" value="USA">USA</button></li>
            <li><button class="btn btn-primary" name="regionbutton" type="submit" value="UK">UK</button></li>
            <li class="divider"></li>
            <li class="dropdown-header">Type</li>
            <li><button class="btn btn-primary" name="typebutton" type="submit" value="punk">Punk</button></li>
            <li><button class="btn btn-primary" name="typebutton" type="submit" value="rock">Rock</button></li>
            <li><button class="btn btn-primary" name="typebutton" type="submit" value="pop">Pop</button></li>
            <li><button class="btn btn-primary" name="typebutton" type="submit" value="metal">Metal</button></li>
		</form>
        </ul>
    </div>

    <br>
    <form>
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Filter" name="filter">
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </div>
        </div>
    </form>



    <table class="table table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th>Artist / Band</th>
            <th>Album</th>

            <th><span class="glyphicon glyphicon-time"></span></th>
            <th></th>

        </tr>
        </thead>
        <tbody>
			<?php
					if( isset( $_POST['typebutton'])){
						$query = "SELECT COUNT(*) COUNT, itemID, I.name
								FROM buy, song S , items I
								WHERE itemID not in (SELECT ID
								FROM album  ) AND  itemID = S.ID AND S.ID = I.ID AND    
								type = '".$_POST['typebutton']."' 
								GROUP BY itemID
								ORDER BY COUNT DESC 
								LIMIT 10";   
						$resultOfQuery = mysqli_query($database, $query);
					}
					else if (isset( $_POST['regionbutton']) ){
						if($_POST['regionbutton'] == 'world' ){
							$query ="SELECT COUNT(*) COUNT, itemID, I.name
									FROM buy, song S , items I
									WHERE itemID not in (SELECT ID
									FROM album  ) AND  itemID = S.ID AND S.ID = I.ID 
									GROUP BY itemID
									ORDER BY COUNT DESC 
									LIMIT 100";
							$resultOfQuery = mysqli_query($database, $query);
						}
						else{
							$query = "SELECT COUNT(*) COUNT, itemID, I.name
							FROM buy, song S , items I
							WHERE itemID not in (SELECT ID
							FROM album  ) AND  itemID = S.ID AND S.ID = I.ID AND   
							region = '".$_POST['regionbutton']."' 
							GROUP BY itemID
							ORDER BY COUNT DESC 
							LIMIT 10";
							$resultOfQuery = mysqli_query($database, $query);
						}
					}
					while( $row = mysqli_fetch_assoc($resultOfQuery) )
					{ ?>
			<tr>
			<?php 
						$secondquery = "select
						  t.name as title,
						  D.name as artistname,
						  B.name as albumname,
						  t.duration,
						  t.price,
						  A.albumID as IDalbum,
						  t.ID as idSong
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
							  song S,
							  items I
							where
							  I.ID = S.ID 
						  ) t
						where
						  t.ID = A.songID
						  and B.ID = A.albumID
						  and C.songID = t.ID
						  and D.ID = C.artistID
						  and t.name = '".$row['name']."'";
				$resultOfSecondQuery = mysqli_query($database, $secondquery);
				$secondrow = mysqli_fetch_assoc($resultOfSecondQuery);
			?>
            <td><?php echo $row['name']; ?></td>
			<td><?php echo $secondrow['artistname']; ?></td>
			<td><?php echo $secondrow['albumname']; ?></td>
			<td><?php echo $secondrow['duration']; ?></td>
            <td><span class="glyphicon glyphicon-play-circle "></span></td>
            <td>
                <div class="dropdown">
                    <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

                    <ul class="dropdown-menu">
                        <li><a href="#">View Artist / Band</a></li>
                        <li><a href="album.php?nameAlbum=<?php echo $secondrow['albumname']?> & nameArtist=<?php echo $secondrow['artistname']?> & idAlbum=<?php echo $secondrow['IDalbum']?>">View Album</a></li>
                        <li><a href="#">Add to Playlist:</a></li>
								<li><form method = "post" action="buyCheck.php?stitle=<?php echo $row['name']?> & idSong=<?php echo $secondrow['idSong']?> & name=<?php echo $_POST['playlistName'] ?>"	
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