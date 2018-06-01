<?php

	include_once('server.php'); 
	session_start();
    if(isset($_GET['valueP'])){
        $queryInsertIntPost = "insert into post(username, share_time) values('".$_SESSION['name']."',CURRENT_TIMESTAMP())";

        mysqli_query($database, $queryInsertIntPost);

          $queryInsertIntoPlayPost = "insert into post_playlist values(LAST_INSERT_ID(),'".$_GET['valueU']."','".$_GET['valueP']."')"; 
          mysqli_query($database, $queryInsertIntoPlayPost);
    }
    if(isset($_GET['stitle'])){
        $queryInsertIntPost = "insert into post(username, share_time) values('".$_SESSION['name']."',CURRENT_TIMESTAMP())";

        mysqli_query($database, $queryInsertIntPost);

          $queryInsertIntoPlayPost = "insert into post_song values(LAST_INSERT_ID(),".$_GET['idSong'].")"; 
          mysqli_query($database, $queryInsertIntoPlayPost);
    }
	if( isset( $_POST['add_budget']) )
	{
		$name = $_POST['name'];
		$cardno = $_POST['cardno'];
		$exp_date = $_POST['exp_date'];
		$cvc = $_POST['cvc'];
		$addedbudget = $_POST['budget'];
		
		if( strlen($name) > 0 && strlen($cardno) == 16 && strlen($exp_date) == 4 && strlen($cvc) == 3 && strlen($addedbudget) > 0 ){
			$budgetQuery = "UPDATE user SET budget = budget + '$addedbudget' WHERE username='".$_SESSION['name']."'";
			$resultOfBudgetQuery = mysqli_query($database, $budgetQuery);
			header('location: overview.php');
		}
		else{
				echo '<script type="text/javascript">';
				echo'alert("Invalid credentials");';
				echo 'window.location = "./overview.php";';
				echo '</script>';
		}
	}
	
	if( isset( $_POST['submitButton']) )
    {
        //echo "heyy";
        $searchType = $_POST["radio"];
        echo $_POST['search'];
        echo $searchType;
        $_SESSION['radiotype'] = $_POST["radio"];
        $_SESSION['search'] = $_POST['search'];
        header('location: search.php');
    }
	
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
            <li ><a href="mainPage.php">Main Page</a></li>
            <li >
                <a href="discover.php">Discover</a>
            </li>
            <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/songs.php">Songs</a></li>
            <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/albums.php">Albums</a></li>
          


        </ul>



<form class="navbar-form navbar-left" method="post" >
            <div class="input-group">
             <div class="row">
                <input type="text" class="form-control" placeholder="Search" name="search">
               
                    <button name = "submitButton" class="btn btn-default" type="submit">
                        <i class="glyphicon glyphicon-music"></i>
                    </button>
                    <label class="radio-inline"><input type="radio" value="1" name="radio">User</label>
                    <label class="radio-inline"><input type="radio" value="2" name="radio">Album</label>
                    <label class="radio-inline"><input type="radio" value="3" name="radio">Songs</label>
                      <label class="radio-inline"><input type="radio" value="4" name="radio">Playlist</label>
                    <label class="radio-inline"><input type="radio" value="5" name="radio">Singer</label>
                    
                </div>
            </div>
        </form>
         <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="overview.php?nameOther=<?php echo $_SESSION['name'];?>"><span class="glyphicon glyphicon-user"></span> </a></li>
            <li><a href="overview.php?logOut=<?php echo '1'?>"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
    </div>
</nav>

        <!---
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
       
-->

<!-- Left-aligned -->


<div class="container">
  <?php 
        if ($_GET['nameOther'] && $_GET['nameOther'] != $_SESSION['name'] )
        {
           
            $_SESSION['qname'] = $_GET['nameOther'];
            $other = $_GET['nameOther'];?>
            <h1><?php echo "$other's Profile"; ?> </h1>
        <?php }
        else{?>
        <h1><?php echo "Your Profile"; ?></h1>
     <?php } ?>
    <br>
        <?php
            if( !$_GET['nameOther'] || $_GET['nameOther'] == $_SESSION['name'] )
            {
                $_SESSION['qname']=$_SESSION['name'];
;            $query = "select budget from user where username='".$_SESSION['name']."'";   
            $resultOfQuery = mysqli_query($database, $query);
            while( $row = mysqli_fetch_assoc($resultOfQuery) )
                    { ?>        
                        <tr> 
                            <td> <?php echo 'Budget: '; ?> </td>
                            <td><?php  echo $row['budget']; ?></td>
                        </tr>
                    <?php }
                    
                    
            echo '<div class="dropdown">
                <span class="glyphicon glyphicon-shopping-cart dropdown-toggle" data-toggle="dropdown"> $</span>
                <ul class="dropdown-menu">
				<form method="post">
                    <li>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Name:" name="name">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="button" disabled>
                                <i class="glyphicon glyphicon-tags"></i>
                            </button>
                        </div>
                    </div>
                </li>
                    <li>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Credit-Card No:" name="cardno">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="button" disabled>
                                    <i class="glyphicon glyphicon-credit-card"></i>
                                </button>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Expiration Date:" name="exp_date">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="button" disabled>
                                    <i class="glyphicon glyphicon-calendar"></i>
                                </button>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="CVC No:" name="cvc">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="button" disabled>
                                    <i class="glyphicon glyphicon-barcode"></i>
                                </button>
                            </div>
                        </div>
                    </li>
					<li>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Added budget:" name="budget">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="button" disabled>
                                    <i class="glyphicon glyphicon-barcode"></i>
                                </button>
                            </div>
                        </div>
                    </li>
                    <li><button type="submit" class="btn btn-default" name="add_budget">Submit</button></li>
					</form>
                </ul>
            </div>';
            ?>
        
            <?php }?>

    
    

    <br>
    <ul class="nav nav-tabs">

        <li class="active"><a href="#">Overview</a></li>
        <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/playlists.php">Playlists</a></li>
        <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/groups.php">Groups</a></li>
        <li ><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/following.php">Following</a></li>
        <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/follower.php">Follower</a></li>

        <?php 
        if($_SESSION['type'] == 2){
         echo '<li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/musicianSong.php">Publish and View Songs</a></li>
        <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/musicianAlbum.php">Publish and View Albums</a></li>';
        }
        ?>
    </ul>

   <!-- <h2>Your Friends' Activity</h2>-->
    <br>

<?php
 
function cmp($a, $b)
{
    return strtotime($a->time) < strtotime($b->time);
}
  $arr = array() ;
        $object = new stdClass();
      
        $object->follow_like_playlist_type = 'Here we go';
        $query1 = "select userUsername, creatorUserName,playlistName,time,type from follow_like_playlist F where  userUsername ='".$_SESSION['qname']."' order by time desc limit 10";
     
        $result1 = mysqli_query($database, $query1);

        $query2 = "select U.username as yourfriend, U1.username as followed,F.since from follow_user F, user U, user U1 where U1.username = F.followed_id and U.username = F.follower_id   and U.username ='".$_SESSION['qname']."' order by F.since desc limit 10";
     
        $result2 = mysqli_query($database, $query2);

       
        $query3 = "select username,p_username, p_name, share_time 
                from post_playlist PO, post P
                where PO.post_ID = P.ID  and P.username  ='".$_SESSION['qname']."' order by share_time desc limit 10";
        $result3 = mysqli_query($database, $query3);

        $query4 = "select I.name as songname, I.price as price,I.ID as id,P.username as name, P.share_time as share_time
                from post_song PS, post P, items I
                where PS.p_ID = P.ID and I.ID = PS.s_ID and P.username  ='".$_SESSION['qname']."' order by share_time desc limit 10";
        $result4 = mysqli_query($database, $query4);
        #echo $query4;

        while($fetch= mysqli_fetch_assoc($result1)){
             $object = new stdClass();
             $object->time = $fetch['time'];
             $object->type = $fetch['type'];
             $object->user = $fetch['userUsername'];
             $object->playlistname = $fetch['playlistName'];
             $object->creatorName = $fetch['creatorUserName'];
              array_push($arr,$object);

           
                ;
            }

        
            while($fetch= mysqli_fetch_assoc($result2)){
            $object = new stdClass();
            $object->time = $fetch['since'];
            $object->user = $fetch['yourfriend'];
            $object->type = -1;
            $object->followeduser = $fetch['followed'];
            array_push($arr,$object);
            
                ;
            
           
            }
             while($fetch= mysqli_fetch_assoc($result3)){
                $object = new stdClass();
                $object->time = $fetch['share_time'];
                $object->type = -2;
                $object->user = $fetch['username'];
                 $object->creatorName =$fetch['p_username'];
                $object->playlistname = $fetch['p_name'];
                array_push($arr,$object);

             }
             while($fetch= mysqli_fetch_assoc($result4)){
                $object = new stdClass();
                $object->time = $fetch['share_time'];
                $object->type = -3;
                $object->user = $fetch['username'];
                $object->songName =$fetch['songname'];
                $object->songID =$fetch['id'];
                array_push($arr,$object);

             }

           
            usort($arr, "cmp");
           # print_r($arr);
          

       



foreach ($arr as $key=>$obj) {
    #echo $obj->user;
    echo "<br>";
echo '<div class="container-fluid"  >
        <div class = "row">
            <div class="col-sm-3">
               
               

           

           ';


           if($obj->type==-3){
            echo  ' <img src="musicShare.jpg" style="width:100%">
                </div> <div class="col-sm-9">
                <div class="panel panel-default">'.
                '<div class="panel-heading">'.
                '<div class = "row" ><strong>'.'<div class="col-sm-8">'.$obj->user.'</strong> <span class="text-muted"> shared Song: '.$obj->songName.' in '.$obj->time.'</span></div><div class="col-sm-4">'.


                '</div></div>
                </div>
                <div class="panel-body">'.
              '</div>
                </div>
                 </div>

        </div>

    </div>
    <br>';
           }
            if($obj->type==-2){
                echo  '
                 <img src="sharePlaylist.jpg" style="width:100%">
                </div> <div class="col-sm-9">
                <div class="panel panel-default">'.
                '<div class="panel-heading">'.
                '<div class = "row" ><strong>'.'<div class="col-sm-8">'.$obj->user.'</strong> <span class="text-muted"> shared Playlist: '.$obj->playlistname.' created by '.$obj->creatorName.' in '.$obj->time.'</span></div><div class="col-sm-4">'.


                '</div></div>
                </div>
                <div class="panel-body">'.
              '</div>
                </div>
                 </div>

        </div>

    </div>
    <br>';
            }

            if($obj->type==2){
            echo '
                 <img src="like.jpg" style="width:100%">
                </div> <div class="col-sm-9">
                <div class="panel panel-default">'.
                '<div class="panel-heading">'.
                '<div class = "row" ><strong>'.'<div class="col-sm-8">'.$obj->user.'</strong> <span class="text-muted"> liked Playlist: '.$obj->playlistname.' created by '.$obj->creatorName.' in '.$obj->time.'</span></div><div class="col-sm-4">'.


                '</div></div>
                </div>
                <div class="panel-body">'.
              '</div>
                </div>
                 </div>

        </div>

    </div>
    <br>'
                ;
            }
            else if($obj->type==1){
                echo '
                     <img src="dislike.jpg" style="width:100%">
            </div> <div class="col-sm-9">
                <div class="panel panel-default">'.
                '<div class="panel-heading">'.
                '<div class = "row" ><strong>'.'<div class="col-sm-8">'.$obj->user.'</strong> <span class="text-muted"> disliked Playlist: '.$obj->playlistname.' created by '.$obj->creatorName.' in '.$obj->time.'</span></div><div class="col-sm-4">'.


                '</div></div>
                </div>
                <div class="panel-body">'.
                
                '</div>
                </div>
                 </div>

        </div>

    </div>
    <br>'
                ;
            }
             else if($obj->type==3){
                echo '
                 <img src="followPlaylist.jpg" style="width:100%">
            </div> <div class="col-sm-9">
                <div class="panel panel-default">'.
                '<div class="panel-heading">'.
                '<div class = "row" ><strong>'.'<div class="col-sm-8">'.$obj->user.'</strong> <span class="text-muted"> followed Playlist: '.$obj->playlistname.' created by '.$obj->creatorName.' in '.$obj->time.'</span></div><div class="col-sm-4">'.


                '</div></div>
                </div>
                <div class="panel-body">'.
              '</div>
                </div>
                 </div>

        </div>

    </div>
    <br>';
}
    
       
else if($obj->type==-1){

           
echo '
 <img src="follow_user.jpg" style="width:100%">
</div> <div class="col-sm-9">
<div class="panel panel-default">'.
'<div class="panel-heading">'.
'<div class = "row" ><strong>'.'<div class="col-sm-8">'.$obj->user.'</strong> <span class="text-muted"> followed User: '.$obj->followeduser.' in '.$obj->time.'</span></div><div class="col-sm-4">'.


'</div></div>
</div>
<div class="panel-body">'.
'</div>
</div>
 </div>

</div>

    </div>
    <br>';
}


}





?>



    <!-- Left-aligned media object -->
    


    <hr>

    <!-- Right-aligned media object -->



    <div class="container-fluid"  >


       </div>


</div>



</body>
</html>