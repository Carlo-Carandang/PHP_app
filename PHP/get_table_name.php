<html>
<head>
<title>
get_table_name.php
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

$link = mysqli_connect($host, $user, $pass);
if (!$link) die("Couldn't connect to MySQL");

mysqli_select_db($link, $db)
	or die("Couldn't open $db: ".mysqli_error($link));

$result = mysqli_query($link, "show tables");
$num_rows = mysqli_num_rows($result);
print "There are $num_rows tables in the database<p>";

prtable($result);

mysqli_close($link);

?>



<form action="print_table.php" method="POST">
<b>Enter the name of the table you want to post:</b>
<input type="text" name="table">
<p>
<input type="submit" value="submit">
</form>

<p>
<a href="main.php"> back to MAIN menu</a>

</body>
</html>

