<?php
session_start();
?>


<?php
$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; 
dbname=u-lr090', 'lr090', 'eetho6Choh',
    array('charset' => 'utf8'));



$Nutzername=htmlspecialchars ($_POST ["nutzername"]);
$passwort=htmlspecialchars ($_POST ["passwort"]);

$statement = $pdo->prepare ('SELECT * FROM Benutzer WHERE Nutzername=:Nutzername');
$statement->bindParam(':Nutzername',$Nutzername);

$statement->execute();
if ($row = $statement->fetch()){
    if (password_verify($passwort, $row["passwort"]))
    {
        $_SESSION["id"] = $row["id"];
        header("Location: index.php");
    }
    else
    {
        echo "Passwort oder Login falsch";
        echo "<p><a href= 'login.html'>Erneut versuchen</a></p>";
    }}
else
{
    echo "something went wrong";
}

