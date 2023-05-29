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
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" id="favicon">
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
                echo '<div class="profilbild"><a href="account.php"><img src="https://mars.iuk.hdm-stuttgart.de/~lr090/StudiWolke/frontend/profilbilder/' . $row["profilbild"] . '"></a></div>';
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
		<form action="../../backend/support_do.php" method="post">
    	<label for="frage">Stellen Sie Ihre Frage:</label><br>
    	<textarea name="frage" id="frage" rows="8" cols="80" required></textarea><br>
    	<button type="submit">Frage stellen</button>
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