<?php
session_start();
if (!isset($_SESSION["benutzer_id"]))
{
    header("Location: ../frontend/public/login.html");
}
else {
    $benutzer_id = $_SESSION["benutzer_id"];
}

$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh',array('charset' => 'utf8'));




//Ich brauch den Pfad von der Datei von Person A 

//weitere Daten übergeben benutzer_id, datei_id, email von (GeteiltePerson), dateiname_original, dateipfad 
$datei_id = htmlspecialchars ($_POST ["datei_id"]);
$email=htmlspecialchars ($_POST ["GeteiltePersonen"]);
$dateiname_original=htmlspecialchars ($_POST ["dateiname_original"]);
$dateipfad=htmlspecialchars ($_POST ["Pfad"]);

//in DB einfügen 
$statement = $pdo->prepare("INSERT INTO teilen (benutzer_id, datei_id, email, dateiname_original, dateipfad) VALUES (:benutzer_id, :datei_id, :email, :dateiname_original, :dateipfad)");

$statement->bindParam(':benutzer_id', $benutzer_id);
$statement->bindParam(':datei_id', $datei_id);
$statement->bindParam(':email', $email);
$statement->bindParam(':dateiname_original', $dateiname_original);
$statement->bindParam(':dateipfad', $dateipfad);


if($statement->execute())
{
    header("Location: ../frontend/public/in_ordner.php");
}
else
{
    $errorInfo = $statement->errorInfo();
    echo "Fehler bei der Ausführung aufgetreten". $errorInfo[2];
    echo $ordner_id;
}

?>
