<?php
session_start();
if(!isset($_SESSION["login"])){
    header("Location: login.html");
}
if(!isset($_GET["OrdnerId"])){
    die("Link-Fehler");
}
$pdo  =new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090','eetho6Choh', array('charset'=>'utf8'));
$statement = $pdo->prepare("DELETE FROM Ordner WHERE OrdnerId=?");
if($statement->execute(array($_GET["OrdnerId"]))){
    header('Location: index.php');
}else{
    echo "Datenbank-Fehler";
    echo $statement->errorInfo()[2];
}
