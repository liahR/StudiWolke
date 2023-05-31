<?php
    session_start();
    // Prüfen ob Benutzer nicht eingeloggt ist  
    if (!isset($_SESSION["benutzer_id"]))
{
    header("Location: login.html");
}

$pdo  =new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090','eetho6Choh', array('charset'=>'utf8'));

$teilen_id = $_POST["teilen_id"];

//Dateien aus Datenbank löschen
$statement = $pdo->prepare("DELETE FROM teilen WHERE teilen_id = :teilen_id");
$statement->bindParam(':teilen_id', $teilen_id);

if($statement->execute()){
    header('Location: ../frontend/public/in_geteilt.php');
}else{
    echo "Datenbank-Fehler";
    echo $statement->errorInfo()[2];
}
?>