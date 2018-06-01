<?php
	include_once('server.php'); 
	session_start();

	if( isset( $_POST['buyAlbum']) )
	{
		$queryID = "select  I.price as albumPrice from
					items I,
					song_album A
					where
					'".$_GET['idAlbum']."' = A.albumID
					and A.albumID = I.ID";
						  
		$resultOfQueryID = mysqli_query($database, $queryID);
		while( $rowID = mysqli_fetch_assoc($resultOfQueryID))
		{
			$price = $rowID['albumPrice'];
		}			
		
		$queryBuy = "insert into buy('".$_SESSION['name']."', '".$_GET['idAlbum']."', CURRENT_TIMESTAMP(), '".$_SESSION['name']."' )";
		$resultOfQueryBuy = mysqli_query($database, $queryBuy);
		if($resultOfQueryBuy)
		{
			$queryDecrementPrice = "update user set budget = budget - '$price' where username='".$_SESSION['name']."'";
			$resultOfQuery3 = mysqli_query($database, $queryDecrementPrice);	
		}
        else{
			$warningBuyEarlier = "You bought it earlier!";
			echo $warningBuyEarlier;
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
            <li ><a href="#">Main Page</a></li>
            <li >

                <a href="#">Discover</a>
            </li>
            <li ><a href="#">Songs</a></li>
            <li><a href="#">Albums</a></li>

            <li><a href="#">PlayLists</a></li>


        </ul>
        <form class="navbar-form navbar-left" action="/action_page.php">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" name="search">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                        <i class="glyphicon glyphicon-music"></i>
                    </button>
                </div>
            </div>
        </form>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> </a></li>
            <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
    </div>
</nav>
<div class="container">

    <h1><?php echo $_GET['nameAlbum']; ?></h1>
    <h2><?php echo $_GET['nameArtist']; ?></h2>
	<br>
    <?php 
	
		$queryTotalPrice = "select price from items where ID='".$_GET['idAlbum']."'";
		$resultOfQuery2 = mysqli_query($database, $queryTotalPrice);
					while( $row = mysqli_fetch_assoc($resultOfQuery2) )
					{?>
						<tr>
							<td><?php echo 'PRICE:'; ?></td>
							<td><?php echo $row['price']; ?></td>
							<td><?php echo '$'; ?></td>
					
						</tr>
					<?php } ?>
	</br>
	<div class="dropdown">
	<span class="glyphicon glyphicon-shopping-cart dropdown-toggle" data-toggle="dropdown"></span>
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
        <li><form>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Expiration Date:" name="credit">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                        <i class="glyphicon glyphicon-calendar"></i>
                    </button>
                </div>
            </div>
        </form></li>
        <li><form method="post">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="CVC No:" name="credit">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                        <i class="glyphicon glyphicon-barcode"></i>
                    </button>
                </div>
            </div>
        </form></li>
        <li>
		<form method="post">
            <div class="input-group">
			<button type="submit" name = "buyAlbum"  class="btn btn-default">BUY</button>
		</div>
        </form></li>
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
    <br>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th><span class="glyphicon glyphicon-time"></span></th>
            <th>Price</th>


        </tr>
        </thead>
        <tbody>
        <?php
				$query = "select
						  I.name as nSong,
						  I.price as songPrice,
						  S.duration as songDuration
						from
						  items I,
						  song S,
						  song_album A
						where
						  '".$_GET['idAlbum']."' = A.albumID
						  and A.songID = I.ID
						  and S.ID = I.ID ";
						  
				$resultOfQuery = mysqli_query($database, $query);
				while( $row = mysqli_fetch_assoc($resultOfQuery) )
				{ ?> 
					<tr> 
					<td><?php echo $row['nSong']; ?></td>
					<td><?php echo $row['songDuration']; ?></td>
					
					<td><div class="dropdown">
					<span class="glyphicon glyphicon-shopping-cart dropdown-toggle" data-toggle="dropdown"><?php echo $row[songPrice]; ?>$</span>
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
						<li><button type="button" class="btn btn-default">Submit</button></li>
					</ul>
				</div>
				</td>
				<td>
					<div class="dropdown">
						<span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

						<ul class="dropdown-menu">
							<li><a href="#">View Artist / Band</a></li>
							<li><a href="#">View Album</a></li>
							<li><a href="#">Add to Playlist</a></li>
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