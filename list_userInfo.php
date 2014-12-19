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
$userid= $_REQUEST['UserID'];
$mail = $_SESSION['currentUser'];

$_SESSION['clientUser']= $userid;


$query = "SELECT Email, UserName, Sex, UserIntro, birth FROM User WHERE UserID = '$userid'";

$result = mysqli_query($dbcon, $query)
  or die('Query failed: ' . mysqli_error($dbcon));

 // Can also check that there is only one tuple in the result
$tuple = mysqli_fetch_array($result)
           or die("User $user not found1!");


$content = "<ul>
                  <li>Email: $tuple[0]</li>
                  <li>User Name: $tuple[1]</li>
                  <li>Sex: $tuple[2]</li>
                  <li>Intro: $tuple[3]</li>
                  <li>Date of Birth: $tuple[4]</li>
            </ul>";


 $user_label = "User $tuple[1] info";
 $message_sent = "Message sent to $tuple[1]";
 $message_receive = "Message received from $tuple[1]";


mysqli_free_result($result);


$query_sent = "SELECT A.MessageID, A.MessageContents, A.time
                FROM Message A
                join Sending B ON B.MessageID = A.MessageID
                join User C ON C.UserID = B.SenderID
                WHERE C.Email = '$mail' and B.ReceiverID = '$userid'";

$result_sent = mysqli_query($dbcon, $query_sent)
  or die('Query failed: ' . mysqli_error($dbcon));

$tuple_sent =mysqli_fetch_array($result_sent);



$content_sent = "<tr><td>$tuple_sent[0]</td><td>$tuple_sent[1]</td><td>$tuple_sent[2]</td></tr>";
 while ($tuple_sent = mysqli_fetch_row($result_sent)) {
    $content_sent .= "<tr><td>$tuple_sent[0]</td><td>$tuple_sent[1]</td><td>$tuple_sent[2]</td></tr>";
 }

mysqli_free_result($result_sent);



$query_receive = "SELECT A.MessageID, A.MessageContents, A.time
                FROM Message A
                join Sending B ON B.MessageID = A.MessageID
                join User C ON C.UserID = B.ReceiverID
                WHERE C.Email = '$mail' and B.SenderID = '$userid'";

$result_receive = mysqli_query($dbcon, $query_receive)
  or die('Query failed: ' . mysqli_error($dbcon));

$tuple_receive =mysqli_fetch_array($result_receive);



$content_receive = "<tr><td>$tuple_receive[0]</td><td>$tuple_receive[1]</td><td>$tuple_receive[2]</td></tr>";
 while ($tuple_receive = mysqli_fetch_row($result_receive)) {
    $content_receive .= "<tr><td>$tuple_receive[0]</td><td>$tuple_receive[1]</td><td>$tuple_receive[2]</td></tr>";
 }

mysqli_free_result($result_receive);



$queryUser = "SELECT UserID from User
              where Email = '$mail'";

$resultUser = mysqli_query($dbcon, $queryUser)
  or die('Query failed: ' . mysqli_error($dbcon));

 // Can also check that there is only one tuple in the result
$tupleUser = mysqli_fetch_array($resultUser)
           or die("User $user not found1!");

mysqli_free_result($resultUser);


$hostid = $tupleUser[0];

$query_follow = "SELECT COUNT(*) from Follow
                where UserIDa = '$hostid' and UserIDb = '$userid'";

$result_follow = mysqli_query($dbcon, $query_follow)
  or die('Query failed: ' . mysqli_error($dbcon));

 // Can also check that there is only one tuple in the result
$tuple_follow = mysqli_fetch_array($result_follow)
           or die("User $user not found1!");

mysqli_free_result($result_follow);             
//tupleStatus[0] is the number of results found in the query

$followCount = $tuple_follow[0];
echo $followCount;


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

      <div class ="col-lg-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
               <h3 class="panel-title"><?php echo $user_label;?></h3>
            </div>
  
            <div class="panel-body">
             

              <div class = "detail">  
                
                  <p style="font-size: 18px"><?php echo $content; ?></p>

              </div>  

            </div>
            
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
               <h3 class="panel-title"><?php echo $message_sent;?></h3>
            </div>
  
            <div class="panel-body">

              <div class = "detail">  
                
                <table class = "table table-striped table-hover find-distribute" style="text-align:center" >
                  <tr>
                    <th style="text-align:center">Message ID</th>
                    <th style="text-align:center">Message Content</th>
                    <th style="text-align:center">time</th>
                  </tr>
                  <tbody>
                    <?php echo $content_sent; ?>
                  </tbody>
                </table> 
                
              </div>  

            </div>
            
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
               <h3 class="panel-title"><?php echo $message_receive;?></h3>
            </div>
  
            <div class="panel-body">

              <div class = "detail">  
                
                  <table class = "table table-striped table-hover find-distribute" style="text-align:center" >
                  <tr>
                    <th style="text-align:center">Message ID</th>
                    <th style="text-align:center">Message Content</th>
                    <th style="text-align:center">time</th>
                  </tr>
                  <tbody>
                    <?php echo $content_receive; ?>
                  </tbody>
                </table> 

              </div>  

            </div>
            
        </div>

      </div>
      <div class ="col-lg-3">
        <div class="panel panel-success">
            <div class="panel-heading">
               <h3 class="panel-title">You may like to</h3>
            </div>
  
            <div class="panel-body"> 
              <div class = "detail">   
                <div class = "row">  
                  <form class="form" role="form" method=get action="sentMessage.php">
                    <label class="control-label" for="inputLarge">new message</label>
                    <textarea rows="2" class="form-control input-lg" name="message" type="text" id="inputLarge" placeholder="message"></textarea>
                     <button  type="submit"  class="btn btn-success btn-lg" style="margin-top:10px">sent</button>
                  </form>
                </div>
              </div>  
            </div>
            
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
               <h3 class="panel-title">Or like to</h3>
            </div>
  
            <div class="panel-body">
                <div class = "detail">  
                    <div class = "row">                  
                        <form class="form" role="form" method=get action="updateFollow.php">                
                          <label class="checkbox">
                              <input type="checkbox" value="yes" name="checkFollow" data-toggle="checkbox" 
                              <?php
                                if ($followCount != '0') {
                                  echo "checked";
                                }
                              
                               ?>>
                              Follow
                          </label>
                          <button  type="submit"  class="btn btn-success btn-lg" style="margin-top:10px">update</button>
                        </form>
                    </div>
                </div>  
            </div>
            
        </div>



      </div>
    
    </div>
  </div>
</div>

        <script src="js/jquery-1.8.3.min.js"></script>
        <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="js/jquery.ui.touch-punch.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap-select.js"></script>
        <script src="js/bootstrap-switch.js"></script>
        <script src="js/flatui-checkbox.js"></script>
        <script src="js/flatui-radio.js"></script>
        <script src="js/jquery.tagsinput.js"></script>
        <script src="js/jquery.placeholder.js"></script>
        <!-- datepicker -->
        <script type="text/javascript" src="bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
        <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>


</body>

</html>


