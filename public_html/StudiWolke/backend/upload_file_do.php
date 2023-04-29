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
if (!in_array(strtolower($type), $erlaubteaealer)) {
    die ("Dateityp nicht erlaubt, nur jpg, jpeg, png, mp3, mp4, mov, wav, zip, doc, docx, txt, pdf, ppt, pptx, xls, xlsx, gif");
}


//Dateigröße abfragen 
if ($_FILES["File"]["size"]>5000000000){
    die ("Datei ist zu groß");
}

//zufälliger Name generieren
$filename = pathinfo ($_FILES["File"]["name"]);
$s='1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$s.="abcdefghijklmnopqrstuvwxyz";
$string='';
for ($i=0; $i<20; $i++){
    $index=rand(0, strlen($s)-1);
    $string.=$s[$index];
}
$string.=".".$type;

//stimmt Pfad???
//auf Server schieben
if (!move_uploaded_file($_FILES["File"]["tmp_name"], "/home/lr090/public_html/StudiWolke/frontend/dateien/".$string)){
    die ("Fehler bei der Übertragung");
}

// Links müssen absolut sein mit http.mars.iuk,...... MIME Type digga 

//Pfad von der Datei
$dateipfad = "/home/lr090/public_html/StudiWolke/frontend/dateien/".$string;

//weitere Daten übergeben $benutzer_id, $filetype, $Erstelldatum, $Änderungsdatum

$ordner_id = htmlspecialchars ($_POST ["ordner_id"]);
$dateiname_original=htmlspecialchars ($_POST ["Dateiname"]);
$erstelldatum = date("Y-m-d");
$aenderungsdatum = $erstelldatum;

echo "Das ist die ID vom Ordner". $ordner_id;

//in DB einfügen 
$statement = $pdo->prepare("INSERT INTO dateien (benutzer_id, ordner_id, dateipfad, dateiname_original, dateiname_zufall, dateityp, erstelldatum, 
aenderungsdatum) VALUES (:benutzer_id, :ordner_id, :dateipfad, :dateiname_original, :dateiname_zufall, :dateityp, :erstelldatum, :aenderungsdatum)");

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
    echo "Dein Post wurde erfolgreich der Startseite hinzugefügt";
}
else
{
    $errorInfo = $statement->errorInfo();
    echo "Fehler bei der Ausführung aufgetreten". $errorInfo[2];
    echo $ordner_id;
}
?>
<p>
    <a href="../frontend/public/index.php">Zurück zur Startseite</a>
</p>
</body>
</html>