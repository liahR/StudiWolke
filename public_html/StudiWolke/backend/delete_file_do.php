<?php
session_start();
if(!isset($_SESSION["login"])){
    header("Location: login.html");
}
if(!isset($_GET["DateiId"])){
    die("Link-Fehler");
}
$pdo  =new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090','eetho6Choh', array('charset'=>'utf8'));
$statement = $pdo->prepare("DELETE FROM Dateien WHERE DateiId=?");
if($statement->execute(array($_GET["DateiId"]))){
    header('Location: in_ordner.php');
}else{
    echo "Datenbank-Fehler";
    echo $statement->errorInfo()[2];
}
