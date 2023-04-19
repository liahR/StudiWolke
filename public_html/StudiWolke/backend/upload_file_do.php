<?php
session_start();
if (!isset($_SESSION["BenutzerId"]))
{
    die ("Keine Autorisierung vorhanden");
}
else {
    if (isset($_GET["OrdnerId"])) {
        $OrdnerId = $_GET["OrdnerId"];
        $_SESSION["OrdnerId"] = $OrdnerId;
    }
}

$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; 
dbname=u-lr090', 'lr090', 'eetho6Choh',
    array('charset' => 'utf8'));
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>post_do</title>
    <link rel="stylesheet" type="text/css" href="meinstyle.css">
</head>
<body>
<?php

if(empty($_FILES["File"])){
    die("Achtung! Leere Datei");
}
if(empty($_FILES["File"]["name"])) {
    die("Achtung! Leere Datei");
}

//Dateityp abfrage png, jpg, jpeg, mp4, mov, mp3, wav, zip, doc, docx, txt, pdf, ppt, pptx, xls, xlsx, gif 

$type = pathinfo($_FILES ["File"]["name"], PATHINFO_EXTENSION);
$erlaubteaealer = array ("jpg", "jpeg", "png", "mp3", "mp4", "mov", "wav", "zip", "doc", "docx", "txt", "pdf", "ppt", "pptx", "xls", "xlsx", "gif"); 
if (!in_array(strtolower($typ), $erlaubteaealer)) {
    die ("Dateityp nicht erlaubt, nur jpg, jpeg, png, mp3, mp4, mov, wav, zip, doc, docx, txt, pdf, ppt, pptx, xls, xlsx, gif");
}


//Dateigröße abfragen 
if ($_FILES["File"]["size"]>5000000000){
    die ("Datei ist zu groß");
}

//zufälliger Name generieren
$filetyp = pathinfo ($_FILES["File"]["name"]);
$s='1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$s.="abcdefghijklmnopqrstuvwxyz";
$string='';
for ($i=0; $i<20; $i++){
    $index=rand(0, strlen($s)-1);
    $string.=$s[$index];
}
$string.=".".$filetyp;

//auf Server schieben
if (!move_uploaded_file($_FILES["File"]["tmp_name"], "/home/lr090/public_html/StudiWolke/frontend/dateien/".$string)){
    die ("Fehler bei der Übertragung");
}


//Pfad von der Datei
$dateipfad = "/home/lr090/public_html/StudiWolke/frontend/dateien/".$string

//weitere Daten übergeben $BenutzerId, $filetype, $Erstelldatum, $Änderungsdatum
$benutzerId = $_SESSION["benutzerId"];
$ordnerId = $_SESSION["ordnerId"];
$dateiname_original = $_FILES["Files"] ["name"];
$erstelldatum = date("Y-m-d");
$aenderungsdatum = date("Y-m-d");

//in DB einfügen 
$statement = $pdo->prepare("INSERT INTO dateien (benutzerId, ordnerId, dateipfad, dateiname_original, dateiname_zufall, dateityp, erstelldatum, 
aenderungsdatum) VALUES (:benutzerId, :ordnerId, :dateipfad, :dateiname_original, :dateiname_zufall, :dateityp, :erstelldatum, :aenderungsdatum)");

$statement->bindParam(':benutzerId', $benutzerId);
$statement->bindParam(':ordnerId', $ordnerId);
$statement->bindParam(':dateipfad', $dateipfad);
$statement->bindParam(':dateiname_original', $dateiname_original);
$statement->bindParam(':dateiname_zufall', $string);
$statement->bindParam(':dateityp', $filetype);
$statement->bindParam(':Erstelldatum', $erstelldatum);
$statement->bindParam(':Aenderungsdatum', $aenderungsdatum);

if($statement->execute())
{
    echo "Dein Post wurde erfolgreich der Startseite hinzugefügt";
}
else
{
    echo "Fehler bei der Ausführung aufgetreten";
}
?>
<p>
    <a href="../frontend/public/index.php">Zurück zur Startseite</a>
</p>
</body>
</html>