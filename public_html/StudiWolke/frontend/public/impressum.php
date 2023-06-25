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
    <link rel="stylesheet" type="text/css" href="ansicht.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impressum</title>
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
    <button class="in_ordner_gehen-navi" type="submit">Geteilte Dateien</button>
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
</div>
<div class="grid-footer">
<footer>
    <nav>
        <ul class= "footer_links" >
        <li><div class="logo-footer">
            <a href="index.php"><img src="Logo StudiWolke.png"></a>
            </div></li>
        <li><a href= "impressum.php">IMPRESSUM</a></li>
            <li><a href= "datenschutz.php">DATENSCHUTZ</a></li>
            <li><a href= "agbs.php">AGBs</a></li>  
            <li><div class="logout_icon">
                <a href="../../backend/logout.php"><img src="logout_icon.png" alt="Logout" /></a>
                </div></li>	
        </ul>
    </nav>
    <div class="footer_copyright">&copy; 2023 StudiWolke GmbH & Co. KG</div>
</footer>
</div>
</div>
</body>
</html>