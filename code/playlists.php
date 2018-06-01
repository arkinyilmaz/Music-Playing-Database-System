<?php

	include_once('server.php'); 
	session_start();


	if( isset($_GET['logOut'] ) ) 
	{
		header('location: logout.php');
	}


	if(isset($_POST['shareGroupButton'])){
		$queryInsertIntPost = "insert into post(username, share_time) values('".$_SESSION['name']."',CURRENT_TIMESTAMP())";

        mysqli_query($database, $queryInsertIntPost);

          $queryInsertIntoPlayPost = "insert into post_playlist values(LAST_INSERT_ID(),'".$_POST['inputTwo']."','".$_POST['inputOne']."')"; 
          mysqli_query($database, $queryInsertIntoPlayPost);
          $queryGetGroupId = "( select G.ID as id, G.admin as admin,G.name as name from groups G, invite_user I where I.groupID = G.ID and I.receiver ='".$_SESSION['name']."' and G.name='".$_POST['search']."')
          UNION (select G1.ID as id, G1.admin as admin,G1.name as name from groups G1 where G1.admin ='".$_SESSION['name']. "'and G1.name='".$_POST['search']."')";
          $result = mysqli_query($database, $queryGetGroupId);
          $res = mysqli_fetch_assoc($result);
          $queryInsertIntoGroupPost = "insert into share_in_group values(LAST_INSERT_ID(),".$res['id'].")"; 

		mysqli_query($database,$queryInsertIntoGroupPost );
		header('location: group_page.php?groupname='.$res['name'].'& groupadmin='. $res['admin'].'& groupID='.$res['id']);

		

	}
	if( isset( $_POST['submitButton']) )
    {
        //echo "heyy";
        $searchType = $_POST["radio"];
        echo $_POST['search'];
        echo $searchType;
        $_SESSION['radiotype'] = $_POST["radio"];
        $_SESSION['search'] = $_POST['search'];
        header('location: search.php');
    }

	if( isset( $_POST['submitPlaylist']) )
	{
		$playlistName = mysqli_real_escape_string( $database, $_POST['playlistName'] );
		$name = $_SESSION['name'];
		$queryPlaylist = "insert into playlist (username, name,isPrivate) values('$name', '$playlistName', '0');"; // 0 indicates not private
		$resultOfQueryAddPlaylist = mysqli_query($database, $queryPlaylist);
		header('location: playlists.php');


		
		/*if(empty($playlistName))
		{
			$warningPlaylistName =  "Please enter playlist name";
			echo $warningPlaylistName;
		}
		//if there is a playlist with the same name give warning
		//otherwise add to list of playlists
		else{
			
			
			if($resultOfQueryAddPlaylist)
			{
					header('location: playlists.php');
			}
			else 
			{
					$warningInvalidPlaylist = "Playlist with the same name exists" ;
					echo $warningInvalidPlaylist;
			}
		}
		*/
			
	}
	
	if( isset ( $_GET['pName']) )
	{
		$queryDelete = "delete from playlist where name = '".$_GET['pName']."' and username = '".$_SESSION['name']."'";
		
		$resultOfQueryDeletePlaylist = mysqli_query($database, $queryDelete);
		header('location: playlists.php');
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

    <h1> <?php echo $_SESSION['qname']; ?> </h1>
    <br>
  
    
    <ul class="nav nav-tabs">
        <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/overview.php?nameOther=<?php echo $_SESSION['qname']?>">Overview</a></li>
        <li class="active"><a href="#">Playlists</a></li>
        <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/groups.php">Groups</a></li>
        <li ><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/following.php">Following</a></li>
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
            <th>Name </th>
            <th>Creator </th>
            <th>Date of Creation <span class="glyphicon glyphicon-calendar"></span></th>
			<th>Number of Songs </th>
            <th> 
			<div class="dropdown">
				<span class="glyphicon glyphicon-plus dropdown-toggle" data-toggle="dropdown"> Add Playlist</span>
				<ul class="dropdown-menu">
				<li><form method = "post" action ="playlists.php" >
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Enter Playlist Name:" name="playlistName">
     
                        <button type="submit" name = "submitPlaylist" class="btn btn-primary" >
                            <i class="glyphicon glyphicon-ok"></i>
                        </button>
                  
                </div>
				</form></li>
				</ul>
			</div>
			</th>
        </tr>
        <br>
        </thead>
        <tbody>
		<?php
					$query = "(select name,username, time from playlist where username='".$_SESSION['qname']."') UNION
					(select P.name as name, P.username username, P.time as time from playlist P, follow_like_playlist F where F.userUsername='".$_SESSION['qname']."' and
					P.name = F.playlistName and type = 3)


					";   
					$resultOfQuery = mysqli_query($database, $query);
					while( $row = mysqli_fetch_assoc($resultOfQuery) )
					{ ?>		
						<tr> 
							<td><?php echo $row['name']; ?></td>
							<td><?php echo $row['username']; ?></td>
							<td><?php echo $row['time']; ?></td>
							<?php 
								$query2 = "select count(*) as count from playlist_includes where username='".$row['username']."' and name = '".$row['name']."'";   
								$resultOfQuery2 = mysqli_query($database, $query2);
								while( $row2 = mysqli_fetch_assoc($resultOfQuery2) )
								{?>
							<td><?php echo $row2['count']; ?></td>
							<?php } ?>
							<td>
							<div class="dropdown">
								<span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

								<ul class="dropdown-menu">
									<li><a href="playlist.php?name=<?php echo $row['name']?> & creator=<?php echo $row['username']?>">View Playlist <span class="glyphicon glyphicon-fire "></span></a></li>
									<li><a href="overview.php?valueP=<?php echo $row['name']?>&valueU =<?php echo $row['username']?> ">Share <span class="glyphicon glyphicon-share "></span></a> </li>
									<li>
									<form method = "post">
										 <div class="input-group">
							                <input type="text" class="form-control" placeholder="Share in Group " name="search">
							                <div class="input-group-btn">
							                <?php echo '<input type="hidden" name="inputOne" value="'. $row['name'] .'" />
							                <input type="hidden" name="inputTwo" value="'. $row['username'] .'" />



							                ';



							                ?>
							                    <button class="btn btn-default" name ="shareGroupButton" type="submit">
							                        <i class="glyphicon glyphicon-share"></i>
							                    </button>
							                    </span>
							                    
							                </div>
							            </div>  
							        </form>
							            
							           

								
									</li>
									<li><a href="playlists.php?pName=<?php echo $row['name'] ?>" class="btn" type = "submit" role = "button" name= "deletePlaylist" >Delete <span class="glyphicon glyphicon-fire "></span>
									
									</a></li>
									
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