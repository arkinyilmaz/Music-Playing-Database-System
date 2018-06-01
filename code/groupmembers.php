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

<!-- Left-aligned -->


<div class="container">
    <h1><?php echo $_GET['groupname'];?></h1>
    <br>
    <h2><?php echo "Admin: " . $_GET['groupadmin']; ?></h2>
    <ul class="nav nav-tabs">
        <li class = "active"><a href="#">Members <span class="glyphicon glyphicon-user "></span>
            <span class="glyphicon glyphicon-user "></span></a> </li>
    </ul>
    </br>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Username <span class="glyphicon glyphicon-user"></span></th>
            <th></th>

        </tr>
        </thead>
        <tbody>
		<?php
			$query = "SELECT receiver
					FROM invite_user IU, groups G
					WHERE G.ID = IU.groupID AND name ='".$_GET['groupname']."' AND admin ='".$_GET['groupadmin']."' AND decision = '1'";   
			$resultOfQuery = mysqli_query($database, $query);
			while( $row = mysqli_fetch_assoc($resultOfQuery) )
			{ ?>		
        <tr>
            <td><?php echo $row['receiver']; ?></td>
            <td>
                <div class="dropdown">
                    <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

                    <ul class="dropdown-menu">
						<li><a href="overview.php?nameOther=<?php echo $row['receiver']?>">View  <span class="glyphicon glyphicon-eye-open"></span></a></li>
                        <li><a href="#">Follow <span class="glyphicon glyphicon-send "></span></a></li>
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