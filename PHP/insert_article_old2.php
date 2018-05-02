<html>
<head>
<title>
insert_article.php
</title>
</head>
<body>

<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

require("/home/course/cda540/cda54058/dbguest.php");

$link = mysqli_connect($host, $user, $pass);
if (!$link) die("Couldn't connect to MySQL");

mysqli_select_db($link, $db)
	or die("Couldn't open $db: ".mysqli_error($link));
 
// Escape user inputs for security
$TITLE = mysqli_real_escape_string($link, $_REQUEST['TITLE']);
$PAGES = mysqli_real_escape_string($link, $_REQUEST['PAGES']);
$MAGAZINE_ID = mysqli_real_escape_string($link, $_REQUEST['MAGAZINE_ID']);
$VOLUME_NUMBER = mysqli_real_escape_string($link, $_REQUEST['VOLUME_NUMBER']);
$MAGAZINE_YEAR = mysqli_real_escape_string($link, $_REQUEST['MAGAZINE_YEAR']);
$lname = mysqli_real_escape_string($link, $_REQUEST['lname']);
$fname = mysqli_real_escape_string($link, $_REQUEST['fname']);

// attempt insert query execution
$sql = "INSERT INTO ARTICLE (TITLE, PAGES) VALUES ('$TITLE', '$PAGES')";
if(mysqli_query($link, $sql)){
    echo "ARTICLE records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
$sql = "INSERT INTO MAGAZINE_VOLUME (MAGAZINE_ID, VOLUME_NUMBER, MAGAZINE_YEAR) VALUES ('$MAGAZINE_ID', '$VOLUME_NUMBER', '$MAGAZINE_YEAR')";
if(mysqli_query($link, $sql)){
    echo "MAGAZINE_VOLUME records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$sql = "INSERT INTO AUTHOR (lname, fname) VALUES ('$lname', '$fname')";
if(mysqli_query($link, $sql)){
    echo "AUTHOR records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}


$sql = "INSERT INTO ARTICLE_AUTHORS (ARTICLE_ID, AUTHOR_ID) VALUES ((NEW.article_Id FROM ARTICLE), LAST_INSERT_ID())";
if(mysqli_query($link, $sql)){
    echo "ARTICLE_AUTHORS records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$sql = "INSERT INTO MAGAZINE_ARTICLE (ARTICLE_ID, MAGAZINE_ID, VOLUME_NUMBER) VALUES ((NEW.article_Id FROM ARTICLE), (NEW.MAGAZINE_ID FROM MAGAZINE_VOLUME), (NEW.VOLUME_NUMBER FROM MAGAZINE_VOLUME))";
if(mysqli_query($link, $sql)){
    echo "MAGAZINE_ARTICLE records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}


// close connection
mysqli_close($link);
?>

<p>
<a href="main.php"> back to MAIN menu</a>

</body>
</html>