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
	if(!isset($_SESSION['benutzerId'])) {
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
	$stmt = $pdo->prepare("SELECT * FROM benutzer WHERE benutzerId=:benutzerId");
	$stmt->bindValue(':benutzerId', $_SESSION['benutzerId']);
	$stmt->execute();
	$benutzer = $stmt->fetch(PDO::FETCH_ASSOC);
	// Verbindung zur Datenbank schließen
	$pdo = null;
	?>

<header>
<?php
   include "header.php";
   ?>
</header> 
<main>
	<h1>Hallo, <?php echo $benutzer['vorname']; ?>!</h1>
	
	<form action="../../backend/account_do.php" method="post" enctype="multipart/form-data">
		<label for="profilbild">Profilbild:</label><br>
		<input type="file" name="profilbild" id="profilbild"><br>
		
		<label for="vorname">Vorname:</label><br>
		<input type="text" name="vorname" id="vorname" placeholder="<?php echo $benutzer['vorname']; ?>" value="<?php echo isset($_POST['vorname']) ? $_POST['vorname'] : ''; ?>"><br>
		
		<label for="nachname">Nachname:</label><br>
		<input type="text" name="nachname" id="nachname" placeholder="<?php echo $benutzer['nachname']; ?>" value="<?php echo isset($_POST['nachname']) ? $_POST['nachname'] : ''; ?>"><br>
		
		<label for="email">Email:</label><br>
		<input type="email" name="email" id="email" placeholder="<?php echo $benutzer['email']; ?>" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"><br>
		
		<label for="nutzername">Nutzername:</label><br>
		<input type="text" name="nutzername" id="nutzername" placeholder="<?php echo $benutzer['nutzername']; ?>" value="<?php echo isset($_POST['nutzername']) ? $_POST['nutzername'] : ''; ?>"><br>
		
		<label for="passwort">Passwort:</label><br>
		<input type="password" name="passwort" id="passwort"><br>
		
		<input type="submit" name="submit" value="Speichern">
	</form>
</main>	
<?php include("footer.php")?>
</body>
</html>