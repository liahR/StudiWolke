<?php
// Verbindung zur Datenbank herstellen
$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de;dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset'=>'utf8'));

if ($pdo->connect_error) {
    die("Verbindung fehlgeschlagen: " . $pdo->connect_error);
}

// Prüfen, ob das Formular abgeschickt wurde
if (isset($_POST['submit'])) {
    // Frage in die Datenbank einfügen
    $frage = $_POST['frage'];
    $query = "INSERT INTO Fragen (Frage) VALUES (:frage)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':frage', $frage);
    
    if ($stmt->execute()) {
        echo "<p>Vielen Dank, deine Frage wurde erfolgreich gespeichert.</p>";
    } else {
        echo "<p>Beim Speichern deiner Frage ist ein Fehler aufgetreten. " . $pdo->error . "</p>";
    }
}