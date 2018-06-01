<?php  
include_once('server.php'); 
session_start();

	$userID = "";
	$password = "";
	$warning = false;

	if( isset( $_POST['login'])){
	$userID = mysqli_real_escape_string( $database,$_POST['email'] );
	$password = mysqli_real_escape_string( $database, $_POST['password'] ); 		
		
	if(empty($userID))
	{
		$warning = true;
		$warningUserName =  "Please enter your username";
	}
	
	if(empty($password))
        {
		$warning = true;
		$warningPassword = "Please enter your password";
        }

	if( !$warning)
	{
		$query = "select * from user where username= '".$userID."' ";
		$resultOfQuery = mysqli_query($database, $query);
		$numberOfRows = mysqli_num_rows( $resultOfQuery );
		$resultRow = mysqli_fetch_assoc($resultOfQuery);
			
			if( $numberOfRows == 1 && $resultRow['password'] == $password )
			{
				$_SESSION['name'] = $userID;
                $queryGetType = "select usertype from user where username = '".$userID."'";
                $result = mysqli_query($database,$queryGetType);
                $row = mysqli_fetch_assoc($result);
                $_SESSION['type'] = $row['usertype'];
                if($_SESSION['type']==3){

                           $_SESSION['proname'] = $userID;
                            header('location: ProductionCompanyViewStatistics.php');
                }else{
               
				$_SESSION['success'] = "Success";
				header('location: overview.php');
            }
			}
			else 
			{
				$warningInvalid = "Cannot found username/password combination" ;
			}
		}
	}	
	if( isset( $_POST['register']) )
	{
		header('location: register.php');
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Hey Listen</title>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="jumbotron">
        <h1 style="color:teal;">HeyListen</h1>
        <p>HeyListen is where people meet, share, experience and LISTEN</p>

    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6">
                <img class="img-responsive" src="welcomeImage.jpg">
            </div>
            <div class="col-xs-6">

                <div class="row">
                    <blockquote>
                        <p>One good thing about music is when it hits you feel no pain</p>
                        <footer>Bob Marley</footer>
                    </blockquote>
                </div>

                <div  class="row top15">
                <span class="error"><font color="red"> <?php echo $warningUserName;?></font></span>
                <span class="error"><font color="red"> <?php echo $warningPassword;?></font></span>
                <span class="error"><font color="red">  <?php echo $warningInvalid;?></font></span>
                <form method = "post" action ="login.php">
                    <div class="input-group">

                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="email" type="text" class="form-control" name="email" placeholder="Username">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control " name="password" placeholder="Password">

                    </div>

	       <div class="container top7">
                <button name="login" type="submit" class="btn btn-primary">Login</button>
                <button name="register" type="submit" class="btn btn-success">Register</button>

               </div>

                </form>
            </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>
