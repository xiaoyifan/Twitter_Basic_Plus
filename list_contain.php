<?php
  session_start();
// Connection parameters 
$host = 'cspp53001.cs.uchicago.edu';
$username = 'xiaoyifan';
$password = '920127';
$database = $username.'DB';

// Attempting to connect
$dbcon = mysqli_connect($host, $username, $password, $database)
   or die('Could not connect: ' . mysqli_connect_error());

// Getting the input parameter (user):
$info = $_REQUEST['info'];


// Get the attributes of the user with the given username
$query = "SELECT A.TweetID, A.TweetContents, A.address, C.UserName, C.UserID, A.time
FROM Tweet A 
JOIN Post B ON B.TweetID = A.TweetID
JOIN User C ON B.UserID = C.UserID 
WHERE A.TweetContents Like '%$info%'";

$result = mysqli_query($dbcon, $query)
  or die('Query failed: ' . mysqli_error($dbcon));


 $user_label = "tweets contain $info:";

 $table_content = "<tr><td><a href=\"list_tweetInfo.php?TweetID=$tuple[0]\">$tuple[0]</a></td><td>$tuple[1]</td><td>$tuple[2]</td><td>$tuple[3]</td><td><a href=\"list_userInfo.php?UserID=$tuple[4]\">$tuple[4]</a></td><td>$tuple[5]</td></tr>";
 while ($tuple = mysqli_fetch_row($result)) {
    $table_content .= "<tr><td><a href=\"list_tweetInfo.php?TweetID=$tuple[0]\">$tuple[0]</a></td><td>$tuple[1]</td><td>$tuple[2]</td><td>$tuple[3]</td><td><a href=\"list_userInfo.php?UserID=$tuple[4]\">$tuple[4]</a></td><td>$tuple[5]</td></tr>";
 }


// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?> 



<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
  
 <head>
        <meta charset="utf-8">
        <title>CS53001 Tweet basic plus</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Loading Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min.css">
        <!-- Loading Flat UI -->
        <link href="css/flat-ui.css" rel="stylesheet">
        <link rel="shortcut icon" href="images/favicon.ico">

        <link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.min.css">
        
        <style type="text/css">
        html,body{
            background: #f5f5f5;
            margin:0px;
            padding: 0px;
            height: 100%;
            width: 100%;
        }
        .body{
            margin: 0 auto;
            max-width: 1200px;
            margin-top: 5px;
            min-height: 700px;
            max-height: 2000px;
           border: 1px solid #ccc;
            box-shadow:  0 5px 40px #ccc;

        }
        
        .row{
            padding-top:0px;
            margin:0px;
            padding-bottom: 0px;
            
        }
        .containerhead{
            margin:0px;
        }
        .container{
          margin-top: 15px;
        }
        th{
            font-size: 14px;
        }
        td{
            padding-right: 10px;
            font-size: 12px;
            word-break:break-all;
        }

        </style>
</head>

<body>
	  
   <div class="navbar navbar-inverse">
    <div class="navbar-header">
      <a class="navbar-brand" href=<?php echo "list_attrs.php?mail=". $_SESSION["currentUser"];?>>Homepage</a>
    </div>
    <div class="navbar-collapse collapse navbar-responsive-collapse">
      

      <ul class="nav navbar-nav">
        <li class="active"><a href="get_Tweets.php">my Tweets</a></li>
        <li><a href="list_favorite.php">Favorites</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">List <b class="caret"></b></a>
          <ul>
             <li><a href="list_allUsers.php">Users</a></li>
             <li><a href="list_allTweet.php">Tweets</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Message <b class="caret"></b></a>
          <ul>
             <li><a href="list_sentMessage.php">Send</a></li>
             <li><a href="list_receivedMessage.php">Receive</a></li>
          </ul>
        </li>
      </ul>
      
      <form class="navbar-form navbar-left" method=get action="list_contain.php">
        <input type="text" class="form-control col-lg-8" placeholder="Search in keyword" name="info">
      </form>
      
      <ul class="nav navbar-nav navbar-right">
        <li><a href="update_account.php">account</a></li>
      </ul>
    </div><!-- /.nav-collapse -->
  </div><!-- /.navbar -->


<div class="body">
  <div class = "container">
    <div class = "row"> 

      <div class ="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
               <h3 class="panel-title"><?php echo $user_label;?></h3>
            </div>
  
            <div class="panel-body">
              <div class="alert alert-info">
                <strong> Connected successfully!</strong>
              </div>

              <div class = "detail">  
                <table class = "table table-striped" >
                  <tr>
                    <th style="text-align:center">Tweet ID</th>
                    <th style="text-align:center">Contents</th>
                    <th style="text-align:center">address</th>
                    <th style="text-align:center">User Name</th>
                    <th style="text-align:center">User ID</th>
                    <th style="text-align:center">Time</th>
                  </tr>
                  <tbody>
                    <?php echo $table_content;?>
                  </tbody>
                </table>  
              </div>  

            </div>
            
        </div>
      </div>
    
    </div>
  </div>
</div>
</body>

</html>


