<?php 
    include_once('server.php'); 
    session_start();
    if(isset($_POST['comment_section']) &&isset($_POST['comment_button'])  ){
        
        $comment = $_POST['comment_section'];
		$date = date('Y-m-d H:i:s');
        $queryComment = "insert into comment(username,share_time,text) values('".$_SESSION['name']."','$date','".$comment."')";


        $result = mysqli_query($database, $queryComment);

		$queryComment = "insert into comment_on_playlist values( LAST_INSERT_ID(),'".$_SESSION['name']."','".$_SESSION['pname']."')";

        $resultComment = mysqli_query($database, $queryComment);
	
        
        #header('location: '.$str);
    }

    if(isset ($_POST['like_button']))
    {
        


        $queryLikePlaylist = "insert into follow_like_playlist values('".$_SESSION['name']."','".$_GET['creator']."','".$_GET['name']."', 2,CURRENT_TIMESTAMP())";


        $result = mysqli_query($database, $queryLikePlaylist);
        $str = "playlist.php?name=". $_GET['name']."& creator=".$_GET['creator'];
        #header('location: '.$str);

    }
    if(isset ($_POST['dislike_button']))
    {
        


        $queryLikePlaylist = "insert into follow_like_playlist values('".$_SESSION['name']."','".$_GET['creator']."','".$_GET['name']."', 1 ,CURRENT_TIMESTAMP())";


        $result = mysqli_query($database, $queryLikePlaylist);
        $str = "playlist.php?name=". $_GET['name']."& creator=".$_GET['creator'];
        #header('location: '.$str);
    }
if(isset ($_POST['like_button_comment']))
    {
        


        $queryLikePlaylist = "insert into like_comment values('".$_SESSION['name']."','".$_POST['inputOne']."',CURRENT_TIMESTAMP(),2)";


        $result = mysqli_query($database, $queryLikePlaylist);
        #$str = "playlist.php?name=". $_GET['name']."& creator=".$_GET['creator'];
        #header('location: '.$str);

    }
    if(isset ($_POST['dislike_button_comment']))
    {
        


        $queryLikePlaylist = "insert into like_comment values('".$_SESSION['name']."','".$_POST['inputTwo']."',CURRENT_TIMESTAMP(),1)";


        $result = mysqli_query($database, $queryLikePlaylist);
        #$str = "playlist.php?name=". $_GET['name']."& creator=".$_GET['creator'];
        #header('location: '.$str);
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

<br>
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
    <h1><?php echo $_SESSION['pname']; ?></h1>
    <br>
    <h2>Creator: <?php echo $_GET['creator']; ?></h2>

    <br>
        <div class="dropdown">
        <span class="glyphicon glyphicon-lock dropdown-toggle" data-toggle="dropdown"> Make private</span>
            <ul class="dropdown-menu">
            <li><form method="post" >
            <div class="container top7">
                    <label class="radio-inline"><input type="radio" name="radio" value = "1">Private</label>
                    <label class="radio-inline"><input type="radio" name="radio" value = "2">Public</label>
                    <button class="btn" name = "setPrivacy" type="submit" >
                        <i class="glyphicon glyphicon-user"></i>
                    </button>
            </div>
            </form></li>
            </ul>
        </div>
    </br>
    <br>
     <ul class="nav nav-tabs">
        <li ><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/playlist.php?creator=<?php echo $_GET['creator']?> & name=<?php echo $_SESSION['pname']?>">View</a></li>
        <li class = "active"><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/comment.php"><span class="glyphicon glyphicon-comment"></span> Comment</a></li>
        <form method = "post"  >
            <button  type="submit"  name="like_button" class="glyphicon glyphicon-thumbs-up">
                <font face="verdana" color="green"> 
                    <?php $queryLike = " select count(*) as count from follow_like_playlist where type = 2 "; 
                    $res = mysqli_query($database, $queryLike); $row = mysqli_fetch_assoc($res); 
                    echo $row['count']; ?>
                </font>
            </button>
            <button  type="submit"  name="dislike_button" class="glyphicon glyphicon-thumbs-down">
                <font face="verdana" color="green"> 
                    <?php $queryLike = " select count(*) as count from follow_like_playlist where type = 1 "; 
                    $res = mysqli_query($database, $queryLike); $row = mysqli_fetch_assoc($res); 
                    echo $row['count']; ?>
                </font>
            </button>
        </form>
    </ul>

<div class="container">
<div class="row">
<div class="col-sm-12">
<h3>You Can View Comments and Make Comment</h3>
</div><!-- /col-sm-12 -->
</div><!-- /row -->
<div class="row">

<div class="col-sm-6 pre-scrollable">

<?php 
$query = "select
  *
from
  comment_on_playlist P,
  comment C
where
  C.ID = P.commentID
  and playlistName = '".$_SESSION['pname']."' ";



$res = mysqli_query($database, $query);

while($row = mysqli_fetch_assoc($res)){
$queryShowLikes = "select count(*) as count from like_comment where type = 2 and ID = ".$row['ID']; 
$queryShowDislikes = "select count(*) as count from like_comment where type = 1 and ID = ".$row['ID'] ; 
$resL = mysqli_query($database, $queryShowLikes); 
$resD = mysqli_query($database, $queryShowDislikes); 
$resultsLike= mysqli_fetch_assoc($resL); 
$resultsDislike= mysqli_fetch_assoc($resD);



echo '<div class="panel panel-default">'.
'<div class="panel-heading">'.
'<div class = "row" ><strong>'.'<div class="col-sm-8">'.$row['username'].'</strong> <span class="text-muted">commented in '.$row['share_time'].'</span></div><div class="col-sm-4">'. 


'<form method = "post"  >
            <button  type="submit"  name="like_button_comment" class="glyphicon glyphicon-thumbs-up"> 
            <input type="hidden" name="inputOne" value="'. $row['ID'] .'" />
          
                <font face="verdana" color="green"> '.
                    
                    $resultsLike['count']
                    .'
                </font>
            </button>
            <button  type="submit"   name="dislike_button_comment" class="glyphicon glyphicon-thumbs-down">
            <input type="hidden" name="inputTwo" value="'. $row['ID'] .'" />
                <font face="verdana" color="green"> '. $resultsDislike['count'].'
                </font>

            </button>
</form>'


.'</div></div>
</div>
<div class="panel-body">'.
$row['text']
.'</div>
</div>';
}



?>




</div>

<div class="col-sm-6">
<form method="post" >

  <div class="form-group">
  <button  type="submit"  name="comment_button" class="glyphicon glyphicon-comment"> <font face="verdana" >  Make Comment:</font> </button>
  <textarea name = "comment_section" class="form-control" rows="5" id="comment"></textarea>
</div>
</form>


</div>

</div><!-- /row -->

</div><!-- /container -->

</body>
</html>