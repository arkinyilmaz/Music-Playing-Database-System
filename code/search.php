<?php

	include_once('server.php'); 
	session_start();

	if( isset( $_POST['submitButton']) )
	{
		//echo "heyy";
		$searchType = $_POST["radio"];
		$_SESSION['radiotype'] = $_POST["radio"];
		$_SESSION['search'] = $_POST['search'];
		$_GET['followUser'] = "";
		//header('location: search.php');
	}
	
	if( isset( $_GET['followUser']) && $_GET['followUser'] != "" )
	{
		$queryFollow = "insert into follow_user values('".$_SESSION['name']."','".$_GET['followUser']."', CURRENT_TIMESTAMP())";
		$resultOfQueryFollow = mysqli_query($database, $queryFollow);
		if($resultOfQueryFollow){
			echo '<script language="javascript">';
			echo 'alert("you have succesfully followed User ")';
			echo '</script>';
			
		}
		else{
			echo '<script language="javascript">';
			echo 'alert("you already follow User")';
			echo '</script>';
		}
		$_GET['followUser'] = "";
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
            <li ><a href="#">Main Page</a></li>
            <li >
                <a href="discover.php">Discover</a>
            </li>
            <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/songs.php">Songs</a></li>
            <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/albums.php">Albums</a></li>
            <li><a href="#">PlayLists</a></li>


        </ul>
        <form class="navbar-form navbar-left" method="post" >
            <div class="input-group">
              <div class="row">
                <input type="text" class="form-control" placeholder="Search" name="search">
              
                    <button name = "submitButton" class="btn btn-default" type="submit">
                        <i class="glyphicon glyphicon-music"></i>
                    </button>
					<label class="radio-inline"><input type="radio" value="1" name="radio">User</label>
                    <label class="radio-inline"><input type="radio" value="2" name="radio">Album</label>
					<label class="radio-inline"><input type="radio" value="3" name="radio">Songs</label>
					<label class="radio-inline"><input type="radio" value="4" name="radio">Playlist</label>
					<label class="radio-inline"><input type="radio" value="5" name="radio">Singer</label>
                    <label class="radio-inline"><input type="radio" value="6" name="radio">Production Company</label>
                </div>
            </div>
        </form>
		             
        <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="#"><span class="glyphicon glyphicon-user"></span> </a></li>
            <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
		
    </div>
</nav>

<!-- Left-aligned -->


<div class="container">
    <h1>Search Results</h1>
	<br>
		
	</br>
    <div class="container-fluid"  >


        <div class = "row">
            <div class="col-sm-9">
                <table class="table table-hover">
                    <thead>
                    <tr>
						<?php if( $_SESSION['radiotype'] == 1) { ?>
							<th><?php echo "User" ;?></th>    
						<?php } ?>
						<?php if($_SESSION['radiotype'] == 2) { ?>
							<th><?php echo "Album" ;?></th>
						<?php } ?>
						<?php if($_SESSION['radiotype']  == 3) { ?>
							<th><?php echo "Song" ;?></th>
						<?php } ?>
						<?php if($_SESSION['radiotype']  == 4) { ?>
							<th><?php echo "Playlist" ;?></th>
						<?php } ?>
						<?php if($_SESSION['radiotype'] == 5) { ?>
							<th><?php echo "Singer" ;?></th>
						<?php } ?>
						<?php if($_SESSION['radiotype']  == 6) { ?>
							<th><?php echo "Production Company" ;?></th>
						<?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
					<?php
						if ($_SESSION['radiotype']  == 1) //user
						{
							$query = "select username from user where username like '%".$_SESSION['search']."%'";  
							
						}
						else if ( $_SESSION['radiotype']  == 2) // album
						{
							$query = "select I.name as name, I.ID as ID from album A,items I where A.ID = I.ID and I.name like '%".$_SESSION['search']."%'";
						}
						else if( $_SESSION['radiotype']  == 3) //songs
						{
							$query = "select I.name as name, I.ID as ID from song S,items I where S.ID = I.ID and I.name like'%".$_SESSION['search']."%'";	
						}
						else if( $_SESSION['radiotype']  == 4) //playlist
						{
							$query = "select P.name as name, P.username as username from playlist P where P.name like'%".$_SESSION['search']."%'";	
							
						}
						else if( $_SESSION['radiotype']  == 5) //singer
						{
							$query = "select A.name as name, A.ID as ID from artist A where A.name like'%".$_SESSION['search']."%'";	
						}
						else if( $_SESSION['radiotype']  == 6) //production company
						{
							$query = "select name from production_company where name like'%".$_SESSION['search']."%'";	
						}
						$resultOfQuery = mysqli_query($database, $query);
						$result = "";
						while( $row = mysqli_fetch_assoc($resultOfQuery) )
						{
							$result = true;
							if ($_SESSION['radiotype'] == 1){?>	
							<tr>	
								<td><?php  echo $row['username']; ?></td>
								<td>
								<div class="dropup">
                                <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

                                <ul class="dropdown-menu">
                                    <li><a href="overview.php?nameOther=<?php echo $row['username']?>">View  <span class="glyphicon glyphicon-eye-open"></span></a></li>
									<li><a href="search.php?followUser=<?php echo $row['username']?> " class="btn" type = "submit" role = "button" name= "followUser" >Follow <span class="glyphicon glyphicon-fire "></span>
									</a></li>
                                </ul>
								</div>
								</td>
								</tr>
							

							<?php } ?>
				
							<?php if( $_SESSION['radiotype'] == 2){?>	
								<tr>	
								<td><?php echo $row['name'];  ?></td>
								<td>
								<div class="dropup">
                                <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

                                <ul class="dropdown-menu">
									<li><a href="album.php?nameAlbum=<?php echo $row['name'] ?> & idAlbum=<?php echo $row['ID']?>">View  <span class="glyphicon glyphicon-eye-open"></span></a></li>
                                </ul>
								</div>
								</td>
								</tr>
								

							<?php } ?>
							
							<?php if($_SESSION['radiotype']== 3){?>		
							<tr>
								<td><?php echo $row['name'];  ?></td>
								<td>
								<div class="dropup">
                                <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

                                <ul class="dropdown-menu">
                                    <li><a href="song.php?nameOfSong=<?php echo $row['name'] ?> & IDofSong=<?php echo $row['ID']?>">View  <span class="glyphicon glyphicon-eye-open"></span></a></li>
                                </ul>
								</div>
								</td>
								</tr>
								

							<?php } ?>
							
							<?php if( $_SESSION['radiotype'] == 4){?>	
							<tr>	
								<td><?php echo $row['name'];  ?></td>
								<td><?php echo $row['username'];  ?></td>
								<td>
								<div class="dropup">
                                <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

                                <ul class="dropdown-menu">
									 <li><a href="playlist.php?name=<?php echo $row['name'] ?> & creator=<?php echo $row['username']?>">View  <span class="glyphicon glyphicon-eye-open"></span></a></li>
                                </ul>
								</div>
								</td>
								</tr>
								

							<?php } ?>
							
							<?php if( $_SESSION['radiotype'] == 5){?>	
							<tr>	
								<td><?php echo $row['name'];  ?></td>
								<td>
								<div class="dropup">
                                <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

                                <ul class="dropdown-menu">
                                    <li><a href="#">View    <span class="glyphicon glyphicon-eye-open"></span></a></li>
                                </ul>
								</div>

								</td>
								</tr>
							<?php } ?>
							
							<?php if($_SESSION['radiotype'] == 6){?>
							<tr>		
								<td><?php echo $row['name'];  ?></td>
								<td>
								<div class="dropup">
                                <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

                                <ul class="dropdown-menu">
                                    <li><a href="#">View    <span class="glyphicon glyphicon-eye-open"></span></a></li>
                                </ul>
								</div>
								</td>
								</tr>
								

							<?php } ?>
							
						<?php }
						if($result){
						$_SESSION['radiotype'] = "";
								  $_SESSION['search'] = "";}
						?>
                        <?php 
						if(empty($result))
						{?>

							<td><?php echo "No results Found";?> </td>
						<?php }
						?>
						
                      
                    </tr>
                    </tbody>
                </table>
            
            </div>

        </div>




    </div>

</div>



</body>
</html>