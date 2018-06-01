<?php

	include_once('server.php'); 
	session_start();

	
	
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
 
    
<h1>Your Friend's Activity</h1>
<br>

<?php
 
function cmp($a, $b)
{
    return strtotime($a->time) < strtotime($b->time);
}
  $arr = array() ;
        $object = new stdClass();
      
        $object->follow_like_playlist_type = 'Here we go';
        $query1 = "select userUsername, creatorUserName,playlistName,time,type from follow_like_playlist F where  userUsername in (select followed_id from follow_user where follower_id ='".$_SESSION['name']."') order by time desc limit 10";
     
        $result1 = mysqli_query($database, $query1);

        $query2 = "select U.username as yourfriend, U1.username as followed,F.since from follow_user F, user U, user U1 where U1.username = F.followed_id and U.username = F.follower_id   and U.username in (select followed_id from follow_user where follower_id ='".$_SESSION['name']."') order by F.since desc limit 10";
     
        $result2 = mysqli_query($database, $query2);

       
        $query3 = "select username,p_username, p_name, share_time 
                from post_playlist PO, post P
                where PO.post_ID = P.ID  and P.username  in
                (select followed_id from follow_user where follower_id ='".$_SESSION['name']."') order by share_time desc limit 10";
        $result3 = mysqli_query($database, $query3);

        $query4 = "select I.name as songname, I.price as price,I.ID as id,P.username as name, P.share_time as share_time
                from post_song PS, post P, items I
                where PS.p_ID = P.ID and I.ID = PS.s_ID and P.username  in
                (select followed_id from follow_user where follower_id ='".$_SESSION['name']."') order by share_time desc limit 10";
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