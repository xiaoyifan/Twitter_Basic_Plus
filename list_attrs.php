<?php
  session_start();

  $host = 'cspp53001.cs.uchicago.edu';
  $username = 'xiaoyifan';
  $password = '920127';
  $database = $username.'DB';

  // Attempting to connect
  $dbcon = mysqli_connect($host, $username, $password, $database)
      or die('Could not connect: ' . mysqli_connect_error());

  // Getting the input parameter (user):
  $user = $_REQUEST['mail'];

  if (strlen($user) == 0) {
    $user = $_SESSION["currentUser"];
  }
  else{
      $_SESSION["currentUser"] = $user;
  }


  // Get the attributes of the user with the given username
  $query = "SELECT Email, UserName, Sex, UserIntro, birth FROM User WHERE Email = '$user'";
  $result = mysqli_query($dbcon, $query)
        or die('Query failed: ' . mysqli_error($dbcon));

  // Can also check that there is only one tuple in the result
  $tuple = mysqli_fetch_array($result)
           or die("User $user not found!");


  $queryFollowed = "SELECT COUNT(*) FROM Follow 
                    JOIN User B on B.UserID = Follow.UserIDb
                    WHERE B.Email = '$user'";
  $resultFollowed = mysqli_query($dbcon, $queryFollowed)
        or die('Query failed: ' . mysqli_error($dbcon));

  // Can also check that there is only one tuple in the result
  $tupleFollowed = mysqli_fetch_array($resultFollowed)
           or die("User $user not found!");



  $queryFollow = "SELECT COUNT(*) FROM Follow 
                    JOIN User B on B.UserID = Follow.UserIDa
                    WHERE B.Email = '$user'";
  $resultFollow = mysqli_query($dbcon, $queryFollow)
        or die('Query failed: ' . mysqli_error($dbcon));

  // Can also check that there is only one tuple in the result
  $tupleFollow = mysqli_fetch_array($resultFollow)
           or die("User $user not found!");


  $table_content = "<ul><li>$tuple[0]</li><li>$tuple[1]</li><li>$tuple[2]</li><li>$tuple[3]</li><li>$tuple[4]</li>
                        <li><a href=\"list_follower.php\">Follower: $tupleFollowed[0]</a></li><li><a href=\"list_follows.php\">Follow: $tupleFollow[0]</a></li></ul>";


  // Free result
  mysqli_free_result($result);


  $query1 = "SELECT A.TweetID, A.TweetContents, A.address, C.UserName, C.UserID
                FROM Tweet A 
                JOIN Post B ON B.TweetID = A.TweetID
                JOIN User C ON B.UserID = C.UserID
                JOIN Follow D ON C.UserID = D.UserIDb 
                JOIN User E ON D.UserIDa = E.UserID
                  WHERE E.Email = '$user'";

  $result1 = mysqli_query($dbcon, $query1)
        or die('Query failed: ' . mysqli_error($dbcon));
  $tuple1 = mysqli_fetch_array($result1);
           

  /*<a class="navbar-brand" href=<?php echo "list_attrs.php?mail=". $_SESSION["currentUser"];?>>Homepage</a>    */

  $table_tweetcontent = "<tr>
                             <td><a href=\"list_tweetInfo.php?TweetID=$tuple1[0]\">$tuple1[0]</a></td>
                             <td>$tuple1[1]</td>
                             <td>$tuple1[2]</td>
                             <td>$tuple1[3]</td>
                             <td><a href=\"list_userInfo.php?UserID=$tuple1[4]\">$tuple1[4]</a></td>
                        </tr>";

  while ($tuple1 = mysqli_fetch_row($result1)) {
    $table_tweetcontent .= "<tr>
                                <td><a href=\"list_tweetInfo.php?TweetID=$tuple1[0]\">$tuple1[0]</a></td>
                                <td>$tuple1[1]</td>
                                <td>$tuple1[2]</td>
                                <td>$tuple1[3]</td>
                                <td><a href=\"list_userInfo.php?UserID=$tuple1[4]\">$tuple1[4]</a></td>
                            </tr>";
   }

   mysqli_free_result($result1);



  $query2 = "SELECT A.UserID, A.UserName, A.Sex, A.UserIntro, count(B.UserIDa)
             FROM User A 
             JOIN Follow B ON A.UserID = B.UserIDb
             GROUP BY B.UserIDa
             ORDER BY count(B.UserIDa) DESC
             LIMIT 5";

  $result2 = mysqli_query($dbcon, $query2)
        or die('Query failed: ' . mysqli_error($dbcon));
  $tuple2 = mysqli_fetch_array($result2)
           or die("User $user not found!");

 
  $table_usercontent = "<tr>
                          <td><a href=\"list_userInfo.php?UserID=$tuple2[0]\">$tuple2[0]</a></td>
                          <td>$tuple2[1]</td>
                          <td>$tuple2[2]</td>
                          <td>$tuple2[3]</td>
                          <td>$tuple2[4]</td>
                        </tr>";
     while ($tuple2 = mysqli_fetch_row($result2)) {
       $table_usercontent .= "<tr>
                            <td><a href=\"list_userInfo.php?UserID=$tuple2[0]\">$tuple2[0]</a></td>
                            <td>$tuple2[1]</td>
                            <td>$tuple2[2]</td>
                            <td>$tuple2[3]</td>
                            <td>$tuple2[4]</td>
                          </tr>";
  }


  mysqli_free_result($result2);

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
          margin-top: 10px;
        }
        th{
            
        }
        td{
            padding-right: 10px;
            font-size: 12px;
            word-break:break-all;
        }
        ul{
          font-size: 14px;
        }
        </style>
</head>
   
 <body>

  <div class="navbar navbar-inverse navbar-fixed-top">
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

      <div class ="col-lg-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
               <h3 class="panel-title">User Info</h3>
            </div>
  
            <div class="panel-body">
              <div class="alert alert-info">
                <strong> Connected successfully!</strong>
              </div>

              <div class = "detail">  
               
                
                <p style="font-size: 14px"><?php echo $table_content; ?></p>

              </div>  

            </div>
            <div class="panel-footer">

                <form method=get action="Login.html">
                  <input class = "btn btn-default" type="submit" value="Logout">
                </form>
            </div>   
        </div>
      </div>

      <div class ="col-lg-5">
           
           <div class="panel panel-primary">
            <div class="panel-heading">
               <h3 class="panel-title">Tweets</h3>
            </div>
  
            <div class="panel-body">
              <form class="form" role="form" method=get action="tweetDone.php">
              
                  <label class="control-label" for="inputLarge">new Tweet</label>
                  <textarea rows="3" class="form-control input-lg" name="content" type="text" id="inputLarge" placeholder="something cool happening?"></textarea>
                   <button  type="submit"  class="btn btn-info btn-lg" style="margin-top:10px">tweet</button>
             
              </form>
              <div class = "detail">  
                <table class = "table table-striped table-hover find-distribute" style="text-align:center" >
                  <tr>
                    <th style="text-align:center">Tweet ID</th>
                    <th style="text-align:center">Contents</th>
                    <th style="text-align:center">address</th>
                    <th style="text-align:center">User Name</th>
                    <th style="text-align:center">User ID</th>

                  </tr>
                  <tbody>
                    <?php echo $table_tweetcontent;?>
                  </tbody>
                </table>  
              </div>  

            </div>
             
           </div>
      </div>
      
      <div class ="col-lg-4">

            <div class="panel panel-primary">
            <div class="panel-heading">
               <h3 class="panel-title">Hot Users</h3>
            </div>
  
            <div class="panel-body">

              <div class = "detail">  
                <table class = "table table-striped table-hover find-distribute" style="text-align:center" >
                  <tr>
                    <th style="text-align:center">User ID</th>
                    <th style="text-align:center">User Name</th>
                    <th style="text-align:center">Sex</th>
                    <th style="text-align:center">UserIntro</th>
                    <th style="text-align:center">Follower Number</th>
                  </tr>
                  <tbody>
                    <?php echo $table_usercontent;?>
                  </tbody>
                </table> 

              </div> 

            </div>
              
            </div>
      </div>
    
    </div>
  </div>
<div>



</body>
  
</html>
