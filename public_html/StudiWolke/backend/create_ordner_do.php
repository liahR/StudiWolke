<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Neuen Ordner erstellen</title>
</head>
<body>
<?php
session_start();
if(!isset($_POST["titel"]) | !isset($_POST["post"])){
    die("Formular-Fehler");
}

$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset' => 'utf8'));

$titel = htmlspecialchars($_POST["titel"]);
$post = htmlspecialchars($_POST["post"]);

if(empty($_FILES["files"])) {
    die("Problem in der Datei");
}

if(empty($_FILES["files"]["name"])){
    die("Problem in der Datei");
}
$ext= pathinfo($_FILES["files"]["name"], PATHINFO_EXTENSION);
if($ext!="jpg"){
    die("falscher Dateityp");
}
if($_FILES["files"]["size"]>9000000) {
    die("Datei zu groß");
}

$a='1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$a.='abcdefghijklmnopqrstuvwxyz';
$pfad='';
for ($i=0; $i<20; $i++) {
$index=rand(0, strlen($a) - 1);
$pfad.=$a[$index];
$pfad.=".jpg";

if(!move_uploaded_file($_FILES["files"]["tmp_name"], "/home/jk263/public_html/blog1/uploads/".$pfad)) {
    die("Fehler bei der Übertragung");}


    $statement = $pdo->prepare("INSERT INTO posts (titel, post, files) VALUES (:titel, :post, :files)");
    $statement->bindParam(":titel", $titel);
    $statement->bindParam(":post", $post);
    $statement->bindParam(":files", $pfad);

    if ($statement->execute()) {
        header('Location: index.php');
    }}


?>
</body>
</html>
