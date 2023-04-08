<?php
session_start();
?>


<?php
$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; 
dbname=u-lr090', 'lr090', 'eetho6Choh',
    array('charset' => 'utf8'));



$Nutzername=htmlspecialchars ($_POST ["Nutzername"]);
$Passwort=htmlspecialchars ($_POST ["Passwort"]);

$statement = $pdo->prepare ('SELECT * FROM Benutzer WHERE Nutzername=:Nutzername');
$statement->bindParam(':Nutzername',$Nutzername);

$statement->execute();
if ($row = $statement->fetch()){
    if (password_verify($Passwort, $row["Passwort"]))
    {
        $_SESSION["BenutzerId"] = $row["BenutzerId"];
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
}

