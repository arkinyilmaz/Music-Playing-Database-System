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
    <link rel="stylesheet" type="text/css" href="style.css">
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

<!-- Left-aligned -->
<div class="container-fluid">

</div>

<div class="container">
    <h2>Your Album Library</h2>
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
    <br>

    <div class="container-fluid" >
        <div class = "row">
            <div class="col-sm-3">
                <table class="table table-hover">
				<tbody>
				<?php
				$query = "select
				  t.name as albumname,
				  E.name as artistname
				from
				  song_album C,
				  song S,
				  has_Song D,
				  artist E,
				  (
					select
					  I.ID,
					  I.name
					from
					  buy B,
					  items I,
					  album A
					where
					  B.buyer = '".$_SESSION['name']."'
					  and B.bought_for = '".$_SESSION['name']."'
					  and B.itemID = I.ID
					  and A.ID = I.ID
				  ) t
				where
				  t.ID = C.albumID
				  and S.ID = C.songID
				  and S.ID = D.songID
				  and D.artistID = E.ID;";
				$resultOfQuery = mysqli_query($database, $query);
				while( $row = mysqli_fetch_assoc($resultOfQuery) )
				{ ?> 
                <tr>
				<td><?php echo $row['albumname']; ?></td>
				<td><?php echo $row['artistname']; ?></td>
			    <td>  
				<div class="dropdown">
                    <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>
                    <ul class="dropdown-menu">
                        <li><a href="#">View Album</a></li>
                    </ul>
                </div>
				</td>
				</tr>
				<?php }?>
                </tbody>
                </table>


            </div>
    </div>
</div>

</div>
</body>
</html>