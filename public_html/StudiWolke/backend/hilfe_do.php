<?php
    session_start();
    // Prüfen ob Benutzer nicht eingeloggt ist  
    if (!isset($_SESSION["benutzer_id"]))
{
    header("Location: login.html");
}
else {
    $benutzer_id = $_SESSION["benutzer_id"];
}

// Verbindung zur Datenbank herstellen
$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de;dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset'=>'utf8'));

$email = htmlspecialchars ($_POST ["email"]);
$frage = htmlspecialchars ($_POST ["frage"]);

$empfaenger_email = "liahraimondo@yahoo.de";
$betreff = "Frage";


if (mail($empfaenger_email, $betreff, $frage, "From:". $email)) {
    header('Location: ../frontend/public/index.php');
} else {
    echo "Die Email konnte nicht versand werden";
}

?>
