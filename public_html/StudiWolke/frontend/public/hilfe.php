<?php
    session_start();
    // Prüfen ob Benutzer nicht eingeloggt ist + ordner id setzen 
    if (!isset($_SESSION["benutzer_id"]))
{
    header("Location: login.html");
}
else {
    $benutzer_id = $_SESSION["benutzer_id"];
}

    $pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de;dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset' => 'utf8'));

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <link rel="stylesheet" type="text/css" href="allgemein.css">	
    <title>Support</title>
	<script>
		function toggleAnswer(event) {
			var answer = event.target.nextElementSibling;
			if (answer.style.display === "none") {
				answer.style.display = "block";
			} else {
				answer.style.display = "none";
			}
		}
	</script>
</head>
<body>
<header>
    <?php
     // SQL-Abfrage zum Abrufen des Profilbilds des Benutzers
     $stmt = $pdo->prepare("SELECT profilbild FROM benutzer WHERE benutzer_id=:benutzer_id");
     $stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
     if ($stmt->execute()) {
        while ($row=$stmt->fetch()) {
            if (!empty($row["profilbild"])) {
                echo '<div class="profilbild">'. "<a href = 'account.php'><img src='https://mars.iuk.hdm-stuttgart.de/~lr090/StudiWolke/frontend/profilbilder/".$row["profilbild"]. "'height='80px'></a>";
            }
        }
     }
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
</header>
<main>

	<h1>Support</h1>
	<!-- Häufig gestellte Fragen -->
    <h2>Häufig gestellte Fragen:</h2>
	<div class="faq">
		<h3 onclick="toggleAnswer(event)">Wie kann ich mich in das Cloudsystem einloggen?</h3>
		<p>Um sich in das Cloudsystem einzuloggen, gehen Sie auf die Startseite und klicken Sie auf den "Anmelden"-Button. Geben Sie dann Ihre Anmeldedaten ein und klicken Sie auf "Einloggen".</p>
	</div>
	
	<div class="faq">
		<h3 onclick="toggleAnswer(event)">Wie kann ich Dateien hochladen?</h3>
		<p>Um Dateien hochzuladen, klicken Sie auf den "Dateien hochladen"-Button auf der Startseite. Wählen Sie dann die Datei aus, die Sie hochladen möchten, und klicken Sie auf "Hochladen".</p>
	</div>
	
	<div class="faq">
		<h3 onclick="toggleAnswer(event)">Wie kann ich meine Dateien verwalten?</h3>
		<p>Um Ihre Dateien zu verwalten, gehen Sie auf die Startseite und klicken Sie auf den jeweiligen Ordner. Hier können Sie Ihre Dateien anzeigen oder löschen.</p>
	</div>
	<!-- Formular zum Stellen von Fragen -->
	<form method="post">
		<label for="Frage">Stellen Sie Ihre Frage:</label><br>
		<textarea name="frage" id="Frage" rows="5" cols="40"></textarea><br>
		<input type="submit" name="submit" value="Frage stellen">
	</form>	
	<?php
	// Prüfen, ob das Formular abgeschickt wurde
	if (isset($_POST['submit'])) {
		
		// Verbindung zur Datenbank herstellen

        $pdo=new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090','eetho6Choh', array('charset'=>'utf8'));

		if ($pdo->connect_error) {
			die("Verbindung fehlgeschlagen, Frage kann gerade nicht gestellt werden: " . $pdo->connect_error);
		}
		
		// Frage in die Datenbank einfügen
		$frage = $_POST['frage'];
		$query = "INSERT INTO fragen (frage) VALUES ('{$frage}')";
		if ($pdo->query($query) === TRUE) {
			echo "<p>Vielen Dank, deine Frage wurde erfolgreich gesendet.</p>";
		} else {
			echo "<p>Beim Speichern deiner Frage ist ein Fehler aufgetreten :( Probiere es nochmal! " . $pdo->error . "</p>";
		}	
	}
	?>
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