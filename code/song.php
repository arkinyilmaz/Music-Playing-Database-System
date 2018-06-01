<?php
	include_once('server.php'); 
	session_start();
	
	if( isset($_GET['logOut'] ) ) 
    {
        header('location: logout.php');
    }

	if( isset( $_POST['Listen']) )
	{
		//update listen count of the song
		$queryUpdate = "update song set listenCount= listenCount + 1 where ID='".$_GET['IDofSong']."'";
		$resultOfQueryUpdate = mysqli_query($database, $queryUpdate);
	}
	
	//echo $_SESSION['name'];
	
	if(isset ($_POST['like_button']))
	{
		$queryLikePlaylist = "insert into like_item values('".$_SESSION['name']."','".$_GET['IDofSong']."',CURRENT_TIMESTAMP(), 2)";
		$result = mysqli_query($database, $queryLikePlaylist);

	}
	if(isset ($_POST['dislike_button']))
	{
		$queryLikePlaylist = "insert into like_item values('".$_SESSION['name']."','".$_GET['IDofSong']."',CURRENT_TIMESTAMP(), 1)";
		$result = mysqli_query($database, $queryLikePlaylist);
	}
	if( isset( $_POST['buySong']) )
	{
		//echo "BUY";
		//echo $_GET['IDofSong'];
		$queryID = "select  I.ID as ID ,I.price as price 
					from
					items I
					where
					'".$_GET['IDofSong']."' = I.ID";
						  
		$resultOfQueryID = mysqli_query($database, $queryID);
		while( $rowID = mysqli_fetch_assoc($resultOfQueryID))
		{
			$price = $rowID['price'];
		}			
		//echo $price;
		
		if($resultOfQueryID)
		{
			$budgetOfUser = "select budget from user where username='".$_SESSION['name']."'";
			$resultOfBudget = mysqli_query($database, $budgetOfUser);
			$resultRow = mysqli_fetch_assoc($resultOfBudget);
			echo $resultRow['budget'];
			
			$try = $resultRow['budget'] - $price;
			if( $try < 0  )
			{
				$warningBudget = "You do not have enough budget!";
				echo $warningBudget;
			}
			else{
				
				$queryBuy = "insert into buy values ('".$_SESSION['name']."', '".$_GET['IDofSong']."', CURRENT_TIMESTAMP(), '".$_SESSION['name']."' )";
				$resultOfQueryBuy = mysqli_query($database, $queryBuy);
				$resultRowBuy = mysqli_fetch_assoc($resultOfQueryBuy);
				
				$rowcount = mysqli_num_rows($resultRowBuy);
				if($resultOfQueryBuy)
				{
					$queryDecrementPrice = "update user set budget = budget - '$price' where username = '".$_SESSION['name']."'";
					$resultOfQuery3 = mysqli_query($database, $queryDecrementPrice);	
				}
				else
				{
					$warningBuyEarlier = "You bought it earlier!";
					echo $warningBuyEarlier;
				}	
				
			}
		}
	    
		
		
		
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

    <h1><?php echo $_GET['nameOfSong'];?></h1>
	<br>
		<form method = "post" >
		<div class="input-group">
			<div class="input-group-btn">
				<button name="Listen" class="btn btn-default" type="submit">
					<i class="glyphicon glyphicon-play"></i>
				</button>
			</div>
		</div>
		</form>
		<form method = "post"  >
			<button  type="submit"  name="like_button" class="glyphicon glyphicon-thumbs-up"> 
				<font face="verdana" color="green"> 
					<?php $queryLike = " select count(*) as count from like_item where type = 2 and itemID='".$_GET['IDofSong']."'"; 
					$res = mysqli_query($database, $queryLike); $row = mysqli_fetch_assoc($res); 
					echo $row['count']; ?>
				</font>
			</button>
	    	<button  type="submit"   name="dislike_button" class="glyphicon glyphicon-thumbs-down">
	    		<font face="verdana" color="green"> 
					<?php $queryLike =  "select count(*) as count from like_item where type = 1 and itemID='".$_GET['IDofSong']."'";
					$res = mysqli_query($database, $queryLike); $row = mysqli_fetch_assoc($res); 
					echo $row['count']; ?>
				</font>

	    	</button>
    	</form>
		<?php $queryTitle = " select name as title from items where ID='".$_GET['IDofSong']."'"; 
				$resultTitle = mysqli_query($database, $queryTitle); 
				$rowTitle = mysqli_fetch_assoc($resultTitle); 
		?>
		<form method = "post" action="addToPL.php?stitle=<?php echo $rowTitle['title']?> & idSong=<?php echo $_GET['IDofSong']?> & name=<?php echo $_POST['playlistName'] ?> & creator=<?php echo $_SESSION['name'] ?>">
			<input type="text" class="form-control" placeholder="Enter Playlist Name:" name="playlistName"> </input> 
						 <button type="submit" name = "addToPlayList" class="btn btn-primary" >
							<i class="glyphicon glyphicon-ok"></i>
						</button> 
		</form>
		
		
	</br>
	<br>
	<div class="dropdown">
                <span class="glyphicon glyphicon-shopping-cart dropdown-toggle" data-toggle="dropdown">BUY</span>
                <ul class="dropdown-menu">
                    <li><form >
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Name:" name="credit">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <i class="glyphicon glyphicon-tags"></i>
                            </button>
                        </div>
                    </div>
                </form></li>
                    <li><form >
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Credit-Card No:" name="credit">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="glyphicon glyphicon-credit-card"></i>
                                </button>
                            </div>
                        </div>
                    </form></li>
                    <li><form >
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Expiration Date:" name="credit">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                </button>
                            </div>
                        </div>
                    </form></li>
                    <li><form >
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="CVC No:" name="credit">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="glyphicon glyphicon-barcode"></i>
                                </button>
                            </div>
                        </div>
                    </form></li>
                    <li><form method = "post" >
					<div class="input-group">
						<div class="input-group-btn">
						<button name="buySong" class="btn btn-default" type="submit">BUY
						</button>
						</div>
					</div>
					</form></li>
                </ul>
            </div>
		
	</br>
    <table class="table table-hover">
        <thead>
		<?php
			$querySongs = "select
       t.name as title,
       D.name as artistname,
      B.name as albumname,
       t.duration as duration,
       t.ID as idSong,
       A.albumID as IDalbum,
	   t.price as price,
	   t.date_of_publish as date,
	   t.companyName as companyName,
	   t.type as type,
	   t.region as region
     from
       song_album A,
       items B,
       has_Song C,
       artist D,
       (
         select
           I.name,
           I.ID,
		   I.price,
		   I.date_of_publish,
		   S.companyName,
           S.duration,
		   S.type,
		   S.region
         from
           song S,
           items I
         where
           S.ID = '".$_GET['IDofSong']."'
           and S.ID = I.ID
       ) t
     where
       t.ID = A.songID
       and B.ID = A.albumID
       and C.songID = t.ID
       and D.ID = C.artistID;
			";   
			$resultOfQuerySongs = mysqli_query($database, $querySongs);
			while( $row = mysqli_fetch_assoc($resultOfQuerySongs) )
					{ ?>
        <tr>
            <th>Artist / Band</th>
			<td><?php echo $row['artistname']; ?></td>
        </tr>
		<tr>
			<th>Album</th>
			<td><?php echo $row['albumname']; ?></td>
		</tr>
		<tr>
            <th>Duration<span class="glyphicon glyphicon-time"></span></th>
			<td><?php echo $row['duration']; ?></td>
		</tr>
		<tr>
            <th>Price</th>
			<td><?php echo $row['price']; ?></td>
		</tr>
		<tr>
            <th>Type</th>
			<td><?php echo $row['type']; ?></td>
		</tr>
		<tr>
            <th>Region</th>
			<td><?php echo $row['region']; ?></td>
		</tr>
		<tr>
            <th>Publish</th>
			<td><?php echo $row['date']; ?></td>
		</tr>
		<tr>
            <th>Production Company</th>
			<td><?php echo $row['companyName']; ?></td>
		</tr>
        </thead>
        <tbody>
		
        
		<?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>