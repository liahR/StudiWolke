<?php
// Session starten 
session_start();
if (!isset($_SESSION["benutzer_id"]))
{
    header("Location: ../frontend/public/login.html");
}

$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh',array('charset' => 'utf8'));

$ordnername=htmlspecialchars ($_POST ["ordnername"]);
$erstelldatum = date("Y-m-d");

$statement = $pdo->prepare("INSERT INTO ordner (ordnername_original, erstelldatum) 
VALUES (:ordnername_original, :erstelldatum)");

$statement->bindParam(':ordnername_original', $ordnername);
$statement->bindParam(':erstelldatum', $erstelldatum);


// Bei erfolgreicher Ausführung, wird Info darüber ausgegeben.
if($statement->execute())
{
    echo "Ordner erstellt!";
}

// Wenn nicht, wird eine Info und eine Fehlermeldung ausgegeben.
else
{
    echo "Fehler ist aufgetreten";
    echo $statement->errorInfo()[2];
}

?>
