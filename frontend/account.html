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
		if(isset($_SESSION['BenutzerId'])) 
        header("Location: login.php");
		exit;
	    {
			// Verbindung zur Datenbank herstellen
			$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset'=>'utf8'));
			if ($pdo->connect_error) {
				die("Verbindung fehlgeschlagen: " . $pdo->connect_error);
			}
			// SQL-Abfrage zum Abrufen des Vornamens des Benutzers
			$stmt = $pdo->prepare("SELECT Vorname FROM Benutzer WHERE Nutzername=:username");
			$stmt->bindValue(':username', $_SESSION['username']);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			// Vornamen ausgeben
			echo "<h1>Hallo, " . $row['Vorname'] . "!</h1>";
			// Verbindung zur Datenbank schließen
			$pdo->close();
		} else {
			// Benutzer ist nicht eingeloggt, Weiterleitung zur Login-Seite
			header("Location: login.php");
			exit();
		}	
	// Daten des angemeldeten Benutzers abrufen
	$query = "SELECT * FROM Benutzer WHERE Benutzername = :Benutzer";
	$stmt = $pdo->prepare($query);
	$stmt->bindValue(':Benutzer', $_SESSION['Benutzer']);
	$stmt->execute();
	$Benutzer = $stmt->fetch(PDO::FETCH_ASSOC);
	?>
	
	<form action="account_do.php" method="post" enctype="multipart/form-data">
		<label for="Profilbild">Profilbild:</label><br>
		<input type="file" name="Profilbild" id="Profilbild"><br>
		
		<label for="Vorname">Vorname:</label><br>
		<input type="text" name="Vorname" id="Vorname" value="<?php echo $Benutzer['Vorname']; ?>"><br>
		
		<label for="Nachname">Nachname:</label><br>
		<input type="text" name="Nachname" id="Nachname" value="<?php echo $Benutzer['Nachname']; ?>"><br>
		
		<label for="Email">Email:</label><br>
		<input type="email" name="Email" id="Email" value="<?php echo $Benutzer['Email']; ?>"><br>
		
		<label for="Nutzername">Nutzername:</label><br>
		<input type="text" name="Nutzername" id="Nutzername" value="<?php echo $Benutzer['Nutzername']; ?>"><br>
		
		<label for="Passwort">Passwort:</label><br>
		<input type="password" name="Passwort" id="Passwort"><br>
		
		<input type="submit" name="submit" value="Speichern">
	</form>
	
</body>
</html>