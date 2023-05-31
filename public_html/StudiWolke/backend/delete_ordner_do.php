<?php
    session_start();
    // Prüfen ob Benutzer nicht eingeloggt ist  
    if (!isset($_SESSION["benutzer_id"]))
{
    header("Location: login.html");
}

$pdo  =new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090','eetho6Choh', array('charset'=>'utf8'));

$ordner_id = $_POST["ordner_id"];

//Ordner aus Datenbank löschen
$statement = $pdo->prepare("DELETE FROM ordner WHERE ordner_id = :ordner_id");
$statement->bindParam(':ordner_id', $ordner_id);

if($statement->execute()){
    header('Location: ../frontend/public/index.php');
}else{
    echo "Datenbank-Fehler";
    echo $statement->errorInfo()[2];
}

//Dateien aus Datenbank löschen
$statement = $pdo->prepare("DELETE FROM dateien WHERE ordner_id = :ordner_id");
$statement->bindParam(':ordner_id', $ordner_id);

if($statement->execute()){
    header('Location: ../frontend/public/index.php');
}else{
    echo "Datenbank-Fehler";
    echo $statement->errorInfo()[2];
}
?>