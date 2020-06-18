<?php
require_once('./config.php');

$pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM travelimage WHERE ImageID >= (SELECT floor(RAND() * (SELECT MAX(ImageID) FROM travelimage))) ORDER BY ImageID LIMIT 6;";
$statement = $pdo->prepare($sql);
$statement->execute();

$imageNum = ($statement->rowCount() < 6) ? ($statement->rowCount()) : 6;

echo '{';

while ($row = $statement->fetch()) {
    $title = ($row['Title'] === NULL) ? '无' : $row['Title'];
    $description = ($row['Description'] === NULL) ? '无' : $row['Description'];

    echo '"' . $row['ImageID'] . '":{"title":"' . $title . '","description":"' . $description . '","PATH":"' . $row['PATH'] . '"}';
    $imageNum--;
    if ($imageNum === 0) {
        echo '}';
        break;
    }
    echo ',';
}


?>
