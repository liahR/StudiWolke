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

if(empty($_FILES["File"])){
    die("Achtung! Leere Datei");
}
if(empty($_FILES["File"]["name"])) {
    die("Achtung! Leere Datei");
}

//Dateityp abfrage png, jpg, jpeg, mp4, mov, mp3, wav, zip, doc, docx, txt, pdf, ppt, pptx, xls, xlsx, gif 

$type = pathinfo($_FILES ["File"]["name"], PATHINFO_EXTENSION);
$erlaubteaealer = array ("jpg", "jpeg", "png", "mp3", "mp4", "mov", "wav", "zip", "doc", "docx", "txt", "pdf", "ppt", "pptx", "xls", "xlsx", "gif"); 
if (!in_array(strtolower($type), $erlaubteaealer)) {
    die ("Dateityp nicht erlaubt, nur jpg, jpeg, png, mp3, mp4, mov, wav, zip, doc, docx, txt, pdf, ppt, pptx, xls, xlsx, gif");
}


//Dateigröße abfragen 
if ($_FILES["File"]["size"]>5000000000){
    die ("Datei ist zu groß");
}

//Ich brauch den Pfad von der Datei von Person A 

//weitere Daten übergeben benutzer_id, datei_id, email von (GeteiltePerson), dateiname_original, dateipfad 
$datei_id = htmlspecialchars ($_POST ["datei_id"]);
$email=htmlspecialchars ($_POST ["GeteiltePersonen"]);
$dateiname_original=htmlspecialchars ($_POST ["dateiname_original"]);
$dateipfad=htmlspecialchars ($_POST ["Pfad"]);

//in DB einfügen 
$statement = $pdo->prepare("INSERT INTO teilen (benutzer_id, datei_id, email, dateiname_original, dateipfad) VALUES (:benutzer_id, :datei_id, :email, :dateiname_original, :dateipfad)");

$statement->bindParam(':benutzer_id', $benutzer_id);
$statement->bindParam(':ordner_id', $ordner_id);
$statement->bindParam(':dateipfad', $dateipfad);
$statement->bindParam(':dateiname_original', $dateiname_original);
$statement->bindParam(':dateiname_zufall', $string);
$statement->bindParam(':dateityp', $type);
$statement->bindParam(':erstelldatum', $erstelldatum);
$statement->bindParam(':aenderungsdatum', $aenderungsdatum);

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
