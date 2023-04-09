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
	//if(!isset($_SESSION['BenutzerId'])) {
		// Benutzer ist nicht eingeloggt, Weiterleitung zur Login-Seite
	//	header("Location: login.html");
	//	exit();
	//}
	// Verbindung zur Datenbank herstellen
	$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset'=>'utf8'));
	if ($pdo->connect_error) {
		die("Verbindung fehlgeschlagen: " . $pdo->connect_error);
	}
	// SQL-Abfrage zum Abrufen der Benutzerdaten
	$stmt = $pdo->prepare("SELECT * FROM Benutzer WHERE BenutzerId=:BenutzerId");
	$stmt->bindValue(':BenutzerId', $_SESSION['BenutzerId']);
	$stmt->execute();
	$Benutzer = $stmt->fetch(PDO::FETCH_ASSOC);
	// Verbindung zur Datenbank schließen
	$pdo = null;
	?>

<header>
<?php
   include "header.php";
   ?>
</header> 
<main>
	<h1>Hallo, <?php echo $Benutzer['Vorname']; ?>!</h1>
	
	<form action="../../backend/account_do.php" method="post" enctype="multipart/form-data">
		<label for="Profilbild">Profilbild:</label><br>
		<input type="file" name="Profilbild" id="Profilbild"><br>
		
		<label for="Vorname">Vorname:</label><br>
		<input type="text" name="Vorname" id="Vorname" placeholder="<?php echo $Benutzer['Vorname']; ?>" value="<?php echo isset($_POST['Vorname']) ? $_POST['Vorname'] : ''; ?>"><br>
		
		<label for="Nachname">Nachname:</label><br>
		<input type="text" name="Nachname" id="Nachname" placeholder="<?php echo $Benutzer['Nachname']; ?>" value="<?php echo isset($_POST['Nachname']) ? $_POST['Nachname'] : ''; ?>"><br>
		
		<label for="Email">Email:</label><br>
		<input type="email" name="Email" id="Email" placeholder="<?php echo $Benutzer['Email']; ?>" value="<?php echo isset($_POST['Email']) ? $_POST['Email'] : ''; ?>"><br>
		
		<label for="Nutzername">Nutzername:</label><br>
		<input type="text" name="Nutzername" id="Nutzername" placeholder="<?php echo $Benutzer['Nutzername']; ?>" value="<?php echo isset($_POST['Nutzername']) ? $_POST['Nutzername'] : ''; ?>"><br>
		
		<label for="Passwort">Passwort:</label><br>
		<input type="password" name="Passwort" id="Passwort"><br>
		
		<input type="submit" name="submit" value="Speichern">
	</form>
</main>	
<?php include("footer.php")?>
</body>
</html>