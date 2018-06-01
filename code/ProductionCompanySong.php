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
            <li class = "active" ><a href="ProductionCompanyViewStatistics.php">View Statistics</a></li>
           
            <li ><a href="#">View Songs</a></li>
           


        </ul>
       
        <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> </a></li>
           <li><a href="overview.php?logOut=<?php echo '1'?>"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
    </div>
</nav>
<div class="container">

    <h1>Production Company: <?php echo $_SESSION['name']; ?></h1>
    <br>
    <?php 
    $querySongs = "select I.name as name, S.type as type, S.listencount as listencount,S.region as region
                from items I , song S
                where I.ID = S.ID and companyName ='".$_SESSION['proname']."'"; 
    $resultSong = mysqli_query($database,$querySongs);
    #echo $querySongs.'<br>';
     echo '<table class="table table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th>Type</th>
            <th>Listen Count</th>
            <th>Region</th>

        </tr>
        </thead>
        <tbody>';
    while($row = mysqli_fetch_assoc($resultSong)){

echo '<tr>
            <td>' .$row['name'] .'</td>
            <td>' .$row['type'] .'</td>
            <td>'.$row['listencount'].'</td><td>'.$row['region'].'</td>
        </tr>';
    }
 echo '</tbody> </table> </div>';

  


    ?>
   





</div>
</body>
</html>