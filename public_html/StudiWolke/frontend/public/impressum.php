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
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" id="favicon">
    <link rel="stylesheet" type="text/css" href="allgemein.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700&display=swap" rel="stylesheet">
    <title>Impressum</title>
</head>
<body>
<header>
  <div class="logo">
    <a href="index.php"><img src="Logo StudiWolke.png"></a>
  </div>
  <div class="header-navigation"><
  <nav>
    <ul><br><br><br><br><br><br><br><br>
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
    <div class="logo_footer">
			<a href="index.php"><img src="Logo StudiWolke.png"></a>
		</div>
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
</body>
</html>