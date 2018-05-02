<!DOCTYPE html>
<html>
    <head>
        <title>Get Authors</title>
        <link rel="stylesheet" href="css/table.css" type="text/css" />
    </head>
    <body>
        <?php

require("/home/course/cda540/cda54058/dbguest.php");

$link = mysqli_connect($host, $user, $pass);
if (!$link) die("Couldn't connect to MySQL");

mysqli_select_db($link, $db)
	or die("Couldn't open $db: ".mysqli_error($link));

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            // execute the stored procedure
            $sql = 'CALL GetAuthors()';
            // call the stored procedure
            $q = $pdo->query($sql);
            $q->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error occurred:" . $e->getMessage());
        }
        ?>
        <table>
            <tr>
                <th>Author Last Name</th>
                <th>Author First Name</th>
            </tr>
            <?php while ($r = $q->fetch()): ?>
                <tr>
                    <td><?php echo $r['lname'] ?></td>
                    <td><?php echo $r['fname'] ?></td>
                </tr>
            <?php endwhile;

mysqli_close($link); 

	?>
        </table>
    </body>
</html>

