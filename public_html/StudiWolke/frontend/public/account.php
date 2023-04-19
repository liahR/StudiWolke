<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="allgemein.css">
	<title>Dein Konto</title>
</head>
<body>
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
	// Verbindung zur Datenbank schließen
	$pdo = null;
	?>
<main>
	<h1>Hallo, <?php echo $benutzer['vorname']; ?>!</h1>
	
	<form action="../../backend/account_do.php" method="post" enctype="multipart/form-data">
		<label for="profilbild">Profilbild ändern:</label><br>
		<input type="file" name="profilbild" id="profilbild"><br>
		
		<label for="vorname">Vorname:</label><br>
		<input type="text" name="vorname" id="vorname" placeholder="<?php echo $Benutzer['vorname']; ?>" value="<?php echo isset($_POST['vorname']) ? $_POST['vorname'] : ''; ?>"><br>
		
		<label for="nachname">Nachname:</label><br>
		<input type="text" name="nachname" id="nachname" placeholder="<?php echo $Benutzer['nachname']; ?>" value="<?php echo isset($_POST['nachname']) ? $_POST['nachname'] : ''; ?>"><br>
		
		<label for="email">Email:</label><br>
		<input type="email" name="email" id="email" placeholder="<?php echo $Benutzer['email']; ?>" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"><br>
		
		<label for="nutzername">Nutzername:</label><br>
		<input type="text" name="nutzername" id="nutzername" placeholder="<?php echo $Benutzer['nutzername']; ?>" value="<?php echo isset($_POST['nutzername']) ? $_POST['nutzername'] : ''; ?>"><br>
		
		<label for="passwort">Passwort:</label><br>
		<input type="password" name="passwort" id="passwort"><br>
		
		<input type="submit" name="submit" value="Speichern">
	</form>
</main>	
</body>
</html>