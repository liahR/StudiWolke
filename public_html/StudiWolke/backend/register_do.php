<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../frontend/public/allgemein.css">
    <link rel="stylesheet" type="text/css" href="../frontend/public/ansicht.css">
    <title>registrieren_do</title>
</head>
<body>

<?php

//zur Sicherheit Eingaben

$vorname=htmlspecialchars ($_POST ["vorname"]);
$nachname=htmlspecialchars ($_POST ["nachname"]);
$email=htmlspecialchars ($_POST ["email"]);
$nutzername=htmlspecialchars ($_POST ["nutzername"]);
$passwort= $_POST ["passwort"];


// Passwort hashen
$hashp= password_hash("$passwort", PASSWORD_BCRYPT);

//zur Sicherheit Bild 

if(empty($_FILES["profilbild"])){
    die("Achtung! Leere Datei");
}
if(empty($_FILES["profilbild"]["name"])) {
    die("Auchtung! Leere Datei");
}

$type = pathinfo($_FILES ["profilbild"]["name"], PATHINFO_EXTENSION);
$erlaubteaealer = array ("jpg", "jpeg", "png"); 
if (!in_array(strtolower($type), $erlaubteaealer)) {
    die ("Dateityp nicht erlaubt, nur jpg, jpeg, png. <a href='../frontend/public/register.html'>Erneut versuchen</a>");
}

if ($_FILES["profilbild"]["size"]>9000000){
    die ("Datei ist zu groß. <a href='../frontend/public/register.html'>Erneut versuchen</a>");
}

$s='1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$s.="abcdefghijklmnopqrstuvwxyz";
$string='';
for ($i=0; $i<20; $i++){
    $index=rand(0, strlen($s)-1);
    $string.=$s[$index];
}
$string.=".".$type;

if (!move_uploaded_file($_FILES["profilbild"]["tmp_name"], "/home/lr090/public_html/StudiWolke/frontend/profilbilder/".$string)){
    die ("Fehler bei der Übertragung");
}



//Verbindung zur Datenbank
    $pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset' => 'utf8'));


$statement = $pdo->prepare("INSERT INTO benutzer (vorname, nachname, email, nutzername, passwort, profilbild) 
VALUES (:vorname, :nachname, :email, :nutzername, :passwort, :profilbild)");

$statement->bindParam(':vorname', $vorname);
$statement->bindParam(':nachname', $nachname);
$statement->bindParam(':email', $email);
$statement->bindParam(':nutzername', $nutzername);
$statement->bindParam(':passwort', $hashp);
$statement->bindParam(':profilbild', $string);

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
<a href="../frontend/public/login.html">Zurück zum Login</a>
</body>
</html>