<?php

	include_once('server.php'); 
	session_start();

	$username = "";
	$password = "";
	$repassword = "";
	$country = "";
	$usertype = "";
	$warning = false;
	
	if( isset( $_POST['registerbutton']) )
	{
		$username = mysqli_real_escape_string( $database,$_POST['email'] );
		$password = mysqli_real_escape_string( $database ,$_POST[ 'password'] );
		$repassword = mysqli_real_escape_string( $database ,$_POST[ 'repassword'] ); 		
		$country = mysqli_real_escape_string( $database ,$_POST[ 'country'] );
		$usertype = $_POST["radio"];


		if(empty($username))
		{
			$warning = "true";
			$warningUserName =  "Please enter your username";
		}
	
		if(empty($password))
        	{
			$warning = "true";
			$warningPassword = "Please enter your password";
        	}

		if(empty($repassword))
                {
                        $warning = "true";
                        $warningRepassword = "Please enter your password again";
                }

		if(empty($country))
                {
                        $warning = "true";
                        $warningCountry = "Please enter your country";
                }

		if(empty($usertype))
                {
                        $warning = "true";
                        $warningUsertype = "Please select a user type";
                }

		if( !$warning)
		{
			// check if username already exists
			$checkusernamequery = " SELECT * FROM user where username = '$username';";
			$resultOfQuery = mysqli_query($database, $checkusernamequery);
			$numberOfRows = mysqli_num_rows( $resultOfQuery );
			
			if( $numberOfRows == 0){
				if ($_POST["password"] === $_POST["repassword"] && strlen($_POST["password"]) >= 6 ){
					$query = " INSERT INTO user
							VALUES('$username', '$password', '0', '$country', '0', '$usertype') ; ";

					$resultOfQuery = mysqli_query($database, $query);
					if( $resultOfQuery ){
						$_SESSION['name'] = $username;
						$_SESSION['success'] = "Success";
                        $_SESSION['type'] = $usertype;
                        if($usertype == 3){

                           $_SESSION['proname']=$username;
                            header('location: ProductionCompanyViewStatistics.php');
                        }
                        else{
					   	   header('location: overview.php');
                        }
					}
					else 
					{
						$warningInvalid = "Invalid credentials." ;
						
					}
				}
				else{
					$warningTooShort =  "Two passwords are not the same or your password is too short" . "<br>";
				}
			}
			else{
				$warningAlreadyExist = "Username already exists" . "<br>";
			}
		}
	}	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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

                <span class="error"><font color="red"> <?php echo $warningInvalid;?></font></span>
                <span class="error"><font color="red"> <?php echo $warningUsertype;?></font></span>
                <span class="error"><font color="red">  <?php echo $warningCountry;?></font></span>
                <span class="error"><font color="red">  <?php echo $warningRepassword;?></font></span>
                <span class="error"><font color="red">  <?php echo $warningAlreadyExist;?></font></span>
                <span class="error"><font color="red">  <?php echo $warningTooShort;?></font></span>
                <?php  echo $_SESSION['artistid']; ?>

                <div  class="row top15">

                    <form method="post" action= "register.php">
                        <div class="input-group">

                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="email" type="text" class="form-control" name="email" placeholder="Username">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="password" type="password" class="form-control " name="password" placeholder="Password">

                        </div>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="password2" type="password" class="form-control " name="repassword" placeholder="Re-enter Password">

                        </div>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-screenshot"></i></span>
                            <input id="country" type="text" class="form-control " name="country" placeholder="Country">

                        </div>
	
                    <div class="container top7">
                        <button name = "registerbutton" type="submit" class="btn btn-success">Register</button>
                        <label class="radio-inline"><input type="radio" value="1" name="radio">Guest</label>
                        <label class="radio-inline"><input type="radio" value="2" name="radio">Singer</label>
                        <label class="radio-inline"><input type="radio" value="3" name="radio">Production Company</label>

                    </div>


                    </form>

                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>
