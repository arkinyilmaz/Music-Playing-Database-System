<?php
	include_once('server.php'); 
	session_start();

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
            <li ><a href="#">Main Page</a></li>
            <li >

                <a href="#">Discover</a>
            </li>
            <li><a href="#">Songs</a></li>
            <li class="active"><a href="#">Albums</a></li>
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

<!-- Left-aligned -->
<div class="container-fluid">

</div>

<div class="container">
    <h2><?php echo $_GET['name']; ?></h2>
    <div class="btn-group">
        <button type="button" class="btn btn-success">Follow <span class="glyphicon glyphicon-send "></span></button>

    </div>
    <br>
    <h4>Sold Albums: 100 Million</h4>
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
            <div class="col-sm-4">
                <h4>Albums</h4>
                <br>
                <img src="thewall.jpg" style="width:100%">
                <table class="table table-hover">
                    <tr><td><h4 class="media-heading top7" >The Wall</h4></td> <td>  <div class="dropdown">
                        <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

                        <ul class="dropdown-menu">
                            <li><a href="#">View Album</a></li>
                        </ul>


                    </div></td></tr>

                    <tbody>
                    <tr> </tr>
                    </tbody>
                </table>
                <img src="divisionbell.jpg" style="width:100%">
                <table class="table table-hover">
                    <tr><td><h4 class="media-heading top7" >The Division Bell</h4></td> <td>  <div class="dropdown">
                        <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

                        <ul class="dropdown-menu">
                            <li><a href="#">View Album</a></li>
                        </ul>


                    </div></td></tr>

                    <tbody>
                    <tr> </tr>
                    </tbody>
                </table>


            </div>

            <div class="col-sm-4"  >
            <h4>Singles</h4>
            <br>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Title</th>


                        <th><span class="glyphicon glyphicon-time"></span></th>
                        <th></th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Arnold Layne</td>

                        <td>7.08</td>
                        <td><div class="dropdown">
                            <span class="glyphicon glyphicon-shopping-cart dropdown-toggle" data-toggle="dropdown"> 2$</span>
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
                                    <li><a href="#">Add to Playlist</a></li>
                                    <li><a href="#">Share <span class="glyphicon glyphicon-share "></span></a> </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>



            </div>
            <div class="col-sm-4"  >

                <h4>Members</h4>
                <br>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Name <span class="glyphicon glyphicon-user"></span></th>
                        <th></th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Nick Mason</td>
                        <td>
                            <div class="dropdown">
                                <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

                                <ul class="dropdown-menu">
                                    <li><a href="#">View Musician <span class="glyphicon glyphicon-send "></span></a></li>

                                </ul>
                            </div>
                        </td>

                    </tr>
                    <tr>
                        <td>Roger Waters</td>
                        <td>
                            <div class="dropdown">
                                <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

                                <ul class="dropdown-menu">
                                    <li><a href="#">View Musician <span class="glyphicon glyphicon-send "></span></a></li>

                                </ul>
                            </div>
                        </td>

                    </tr>
                    <tr>
                        <td>Richard Wright</td>
                        <td>
                            <div class="dropdown">
                                <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

                                <ul class="dropdown-menu">
                                    <li><a href="#">View Musician <span class="glyphicon glyphicon-send "></span></a></li>

                                </ul>
                            </div>
                        </td>

                    </tr>
                    <tr>
                        <td>David Gilmour</td>
                        <td>
                            <div class="dropdown">
                                <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

                                <ul class="dropdown-menu">
                                    <li><a href="#">View Musician <span class="glyphicon glyphicon-send "></span></a></li>

                                </ul>
                            </div>
                        </td>

                    </tr>
                    <tr>
                        <td>Syd Barrett</td>
                        <td>
                            <div class="dropdown">
                                <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown"></span>

                                <ul class="dropdown-menu">
                                    <li><a href="#">View Musician <span class="glyphicon glyphicon-send "></span></a></li>

                                </ul>
                            </div>
                        </td>

                    </tr>
                    </tbody>
                </table>
            </div>


        </div>


    </div>








</div>
</body>
</html>