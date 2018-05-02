<html>
<head>
<title>
print_sp.php
</title>
</head>
<body>

<?php

function prtable($table) {
	print "<table border=1>\n";
	while ($a_row = mysqli_fetch_row($table)) {
		print "<tr>";
		foreach ($a_row as $field) print "<td>$field</td>";
		print "</tr>";
	}
	print "</table>";
}

require("/home/course/cda540/cda54058/dbguest.php");

$link = mysqli_connect($host, $user, $pass, $db);
if (!$link) die("Couldn't connect to MySQL");
print "Successfully connected to server<p>";

mysqli_select_db($link, $db)
	or die("Couldn't open $db: ".mysqli_error($link));
#print "Successfully selected database \"$db\"<p>";

$table = "sp";
$result = mysqli_query($link, "select * from $table");
$num_rows = mysqli_num_rows($result);
print "There are $num_rows rows in the table<p>";

prtable($result);

mysqli_close($link);

print "<p><p>Connection closed. Bye..."
?>

<p>
<a href="main.php"> back to MAIN menu</a>
</body>

</html>

