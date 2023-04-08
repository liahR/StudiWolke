<?php
session_start();
if (!isset($_SESSION["BenutzerId"]))
{
    die ("Keine Autorisierung vorhanden");
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

if(empty($_FILES["file"])){
    die("Achtung! Leere Datei");
}
if(empty($_FILES["file"]["name"])) {
    die("Achtung! Leere Datei");
}

//Dateityp abfrage png, jpg, jpeg, mp4, mov, mp3, wav, zip, doc, docx, txt, pdf, ppt, pptx, xls, xlsx, gif 

$type = pathinfo($_FILES ["file"]["name"], PATHINFO_EXTENSION);
if (strtolower($type) !="jpg") {
   elseif (strtolower($type) !="jpeg") {
        elseif (strtolower($type) !="png") {
            elseif (strtolower($type) !="mp3") {
                elseif (strtolower($type) !="mp4") {
                    elseif (strtolower($type) !="mov") {
                        elseif (strtolower($type) !="wav") {
                            elseif (strtolower($type) !="zip") {
                                elseif (strtolower($type) !="doc") {
                                    elseif (strtolower($type) !="docx") {
                                        elseif (strtolower($type) !="txt") {
                                            elseif (strtolower($type) !="pdf") {
                                                elseif (strtolower($type) !="ppt") {
                                                    elseif (strtolower($type) !="pptx") {
                                                        elseif (strtolower($type) !="xls") {
                                                            elseif (strtolower($type) !="xlsx") {
                                                                elseif (strtolower($type) !="gif") {
                                                                    die ("Dateityp nicht erlaubt")
                                                                }}}}}}}}}}}}}}}}


//Dateigröße abfragen 
if ($_FILES["file"]["size"]>5000000000){
    die ("Datei ist zu groß");
}

$filetyp = pathinfo ($_FILES["uploadfile"]["name"]);
$s='1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$s.="abcdefghijklmnopqrstuvwxyz";
$string='';
for ($i=0; $i<20; $i++){
    $index=rand(0, strlen($s)-1);
    $string.=$s[$index];
}
$string.="."$filetyp;

if (!move_uploaded_file($_FILES["files"]["tmp_name"], "/home/lr090/public_html/blog/Bilder/".$string)){
    die ("Fehler bei der Übertragung");
}


$statement = $pdo->prepare("INSERT INTO Dateien (titel, post, bild) VALUES (:titel, :post, :bild)");

$statement->bindParam(':titel', $titel);
$statement->bindParam(':post', $post);
$statement->bindParam(':bild', $string);

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
    <a href="index.php">Zurück zur Startseite</a>
</p>
</body>
</html>