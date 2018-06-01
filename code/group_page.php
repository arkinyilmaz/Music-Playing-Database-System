<?php
	include_once('server.php');
	session_start();
	
	if( isset( $_POST['addMemberButton']) )
	{	
		$admin_name = $_GET['groupadmin'];
		$member_name = $_POST['memberName'];
		$group_name = $_GET['groupname'];
		
		$addMemberQuery = "INSERT INTO invite_user
						VALUES( (SELECT ID from groups where admin = '$admin_name' and name = '$group_name'),'$member_name', '1')";
							
		$resultAdd = mysqli_query($database, $addMemberQuery);
		//header('location: groups.php');
		//header('location: groupmembers.php?groupname='".$_GET['groupname']."' & groupadmin='".$_GET['groupadmin']."');
	}
	if(isset( $_GET['leave']) && $_GET['leave'] != "")
	{
		//leave group 
		$ID  = $_GET['groupID'];
		//echo $_GET['groupID'];
		$deleteQuery = "delete from invite_user where groupID = '$ID' and receiver = '".$_SESSION['name']."'";
		$resultDelete = mysqli_query($database, $deleteQuery);
		if($resultDelete)
		{
			echo '<script type="text/javascript">';
			echo'alert("Leaved group successfully!");';
			echo '</script>';
			$_GET['leave'] = "";
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
            <li ><a href="mainPage.php">Main Page</a></li>
            <li >
                <a href="discover.php">Discover</a>
            </li>
            <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/songs.php">Songs</a></li>
            <li><a href="http://dijkstra.ug.bcc.bilkent.edu.tr/~iremural/deneme/albums.php">Albums</a></li>
   


        </ul>
        
        <ul class="nav navbar-nav navbar-right">
           <li class="active"><a href="overview.php?nameOther=<?php echo $_SESSION['name'];?>"><span class="glyphicon glyphicon-user"></span> </a></li>
            <li><a href="overview.php?logOut=<?php echo '1'?>"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
    </div>
</nav>

<!-- Left-aligned -->


<div class="container">
    <h1><?php echo $_GET['groupname']; ?></h1>
    <br>
    <h2><?php echo "Admin: " . $_GET['groupadmin']; ?></h2>

	<?php
			$queryCheck = "select receiver from invite_user where receiver = '".$_SESSION['name']."' and groupID ='".$_GET['groupID']."'";
			$resultCheck = mysqli_query($database, $queryCheck);
			$numOfRows = mysqli_num_rows($resultCheck);
		
			
		echo '<ul class="nav nav-tabs">
        <li ><a href="groupmembers.php?groupname=';?><?php echo $_GET['groupname']?><?php echo'& groupadmin=';?><?php echo $_GET['groupadmin']?><?php echo'">Members <span class="glyphicon glyphicon-user "></span>
            <span class="glyphicon glyphicon-user "></span></a> </li>
        <li ><a href="#">Delete <span class="glyphicon glyphicon-minus "></span></a></li>
        <li ><a href="group_page.php?groupname=';?><?php echo $_GET['groupname']?><?php echo '& groupadmin=';?><?php echo $_GET['groupadmin']?><?php echo'& leave=';?><?php echo $_GET['groupadmin']?><?php echo' & groupID=';?><?php echo $_GET['groupID']?><?php echo'">Leave <span class="glyphicon glyphicon-minus "></span></a></li>
       
		
		<li > 
                <span class="glyphicon glyphicon-plus dropdown-toggle" data-toggle="dropdown"> Add Member </span>
                <ul class="dropdown-menu">
                    <li><form method = "post">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Name:" name="memberName">
                        <div class="input-group-btn">
                            <button name="addMemberButton" class="btn btn-default" type="submit">
                                <i class="glyphicon glyphicon-user"></i>
                            </button>
                        </div>
                    </div>
					</form></li>
					</ul>
					
        </li>
        </ul>'; ?>
    <br>
    <br>
    <br>
<?php
        function cmp($a, $b)
        {
            return strtotime($a->time) < strtotime($b->time);
        }
          $arr = array() ;

        $query2 = "
                select P.username as name, PL.p_name as playlist,PL.p_name as creator,P.share_time as share_time
                from post_playlist PL, post P, share_in_group S 
                where S.g_ID =".$_GET['groupID']." and S.post_ID = P.ID and PL.post_ID = P.ID order by share_time desc limit 10
                ";

     
        $result2 = mysqli_query($database, $query2);
       # echo $query2;
          while($fetch= mysqli_fetch_assoc($result2)){

             $object = new stdClass();
             $object->time = $fetch['share_time'];
             $object->type = -1;
             $object->user = $fetch['name'];
             $object->playlistname = $fetch['playlist'];
             $object->creatorName = $fetch['creator'];
              array_push($arr,$object);

          }
           usort($arr, "cmp");
           foreach ($arr as $key=>$obj) {
                echo "<br>";
echo '<div class="container-fluid"  >
        <div class = "row">
            <div class="col-sm-3">
               
               

           

           ';
            if($obj->type == -1){
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
           }



?>

</div>



</body>
</html>
