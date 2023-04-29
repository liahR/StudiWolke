<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="allgemein.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700&display=swap" rel="stylesheet">
    <title>Impressum</title>
</head>
<body>
<header>
    <?php session_start();
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
     <h1> Impressum</h1> 

 <!--Unsere Inhalte-->

    <h2>StudiWolke GmbH & Co. KG </h2>
    <p>  
    <b>Vertretungsberechtigte Personen</b><br>
    Geschäftsführer: Janna Schweigmann<br>
    Kontaktdaten: Musterstraße 1, 12345 Stuttgart<br>
    Telefon: 01234 567890<br>
    E-Mail: janna.schweigmann@StudiWolke.de<br><br>

    <b>Handelsregisternummer:</b> <br>
    HRB 123456 Umsatzsteueridentifikationsnummer: DE 123456789<br>
    Zuständige Aufsichtsbehörde: Landesanstalt für Medien NRW Zollhof 2<br>
    40221 Düsseldorf<br><br>

    <b>Verantwortlicher im Sinne des § 55 Abs. 2 RStV:</b><br>
    Janna Schweigmann<br>
    StudiWolke GmbH & Co. KG<br>
    Königsstraße 1 12345 Stuttgart<br><br>

    <b>Cookies:</b> Wir verwenden Cookies, um die Funktionalität unserer Website zu verbessern. Nähere Informationen finden Sie in unserer Datenschutzerklärung.<br><br>

    <b>Hinweis:</b> StudiWolke GmbH & Co. KG ist eine GmbH & Co. KG mit Sitz in Stuttgart. Die GmbH ist Komplementärin der KG und als alleinige Gesellschafterin im Handelsregister eingetragen.<br></p>

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