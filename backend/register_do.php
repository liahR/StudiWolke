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

$Vorname=htmlspecialchars ($_POST ["Vorname"]);
$Nachname=htmlspecialchars ($_POST ["Nachname"]);
$Email=htmlspecialchars ($_POST ["Email"]);
$Nutzername=htmlspecialchars ($_POST ["Nutzername"]);
$Passwort=htmlspecialchars ($_POST ["Passwort"]);
$Profilbild=htmlspecialchars ($_POST ["Profilbild"]);


// Passwort hashen
$hashp= password_hash("$passwort", PASSWORD_BCRYPT);


//Verbindung zur Datenbank
    $pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset' => 'utf8'));


$statement = $pdo->prepare("INSERT INTO Benutzer (Vorname, Nachname, Email, Nutzername, Passwort, Profilbild) 
VALUES (:Vorname, :Nachname, :Email, :Nutzername, :Passwort, :Profilbild)");

$statement->bindParam(':Vorname', $Vorname);
$statement->bindParam(':Nachname', $Nachname);
$statement->bindParam(':Email', $Email);
$statement->bindParam(':Nutzername', $Nutzername);
$statement->bindParam(':Passwort', $hashp);
$statement->bindParam(':Profilbild', $Profilbild);

// Bei erfolgreicher Ausführung, wird Info darüber ausgegeben.
if($statement->execute())
{
    echo "Willkommen! Du wurdest erfolgreich angemeldet";
}

// Wenn nicht, wird eine Info und eine Fehlermeldung ausgegeben.
else
{
    echo "Fehler bei der Anmeldung aufgetreten";
    echo $statement->errorInfo()[2];
}
?>
<!--Link zurück zum Login-->

<hr>
<a href="login.html">Zurück zum Login</a>
</body>
</html>