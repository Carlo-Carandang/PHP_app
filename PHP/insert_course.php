<html>
<head>
<title>
insert_emp.php
</title>
</head>

<body>

<?php

$cname = $_POST["cname"];
$cnum = $_POST["cnum"];
$chours = $_POST["chours"];
$cdept = $_POST["cdept"];


require("/home/course/cda540/cda54072/dbguest.php");
$table = "COURSE";

$link = mysqli_connect($host, $user, $pass);
if (!$link) die("Couldn't connect to MySQL");

mysqli_select_db($link, $db)
        or die("Couldn't open $db: ".mysqli_error($link));

if (strlen($cname)==0 || strlen($cnum)==0)
	print "<p><p>!!! Cannot add a new course with empty name or number !!!";
else {
    if (strlen($chours)==0) $chours = "null";
#   else $chours = "\"$chours\"";   # would also work with this
    if (strlen($cdept)==0) $cdept = "null";
    else $cdept = "\"$cdept\"";
    $query = "insert into $table values";
    $query = $query."(\"$cname\", \"$cnum\", $chours, $cdept)";

    print "$query<p>";

    $ok = mysqli_query($link, $query);
    if (!$ok) print "SQL error: ".mysqli_error($link);
}

mysqli_close($link);

print "<p><p>Connection closed."
?>

<p>
<a href="main.php"> back to MAIN menu </a>

</body>

</html>
