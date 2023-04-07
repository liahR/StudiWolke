<?php
$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset' => 'utf8'));
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>registrieren_do</title>
</head>
<body>

<?php

//zur Sicherheit 
$id=htmlspecialchars ($_POST ["id"]);
$Vorname=htmlspecialchars ($_POST ["Vorname"]);
$Nachname=htmlspecialchars ($_POST ["Nachname"]);
$Email=htmlspecialchars ($_POST ["Email"]);
$Nutzername=htmlspecialchars ($_POST ["Nutzername"]);
$passwort=htmlspecialchars ($_POST ["Passwort"]);
$hashp= password_hash("$passwort", PASSWORD_BCRYPT);


$statement = $pdo->prepare("INSERT INTO Benutzer (BenutzerId, Vorname, Nachname, Email, Nutzername, Passwort) VALUES (:BenutzerId, :Vorname, :Nachname, :Email, :Nutzername, :Passwort)");

$statement->bindParam(':BenutzerId', $id);
$statement->bindParam(':Vorname', $Vorname);
$statement->bindParam(':Nachname', $Nachname);
$statement->bindParam(':Email', $Email);
$statement->bindParam(':Nutzername', $Nutzername);
$statement->bindParam(':Passwort', $hashp);

if($statement->execute())
{
    echo "Du wurdest erfolgreich angemeldet";
}
else
{
    echo "Fehler bei der Anmeldung aufgetreten";
    echo $statement->errorInfo()[2];
}
?>
<p>
    <a href="index.php">Zur Startseite</a>
</p>
</body>
</html>