<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="allgemein.css">
	<title>Dein Konto</title>
</head>
<body>
<header>
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
     // SQL-Abfrage zum Abrufen des Profilbilds des Benutzers
     $stmt = $pdo->prepare("SELECT profilbild FROM benutzer WHERE benutzer_id=:benutzer_id");
     $stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
     $stmt->execute();
     $row = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
		<div class="logo">
			<a href="index.php"><img src="Logo StudiWolke.png"></a>
		</div>
		<nav>
			<ul>
				<li><a href="index.php">Start</a></li>
				<li><a href="hilfe.php">Support</a></li>
			</ul>
		</nav>
		<div class="account">
			<a href="account.php"><img src="<?php echo $benutzer['profilbild']; ?>" alt="Profilbild"></a>
		</div>
</header>
<main>
	<?php
	// SQL-Abfrage zum Abrufen der Benutzerdaten
	$stmt = $pdo->prepare("SELECT * FROM benutzer WHERE benutzer_id=:benutzer_id");
	$stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
	$stmt->execute();
	$benutzer = $stmt->fetch(PDO::FETCH_ASSOC);
	// Verbindung zur Datenbank schließen
	$pdo = null;
	?>
	<h1>Hallo, <?php echo $benutzer['vorname']; ?>!</h1>
	
	<form action="../../backend/account_do.php" method="post" enctype="multipart/form-data">
		
		<label for="profilbild">Profilbild ändern:</label><br>
		<div class="profilbild-container">
  		<img src="<?php echo $benutzer['profilbild']; ?>" alt="Profilbild">
  		<input type="file" name="profilbild" id="profilbild">
		</div>
	
		<label for="vorname">Vorname ändern:</label><br>
		<input type="text" name="vorname" id="vorname" value="<?php echo $benutzer['vorname']; ?>"><br>
		
		<label for="nachname">Nachname ändern:</label><br>
		<input type="text" name="nachname" id="nachname" value="<?php echo $benutzer['nachname']; ?>"><br>

		<label for="email">E-Mail ändern:</label><br>
		<input type="email" name="email" id="email" value="<?php echo $benutzer['email']; ?>"><br>

		<label for="nutzername">Nutzername ändern:</label><br>
		<input type="text" name="nutzername" id="nutzername" value="<?php echo $benutzer['nutzername']; ?>"><br>
		
		<label for="passwort">Passwort ändern:</label><br>
		<input type="password" name="passwort" placeholder="********" id="passwort"><br>
		
		<input type="submit" name="submit" value="Speichern">
	</form>
</main>	
<footer>
    <hr>
    <div class="logo">
			<a href="index.php"><img src="Logo StudiWolke.png"></a>
		</div>
    <nav>
        <ul>
			<li><a href= "impressum.php">IMPRESSUM</a></li>
            <li><a href= "datenschutz.php">DATENSCHUTZ</a></li>
            <li><a href= "agbs.php">AGBs</a></li>
            <li><a href="../../backend/logout.php">LOGOUT</a></li>
    
        </ul>
    </nav>	
    <hr>
    <small>&copy; 2023 StudiWolke GmbH & Co. KG</small>
    <hr>
</footer>
</body>
</html>