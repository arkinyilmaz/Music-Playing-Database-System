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

        <li ><a href="overview.php">Overview</a></li>
        <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/playlists.php">Playlists</a></li>
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

   <!-- <h2>Your Friends' Activity</h2>-->
    <br>
    <?php 

    if($_SESSION['type']==2) {
echo '<div class = "container">';

	     echo "<form class=\"form-inline\"    method=\"post\">
             
              
              <div class=\"form-group\">
              <label for=\"focusedInput\">Album Name</label>
              <input name = \"AlbumName\" class=\"form-control\" id=\"focusedInput\" type=\"text\">
    
              </div> 
               <div class=\"form-group\">
              <label for=\"focusedInput\">Price</label>
              <input name = \"Price\" class=\"form-control\" id=\"focusedInput\" type=\"text\">
    
        
 			
        </div>
              <input type=\"submit\" name=\"submit\" value=\"Submit\"> 

              </form>";
if($_SERVER["REQUEST_METHOD"] == "POST"){
              $flag1 = true;
              $flag2 = true;
              $albumid;
              
                      
                    
                       if(empty($_POST["Price"])) {
                         echo "<div class=\"alert alert-danger\">
                            <strong> Warning! </strong> You should enter a Price
                          </div>";
                        $flag2 = false;
                      }
                     
                     
                      if(!empty($_POST["AlbumName"])){
              				#echo "here <br>";
              				$query = "select ID as aid from items where name = '".$_POST["AlbumName"]."'";
                        #echo $query;
              				$result = mysqli_query($database, $query);
              				$numrows = mysqli_num_rows($result);
              				#echo $query;
              				#echo "<br>";
              				if($numrows > 0){
              					
              			
                        $flag1 = false;
                        echo "<div class=\"alert alert-danger\">
                            <strong> Warning! </strong> This album already exists
                          </div>";
              				}

             			 }
                   else{
                    echo "<div class=\"alert alert-danger\">
                            <strong> Warning! </strong> You should enter a Album Name
                          </div>";
                        $flag1 = false;
                   }
                      if($flag2&&$flag1){
                      	$queryInsertItems = "insert into items(name, price, date_of_publish) values('".$_POST["AlbumName"]."',".$_POST["Price"].", CURRENT_TIMESTAMP())";
                         echo "<div class=\"alert alert-success\">
                            <strong> Success! </strong> You have created the new album <br> You need to add songs to view the album :)
                          </div>";
                      	#echo $queryInsertItems;
                      	#echo "<br>";
                      	$resultOfInsertQuerySongs = mysqli_query($database, $queryInsertItems);
                      	

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
		
			$querySongs = "select I.name as albumname, I.ID as idAlbum 
			 				from items I
			 				where I.ID in( select SA.albumID
                              from song S, song_album SA, has_Song HS, artist A
                              where SA.songID = S.ID and S.ID = HS.songID 
                              and HS.artistID = A.ID and A.name='".$_SESSION['name']."')
			";   
			
			$resultOfQuerySongs = mysqli_query($database, $querySongs);
      #echo $querySongs;
      echo "<br>";
			while( $row = mysqli_fetch_assoc($resultOfQuerySongs) )
					{ 
       echo '<tr>
            <td>' .$row['albumname'] .'</td>
            <td>
                <div class="dropdown">
                    <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

                <ul class="dropdown-menu">
                    <li><a href=album.php?nameAlbum='.$row['albumname'].'& nameArtist='.$_SESSION['name'].'& idAlbum='. $row['idAlbum'].'>View Album</a></li>
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