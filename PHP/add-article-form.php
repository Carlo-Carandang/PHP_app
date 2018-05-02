<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Article Form</title>
</head>
<body>
<form action="insert_article.php" method="post">
	<p>
    	<label for="title">Title:</label>
        <input type="text" name="TITLE" id="title">
    </p>
    <p>
    	<label for="pages">Pages:</label>
        <input type="text" name="PAGES" id="pages">
    </p>
    <p>
    	<label for="magazineid">Magazine ID:</label>
        <input type="number_format" name="MAGAZINE_ID" id="magazineid">
    </p>
    <p>
    	<label for="volumenumber">Volume Number:</label>
        <input type="number_format" name="VOLUME_NUMBER" id="volumenumber">
    </p>
    <p>
    	<label for="magazineyear">Year:</label>
        <input type="number_format" name="MAGAZINE_YEAR" id="magazineyear">
    </p>
    <p>
    	<label for="lastname">Author Last Name:</label>
        <input type="text" name="lname" id="lastname">
    </p>
    <p>
    	<label for="firstname">Author First Name:</label>
        <input type="text" name="fname" id="firstname">
    </p>
    <input type="submit" value="Add Records">
</form>
</body>
</html>