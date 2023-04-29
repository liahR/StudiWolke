<?php
session_start();
?>


<?php
$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; 
dbname=u-lr090', 'lr090', 'eetho6Choh',
    array('charset' => 'utf8'));



$nutzername=htmlspecialchars ($_POST ["nutzername"]);
$passwort=$_POST ["passwort"];


//kann das echo nicht raus????????
echo $nutzername.$passwort;

$statement = $pdo->prepare ('SELECT * FROM benutzer WHERE nutzername=:nutzername');
$statement->bindParam(':nutzername',$nutzername);

if ($statement->execute()) {
if ($row = $statement->fetch()){ 
    if (password_verify ($passwort, $row["passwort"]))
    {
        $_SESSION["benutzer_id"] = $row["benutzer_id"];
        header("Location: ../frontend/public/index.php");
    }
    else
    {
        echo "Passwort oder Nutzername falsch";
        echo "<p><a href= '../frontend/public/login.html'> Erneut versuchen</a></p>";
    }}
else
{
    echo "something went wrong";
}}
else {
    echo "Fehler";
}

