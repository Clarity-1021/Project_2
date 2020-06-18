<?php
require_once('./config.php');

$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM geocities WHERE CountryCodeISO=:iso ORDER BY AsciiName";
$statement = $pdo->prepare($sql);
$statement->bindValue(':iso',$_GET['country']);
$statement->execute();

$len = $statement->rowCount();
echo '{';
for ($i = 1; $i < $len; $i++){
    $row = $statement->fetch();
    echo '"' . $row['GeoNameID'] . '":"' . $row['AsciiName'] . '",';
}
$row = $statement->fetch();
echo '"' . $row['GeoNameID'] . '":"' . $row['AsciiName'] . '"';
echo '}'

?>
