<?php
	include_once('server.php'); 
	session_start();
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



    <br>
    <ul class="nav nav-tabs">

        <li ><a href="#">Overview</a></li>
        <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/playlists.php">Playlists</a></li>
        <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/groups.php">Groups</a></li>
        <li ><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/following.php">Following</a></li>
        <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/follower.php">Follower</a></li>

        <?php 
        if($_SESSION['type'] == 2){
         echo '<li class="active"><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/musicianSong.php">Publish and View Songs</a></li>
        <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/musicianAlbum.php">Publish and View Albums</a></li>';
        }
        ?>
    </ul>

   <!-- <h2>Your Friends' Activity</h2>-->
    <br>
    <?php 

    if($_SESSION['type']==2) {
echo '<div class = "container">';

	     echo "<form class=\"form-inline\"    method=\"post\">
              <div class=\"form-group\">
              <label for=\"focusedInput\">SongName</label>
              <input name = \"SongName\" class=\"form-control\" id=\"focusedInput\" type=\"text\">
    
              </div> 
              
              <div class=\"form-group\">
              <label for=\"focusedInput\">Album Name</label>
              <input name = \"AlbumName\" class=\"form-control\" id=\"focusedInput\" type=\"text\">
    
              </div> 
               <div class=\"form-group\">
              <label for=\"focusedInput\">Price</label>
              <input name = \"Price\" class=\"form-control\" id=\"focusedInput\" type=\"text\">
    
              </div>  
              <div class=\"form-group\">
              <label for=\"focusedInput\">Duration</label>
              <input name = \"Duration\" class=\"form-control\" id=\"focusedInput\" type=\"text\">
    
              </div>  
 				<div class=\"form-group\">
              <label for=\"focusedInput\">Type</label>
              <input name = \"Type\" class=\"form-control\" id=\"focusedInput\" type=\"text\">
    
              </div>  
              <div class=\"form-group\">
              <label for=\"focusedInput\">Region</label>
              <input name = \"Region\" class=\"form-control\" id=\"focusedInput\" type=\"text\">
    
              </div> 
              <div class=\"form-group\">
              <label for=\"focusedInput\">Production Company</label>
              <input name = \"ProductionCompany\" class=\"form-control\" id=\"focusedInput\" type=\"text\">
    
              </div>  
              <input type=\"submit\" name=\"submit\" value=\"Submit\"> 

              </form>";
if($_SERVER["REQUEST_METHOD"] == "POST"){
              $flag1 = true;
              $flag2 = true;
              $flag3 = true;
              $flag4 = true;
              $flag5 = true;
              $flag6 = true;
              $albumid;
              
               if (empty($_POST["SongName"])) {
                        echo "<div class=\"alert alert-danger\">
                            <strong> Warning! </strong> You should enter a song name
                          </div>";
                        $flag1 = false;
	}
                      
                      if(empty($_POST["ProductionCompany"])) {
                         echo "<div class=\"alert alert-danger\">
                            <strong> Warning! </strong> You should enter a Production Company
                          </div>";
                        $flag3 = false;
                      }
                       if(empty($_POST["Price"])) {
                         echo "<div class=\"alert alert-danger\">
                            <strong> Warning! </strong> You should enter a Price
                          </div>";
                        $flag2 = false;
                      }
                       if(empty($_POST["Duration"])) {
                         echo "<div class=\"alert alert-danger\">
                            <strong> Warning! </strong> You should enter a Duration
                          </div>";
                        $flag4 = false;
                      }
                       if(empty($_POST["Type"])) {
                         echo "<div class=\"alert alert-danger\">
                            <strong> Warning! </strong> You should enter a Type
                          </div>";
                        $flag5 = false;
                      }
                      if(empty($_POST["Region"])) {
                         echo "<div class=\"alert alert-danger\">
                            <strong> Warning! </strong> You should enter a Region
                          </div>";
                        $flag6 = false;
                      }
                      if(!empty($_POST["AlbumName"])){
              				echo "here <br>";
              				$query = "select ID as aid from items where name = '".$_POST["AlbumName"]."'";
              				$result = mysqli_query($database, $query);
              				$numrows = mysqli_num_rows($result);
              				#echo $query;
              				#echo "<br>";
              				if($numrows == 0){
              					$flag6 = false;
              					echo "<div class=\"alert alert-danger\">
                            <strong> Warning! </strong> This album does not exist
                          </div>";
              				}
              				else{
              					$aid = mysqli_fetch_assoc($result);
              					$albumid = $aid['aid'];
              				}

             			 }
                      if($flag2&&$flag1&&$flag3&&$flag4&&$flag5&&$flag6){
                      	$queryInsertItems = "insert into items(name, price, date_of_publish) values('".$_POST["SongName"]."',".$_POST["Price"].", CURRENT_TIMESTAMP())";
                      	#echo $queryInsertItems;
                      	#echo "<br>";
                      	$resultOfInsertQuerySongs = mysqli_query($database, $queryInsertItems);
                      	$getLastInsert = "select LAST_INSERT_ID() as id";
                      	$iD =mysqli_query($database, $getLastInsert);
                      	$AID = mysqli_fetch_assoc($iD);
                      	$keepID = $AID['id'];
                      	$queryInsertSong = "insert into song values(".$keepID.",".$_POST["Duration"].",0,'".$_POST["Type"]."','".$_POST["Region"]."','".$_POST["ProductionCompany"]."')";
                      	#echo $queryInsertSong;
                      	#echo "<br>";

                   		$querySongAlbum = "insert into song_album values ( ".$albumid.",".$keepID.")";
                   		$resultAlbum = mysqli_query($database, $querySongAlbum);
                      	#echo "<br>";
                      	$resultOfInsertSong = mysqli_query($database, $queryInsertSong);
                      	 $queryGetArtistId = "select ID from artist where name = '".$_SESSION['name']."'";
                      	# echo $queryGetArtistId;
                     	#echo "<br>";
                            $resId =  mysqli_query($database, $queryGetArtistId);
                            $id = mysqli_fetch_assoc($resId);
                            
                      	 $queryInsertHasSong = "insert into has_Song values(".$id['ID'].",".$keepID.")";
                      	 #echo $queryInsertHasSong;

                      	 mysqli_query($database, $queryInsertHasSong);

                      }
                  }
                  

              echo '<br>';

	echo'
 <table class="table table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th><span class="glyphicon glyphicon-time"></span></th>

        </tr>
        </thead>
        <tbody>';
		
			$querySongs = "select I.name as songname, S.duration as duration, I.ID as idSong 
			 				from items I, song S, artist A, has_Song H
			 				where I.ID = S.ID and S.ID = H.songID and H.artistID = A.ID and A.name='".$_SESSION['qname']."'
			";   
			
			$resultOfQuerySongs = mysqli_query($database, $querySongs);
			while( $row = mysqli_fetch_assoc($resultOfQuerySongs) )
					{ 
       echo '<tr>
            <td>' .$row['songname'] .'</td>
			<td>' .$row['duration'] .'</td>
            <td>
                <div class="dropdown">
                    <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

                <ul class="dropdown-menu">
                    <li><a href="#">View Album</a></li>
                    <li><a href="#">Add to Playlist:</a></li>
					<li><form method = "post" action="addToPL.php?stitle='. $row['songname'].' & idSong='. $row['idSong'].' & name='.  $_POST['playlistName'] . '& creator='. $_SESSION['qname'] .'"
					
					<li><input type="text" class="form-control" placeholder="Enter Playlist Name:" name="playlistName"> </input> </li>
						<li> <button type="submit" name = "addToPlayList" class="btn btn-primary" >
							<i class="glyphicon glyphicon-ok"></i>
						</button> </li>
					
					</form></li>
                    <li><a href="#">Share <span class="glyphicon glyphicon-share "></span></a> </li>
                </ul>
            </div>
            </td>
        </tr>';
		 } 
        echo '</tbody>
    </table>









</div>';
}
else{


}
?>