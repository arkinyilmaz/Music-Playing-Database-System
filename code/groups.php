<?php
	include_once('server.php');
	session_start();
	
	if( isset( $_POST['addGroupButton']) )
	{
		$admin_name = $_SESSION['name'];
		$group_name = $_POST['groupName'];
		$addGroupQuery = "INSERT INTO groups(admin, name)
							VALUES('$admin_name','$group_name' )";
		$resultAdd = mysqli_query($database, $addGroupQuery);
		header('location: groups.php');

	}
    if( isset($_GET['logOut'] ) ) 
    {
        header('location: logout.php');
    }
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Groups</title>
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

    <h1><?php echo $_SESSION['qname'];?></h1>
   

    <br>
    <ul class="nav nav-tabs">
        <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/overview.php?nameOther=<?php echo $_SESSION['qname']?>">Overview</a></li>
        <li ><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/playlists.php">Playlists</a></li>
        <li class="active"><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/following.php">Groups</a></li>
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
            <th>Admin </th>
            <th> <div class="dropdown">
                <span class="glyphicon glyphicon-plus dropdown-toggle" data-toggle="dropdown"> Create New Group</span>
                <ul class="dropdown-menu">
                    <li><form method = "post" action ="groups.php" >
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Name:" name="groupName">
                        <div class="input-group-btn">
                            <button name="addGroupButton" class="btn btn-default" type="submit">
                                <i class="glyphicon glyphicon-user"></i>
                            </button>
                        </div>
                    </div>
					</form></li>
            </th>

        </tr>
        </thead>
        <tbody>
        
            <?php
			$query = "(select g1.ID, g1.name, g1.admin
					  from groups g1
					  where g1.admin = '".$_SESSION['name']."')
					  union
					  (select g2.ID, g2.name, g2.admin
					  from invite_user m, groups g2
					  where m.receiver = '".$_SESSION['name']."'
					  and m.groupID = g2.ID
					  and m.decision = 1)";
			$resultOfQuery = mysqli_query($database, $query);
			while( $row = mysqli_fetch_assoc($resultOfQuery) )
			{ ?> 
			<tr> 
			<td><?php echo $row['name']; ?></td>
			<td><?php echo $row['admin']; ?></td>

			<td>
			<div class="dropdown">
			<span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

			<ul class="dropdown-menu">
			<li><a href="group_page.php?groupname=<?php echo $row['name']?> & groupadmin=<?php echo $row['admin']?> & groupID=<?php echo $row['ID']?>">View Group<span class="glyphicon glyphicon-fire "></span></a></li>
			<li><a href="deleteGroup.php?deletor=<?php echo $_SESSION['name'] ?>&groupadmin=<?php echo $row['admin']?>&groupname=<?php echo $row['name'] ?>" class="btn" type = "submit" role = "button" name= "deleteGroup" >Delete <span class="glyphicon glyphicon-fire "></span>
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