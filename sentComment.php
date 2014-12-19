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
$comment = $_REQUEST['comment'];
$mail = $_SESSION['currentUser'];
$tweetid = $_SESSION['browsingTweet'];

 $user_label = "New comment Info";
// Get the attributes of the user with the given username
//INSERT INTO users(id, name, age) VALUES(123, 'XYZ', 25);

$q = "SELECT COUNT(*) from Comment";
$re = mysqli_query($dbcon, $q)
  or die('Query failed: ' . mysqli_error($dbcon));
$tu = mysqli_fetch_row($re);

mysqli_free_result($re);

$tu[0] = $tu[0]+1;
//tu[0] is the new MessageID

date_default_timezone_set('America/Chicago'); 
$timeNow =  date('Y-m-d H:i:s'); 


$query = "INSERT INTO Comment(CommentID, time, CommentContent)
          VALUES('$tu[0]', '$timeNow','$comment')";

$result = mysqli_query($dbcon, $query)
  or die('Query failed: ' . mysqli_error($dbcon));




 $content = "<ul>
                  <li>Comment ID: $tu[0]</li>
                  <li>Comment Contents: $comment</li>
                  <li>time: $timeNow</li>
            </ul>";


$queryUser = "SELECT UserID from User
   where Email = '$mail'";

$userResult = mysqli_query($dbcon, $queryUser)
  or die('Query failed: ' . mysqli_error($dbcon));

$tupleUser = mysqli_fetch_row($userResult);          
// Free result


$queryComment = "INSERT INTO MakeComment(CommentID, UserID, TweetID)
          VALUES('$tu[0]', '$tupleUser[0]','$tweetid')";

$resultComment = mysqli_query($dbcon, $queryComment)
  or die('Query failed: ' . mysqli_error($dbcon));


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
                <strong> Comment successfully!</strong>
              </div>

              <div class = "detail">  
                
                  <p style="font-size: 18px"><?php echo $content; ?></p>

                  <p>Go back to homepage</p>
                  <a href="list_attrs.php">HomePage</a>
              </div>  

            </div>
            
        </div>
      </div>
    
    </div>
  </div>
</div>
</body>

</html>


