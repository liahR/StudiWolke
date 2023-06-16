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
    <link rel="stylesheet" type="text/css" href="ansicht.css">	
    <link rel="stylesheet" type="text/css" href="hilfe.css">
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
<div class="grid-container">
<div class ="grid-header">
<header>
  <div class="header-navigation">
  <nav>
    <ul>
      <li class="profilbild">
        <?php
        // SQL-Abfrage zum Abrufen des Profilbilds des Benutzers
        $stmt = $pdo->prepare("SELECT profilbild FROM benutzer WHERE benutzer_id=:benutzer_id");
        $stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
        if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            if (!empty($row["profilbild"])) {
              echo '<a href="account.php"><img src="https://mars.iuk.hdm-stuttgart.de/~lr090/StudiWolke/frontend/profilbilder/' . $row["profilbild"] . '"></a>';
            }
          }
        }
        ?>
      </li>
      <li>
        <div class="support_icon">
          <a href="hilfe.php">
            <img src="support_icon.png" alt="Support Icon">
            <span style="display: none;">Support</span>
          </a>
        </div>
      </li>
      
    </ul>
  </nav>
  </div>
</header>
</div>
<div class="grid-navi">
  <div class="logo">
      <a href="index.php"><img src="Logo StudiWolke.png"></a>
  </div>
<!-- Geteilte Dateien Ordner (fix) für Navigation -->
<div class="Ordner-Struktur-Navi">   
    <div class="geteilte_ordner-navi">       
    
    <form action="in_geteilt.php" method="post">
    <button class="in_ordner_gehen" type="submit">Geteilte Dateien</button>
    </form>
    </div>
<?php        
// SQL-Abfrage zum Abrufen der Ordner in Navigation
$statement = $pdo->prepare("SELECT * FROM ordner WHERE benutzer_id = :benutzer_id ORDER BY ordner_id");
$statement->bindParam(':benutzer_id', $benutzer_id);

if ($statement->execute()) {
    while ($row = $statement->fetch()) {
        $ordner_id = $row['ordner_id'];
        echo '<ul id="ordner-liste-navi">';
        echo '<li>';
        echo '<div class="ordner-navi">';
        echo '<form action="in_ordner.php" method="post">';
        echo '<input type="hidden" name="ordner_id" value="' . $row['ordner_id'] . '">';
        echo '<button class="in_ordner_gehen-navi" type="submit">'.$row['ordnername_original'].'</button>';
        echo '</form>';       
        echo '</div>';
        echo '</li>';
        echo '</ul>';
    }
} 
?>
</div>
</div>
<div class="grid-main">
<main>

	<h1>Support</h1>
	<!-- Häufig gestellte Fragen -->
    <h2>Häufig gestellte Fragen:</h2>
	<div class="faq">
     <h3 onclick="toggleAnswer(event)">
            Wie kann ich mich in das Cloudsystem einloggen?
            <img src="toggle_icon.png"></h3>		
        <p>Um sich in das Cloudsystem einzuloggen, gehen Sie auf die Startseite und klicken Sie auf den "Anmelden"-Button. Geben Sie dann Ihre Anmeldedaten ein und klicken Sie auf "Einloggen".</p>
	</div>
	
	<div class="faq">
		<h3 onclick="toggleAnswer(event)">
          Wie kann ich Dateien hochladen?
          <img src="toggle_icon.png">
    </h3>
		<p>Um Dateien hochzuladen, klicken Sie auf den "Dateien hochladen"-Button auf der Startseite. Wählen Sie dann die Datei aus, die Sie hochladen möchten, und klicken Sie auf "Hochladen".</p>
	</div>
	
	<div class="faq">
		<h3 onclick="toggleAnswer(event)">
      Wie kann ich meine Dateien verwalten?
      <img src="toggle_icon.png">
    </h3>
		<p>Um Ihre Dateien zu verwalten, gehen Sie auf die Startseite und klicken Sie auf den jeweiligen Ordner. Hier können Sie Ihre Dateien anzeigen oder löschen.</p>
	</div>
	<!-- Formular zum Stellen von Fragen -->
	<form action="../../backend/support_do.php" method="post">
  <label for="frage">Stelle uns deine Frage hier!</label><br>
  <textarea name="frage" id="frage" rows="7" cols="80" required class="support-form"></textarea><br>
  <button type="submit">Frage stellen</button>
</form>
</main>
</div>
<div class="grid-footer">		
<footer>
    <nav>
        <ul class= "footer_links" >
        <li><a href= "impressum.php">IMPRESSUM</a></li>
            <li><a href= "datenschutz.php">DATENSCHUTZ</a></li>
            <li><a href= "agbs.php">AGBs</a></li>  
        </ul>
    </nav>
    <div class="logout_icon">
        <a href="../../backend/logout.php"><img src="logout_icon.png" alt="Logout" /></a>
        </div>	
    <div class="footer_copyright"><br><br><br><br> &copy; 2023 StudiWolke GmbH & Co. KG</div>
</footer>
</div>
</div>
</body>
</html>
