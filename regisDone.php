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
$email = $_REQUEST['email'];
$name = $_REQUEST['name'];
$sex = $_REQUEST['sex'];
$intro = $_REQUEST['intro'];
$intro = htmlspecialchars($intro, ENT_QUOTES);
$password = $_REQUEST['password'];
$dateofbirth = $_REQUEST['dateofbirth'];

// Get the attributes of the user with the given username
//INSERT INTO users(id, name, age) VALUES(123, 'XYZ', 25);

$q = "SELECT COUNT(*) from User";
$re = mysqli_query($dbcon, $q)
  or die('Query failed: ' . mysqli_error($dbcon));
$tu = mysqli_fetch_row($re);

mysqli_free_result($re);

$tu[0] = $tu[0]+1;

$query = "INSERT INTO User(UserID, UserName,Sex,UserIntro, password, Email, birth)
          VALUES('$tu[0]', '$name', '$sex', '$intro', '$password', '$email','$dateofbirth')";

$_SESSION["currentUser"] = $email;

$result = mysqli_query($dbcon, $query)
  or die('Query failed: ' . mysqli_error($dbcon));


 $user_label = "New User Info";

 $content = "<ul>
                  <li>User ID: $tu[0]</li>
                  <li>User name: $name</li>
                  <li>User Gender: $sex</li>
                  <li>User Intro: $intro</li>
                  <li>password: $password</li>
                  <li>User Email(ID to login): $email</li>
                  <li>Date of Birth: $dateofbirth</li>
            </ul>";


// Free result

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
                <strong> Registration successfully!</strong>
              </div>

              <div class = "detail">  
                
                  <p style="font-size: 18px"><?php echo $content; ?></p>

                  <p>Hit the link below to login:</p>
                  <a href="Login.html">Login</a>
              </div>  

            </div>
            
        </div>
      </div>
    
    </div>
  </div>
</div>
</body>

</html>


