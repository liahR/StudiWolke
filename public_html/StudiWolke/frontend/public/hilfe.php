<!DOCTYPE html>
<html>
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
</body>
</html>