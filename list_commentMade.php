<?php

// Connection parameters 
$host = 'cspp53001.cs.uchicago.edu';
$username = 'xiaoyifan';
$password = '920127';
$database = $username.'DB';

// Attempting to connect
$dbcon = mysqli_connect($host, $username, $password, $database)
   or die('Could not connect: ' . mysqli_connect_error());
print 'Connected successfully!<br>';

// Getting the input parameter (user):
$user = $_REQUEST['user'];


// Get the attributes of the user with the given username
$query = "SELECT A.CommentID, A.CommentContent
FROM CommentsLarge A
JOIN MakeComment B ON B.CommentID = A.CommentID
JOIN Users C ON C.UserID = B.UserID
WHERE C.UserName = '$user'";

$result = mysqli_query($dbcon, $query)
  or die('Query failed: ' . mysqli_error($dbcon));

print "Users who commented the tweet <b>$user</b> is listed below:";


  
// Printing user attributes in HTML
while ( $tuple = mysqli_fetch_array($result, MYSQL_ASSOC)) 
{
	    print '<ul>';  
        print '<li> Comment ID: '.$tuple['CommentID'];
        print '<li> Comment Content: '.$tuple['CommentContent'];
        print '</ul>';
}


// Free result
mysqli_free_result($result);

// Closing connection
mysqli_close($dbcon);
?> 
