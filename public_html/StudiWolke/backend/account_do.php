<?php
session_start();

// Prüfen, ob Benutzer eingeloggt ist
if(!isset($_SESSION['benutzer_id'])) {
	// Benutzer ist nicht eingeloggt, Weiterleitung zur Login-Seite
	header("Location: login.html");
	exit();
}

// Verbindung zur Datenbank herstellen
$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset'=>'utf8'));
if ($pdo->connect_error) {
	die("Verbindung fehlgeschlagen: " . $pdo->connect_error);
}

// SQL-Abfrage zum Abrufen der Benutzerdaten
$stmt = $pdo->prepare("SELECT * FROM benutzer WHERE benutzer_id=:benutzer_id");
$stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
$stmt->execute();
$benutzer = $stmt->fetch(PDO::FETCH_ASSOC);

// Verarbeitung der Formulardaten
if (isset($_POST['submit'])) {
	$vorname = isset($_POST['vorname']) ? trim($_POST['vorname']) : '';
	$nachname = isset($_POST['nachname']) ? trim($_POST['nachname']) : '';
	$email = isset($_POST['email']) ? trim($_POST['email']) : '';
	$nutzername = isset($_POST['nutzername']) ? trim($_POST['nutzername']) : '';
	$passwort = isset($_POST['passwort']) ? trim($_POST['passwort']) : '';
	
	// Überprüfen, ob ein Profilbild hochgeladen wurde
	if(isset($_FILES['profilbild']) && $_FILES['profilbild']['error'] === 0) {
		// Pfad zum temporären Upload-Verzeichnis
		$tmp_path = $_FILES['profilbild']['tmp_name'];
		// Pfad zum Zielverzeichnis (in diesem Beispiel der Ordner "uploads" im selben Verzeichnis wie die PHP-Datei)
		$target_path = dirname(__FILE__) . '/uploads/' . basename($_FILES['profilbild']['name']);
		// Datei in Zielverzeichnis verschieben
		if(move_uploaded_file($tmp_path, $target_path)) {
			// Datei erfolgreich hochgeladen, Pfad in Datenbank speichern
			$stmt = $pdo->prepare("UPDATE benutzer SET profilbild=:profilbild WHERE benutzer_id=:benutzer_id");
			$stmt->bindValue(':profilbild', $target_path);
			$stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
			$stmt->execute();
			$benutzer['profilbild'] = $target_path;
		} else {
			// Fehler beim Hochladen der Datei
			$error_msg = 'Fehler beim Hochladen des Profilbilds.';
		}
	}
	
	// Überprüfen, ob Vorname geändert wurde
	if(!empty($vorname) && $vorname !== $benutzer['vorname']) {
		$stmt = $pdo->prepare("UPDATE benutzer SET vorname=:vorname WHERE benutzer_id=:benutzer_id");
		$stmt->bindValue(':vorname', $vorname);
		$stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
		$stmt->execute();
		$benutzer['vorname'] = $vorname;
    }
    // Überprüfen, ob Nachname geändert wurde
    if(!empty($nachname) && $nachname !== $benutzer['nachname']) {
	    $stmt = $pdo->prepare("UPDATE benutzer SET nachname=:nachname WHERE benutzer_id=:benutzer_id");
	    $stmt->bindValue(':nachname', $nachname);
	    $stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
	    $stmt->execute();
	    $benutzer['nachname'] = $nachname;
    }

    // Überprüfen, ob E-Mail-Adresse geändert wurde
    if(!empty($email) && $email !== $benutzer['email']) {
	    $stmt = $pdo->prepare("UPDATE benutzer SET email=:email WHERE benutzer_id=:benutzer_id");
	    $stmt->bindValue(':email', $email);
	    $stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
	    $stmt->execute();
	    $benutzer['email'] = $email;
    }

    // Überprüfen, ob Nutzername geändert wurde
    if(!empty($nutzername) && $nutzername !== $benutzer['nutzername']) {
	    $stmt = $pdo->prepare("UPDATE benutzer SET nutzername=:nutzername WHERE benutzer_id=:benutzer_id");
	    $stmt->bindValue(':nutzername', $nutzername);
	    $stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
	    $stmt->execute();
	    $benutzer['nutzername'] = $nutzername;
    }

    // Überprüfen, ob Passwort geändert wurde
    if(!empty($passwort)) {
	    $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);
	    $stmt = $pdo->prepare("UPDATE benutzer SET passwort=:passwort WHERE benutzer_id=:benutzer_id");
	    $stmt->bindValue(':passwort', $passwort_hash);
	    $stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
	    $stmt->execute();
    }

// Erfolgsmeldung anzeigen
$success_msg = 'Profil erfolgreich aktualisiert.';

?>