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
            <li class = "active" ><a href="ProductionCompanyViewStatistics.php">View Statistics</a></li>
            <li >

                <a href="#">View Albums</a>
            </li>
            <li ><a href="#">View Songs</a></li>
           


        </ul>
        
        <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> </a></li>
            <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
    </div>
</nav>
<div class="container">

    <h1>Production Company: <?php echo $_SESSION['name']; ?></h1>
    <br>
    <div class="panel panel-default">
  <div class="panel-body">Most Sold Type Among Published Songs<?php 
    $queryCall = "call showMostSoldType3(@max,@type)";
    $resultCall = mysqli_query($database,$queryCall);
    $selectMaxAndType = "select @max as max,@type as type";
    $resultMax=  mysqli_query($database,$selectMaxAndType);
    $fetch = mysqli_fetch_assoc($resultMax);


    	echo $fetch['type'].' with Count: '.$fetch['max']; ?></div>
</div>

 <div class="panel panel-default">
  <div class="panel-body">Region that Sold the Most Song<?php 
    $queryCall = "call showMostSoldType3(@max2,@region)";
    $resultCall = mysqli_query($database,$queryCall);
    $selectMaxAndType = "select @max2 as max2,@region as type2";
    $resultMax=  mysqli_query($database,$selectMaxAndType);
    $fetch = mysqli_fetch_assoc($resultMax);


    	echo $fetch['type2'].' with Count: '.$fetch['max2']; ?></div>
</div>




</div>
</body>
</html>