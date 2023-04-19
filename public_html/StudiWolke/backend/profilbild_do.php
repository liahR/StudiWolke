<?php
session_start();

if(!isset($_SESSION['benutzer_id'])) {
    // Benutzer ist nicht eingeloggt, Weiterleitung zur Login-Seite
    header("Location: login.html");
    exit();
}

if(!isset($_FILES['profilbild'])) {
    die('Es wurde keine Datei hochgeladen.');
}

$allowed_types = array('image/png', 'image/jpeg', 'image/gif');

if(!in_array($_FILES['profilbild']['type'], $allowed_types)) {
    die('Es sind nur folgende Dateiformate erlaubt: png, jpeg, gif');
}

$max_size = 5 * 1024 * 1024; // 5 MB

if($_FILES['profilbild']['size'] > $max_size) {
    die('Die Datei darf maximal 5 MB groß sein.');
}

// Verbindung zur Datenbank herstellen
$pdo = new PDO('mysql:host=mars.iuk.hdm-stuttgart.de;dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset'=>'utf8'));

if($pdo->connect_error) {
    die("Verbindung fehlgeschlagen: " . $pdo->connect_error);
}

// SQL-Abfrage zum Abrufen des Benutzers
$stmt = $pdo->prepare("SELECT * FROM benutzer WHERE benutzer_id=:benutzer_id");
$stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
$stmt->execute();
$benutzer = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$benutzer) {
    die('Benutzer nicht gefunden.');
}

// Profilbild löschen, falls vorhanden
if($benutzer['profilbild'] !== null) {
    unlink($benutzer['profilbild']);
}

// Dateinamen generieren
$file_extension = pathinfo($_FILES['profilbild']['name'], PATHINFO_EXTENSION);
$new_file_name = $_SESSION['benutzer_id'] . '_' . time() . '.' . $file_extension;

// Datei hochladen
move_uploaded_file($_FILES['profilbild']['tmp_name'], 'uploads/' . $new_file_name);

// SQL-Abfrage zum Aktualisieren des Benutzerprofils
$stmt = $pdo->prepare("UPDATE benutzer SET profilbild=:profilbild WHERE benutzer_id=:benutzer_id");
$stmt->bindValue(':profilbild', 'uploads/' . $new_file_name);
$stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
$stmt->execute();

// Verbindung zur Datenbank schließen
$pdo = null;

// Weiterleitung zur Account-Seite
header("Location: account.php");
exit();
?>