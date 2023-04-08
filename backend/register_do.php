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

//zur Sicherheit Eingaben

$Vorname=htmlspecialchars ($_POST ["Vorname"]);
$Nachname=htmlspecialchars ($_POST ["Nachname"]);
$Email=htmlspecialchars ($_POST ["Email"]);
$Nutzername=htmlspecialchars ($_POST ["Nutzername"]);
$Passwort=htmlspecialchars ($_POST ["Passwort"]);


// Passwort hashen
$hashp= password_hash("$passwort", PASSWORD_BCRYPT);

//zur Sicherheit Bild 

if(empty($_FILES["Profilbild"])){
    die("Achtung! Leere Datei");
}
if(empty($_FILES["Profilbild"]["name"])) {
    die("Auchtung! Leere Datei");
}

$type = pathinfo($_FILES ["Profilbild"]["name"], PATHINFO_EXTENSION);
if (strtolower($type) !="jpg") {
    die ("nur .jpg erlaubt");
}

if ($_FILES["bild"]["size"]>800000){
    die ("Datei ist zu groß");
}

$s='1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$s.="abcdefghijklmnopqrstuvwxyz";
$string='';
for ($i=0; $i<20; $i++){
    $index=rand(0, strlen($s)-1);
    $string.=$s[$index];
}
$string.=".jpg";

if (!move_uploaded_file($_FILES["Profilbild"]["tmp_name"], "/home/lr090/public_html/StudiWolke/frontend/profilbilder/".$string)){
    die ("Fehler bei der Übertragung");
}



//Verbindung zur Datenbank
    $pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset' => 'utf8'));


$statement = $pdo->prepare("INSERT INTO Benutzer (Vorname, Nachname, Email, Nutzername, Passwort, Profilbild) 
VALUES (:Vorname, :Nachname, :Email, :Nutzername, :Passwort, :Profilbild)");

$statement->bindParam(':Vorname', $Vorname);
$statement->bindParam(':Nachname', $Nachname);
$statement->bindParam(':Email', $Email);
$statement->bindParam(':Nutzername', $Nutzername);
$statement->bindParam(':Passwort', $hashp);
$statement->bindParam(':Profilbild', $string);

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