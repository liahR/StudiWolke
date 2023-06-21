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

$vorname = htmlspecialchars ($_POST ["vorname"]);
$nachname = htmlspecialchars ($_POST ["nachname"]); 

$datei_id = htmlspecialchars ($_POST ["datei_id"]);
$empfaenger_email=htmlspecialchars ($_POST ["GeteiltePersonen"]);
$dateiname_original=htmlspecialchars ($_POST ["dateiname_original"]);
$dateipfad=htmlspecialchars ($_POST ["Pfad"]);

$betreff = "Anfrage zum Teilen";

#Formular um daten zu übergeben
$formular_ziel = "https://mars.iuk.hdm-stuttgart.de/~lr090/StudiWolke/backend/public/teilen_do.php";

$formular_html = '
    <form action="' . $formular_ziel . '" method="post">
        <input type="hidden" name="datei_id" value="' . $datei_id . '">
        <input type="hidden" name="dateiname_original" value="' . $dateiname_original . '">
        <input type="hidden" name="Pfad" value="' . $pfad . '" required><br>
        <input type="hidden" name="GeteiltePerson" value="' . $empfaenger_email . '">
        <button type="submit">Geteilte Datei annehmen</button>
    </form>
';

#Formular geht nicht andere Möglichkeit Parameter über URL übergeben?


if (mail($empfaenger_email, $betreff, $vorname . $nachname . "möchte eine datei mit dir Teilen", "Möchtest du sie annehmen?". $formular_html)) {
    header('Location: ../frontend/public/index.php');
} else {
    echo "Die Email konnte nicht versand werden";
}

?>
