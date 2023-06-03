<?php
    session_start();
    // Prüfen ob Benutzer nicht eingeloggt ist 
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
    <meta charset="utf-8"/>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" id="favicon">
    <link rel="stylesheet" type="text/css" href="allgemein.css">
    <link rel="stylesheet" type="text/css" href="ansicht.css">
    <!-- Verknüpfen der CSS-Datei für den Dark-Mode -->
    <link rel="stylesheet" type="text/css" href="../src/darkmode.css">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="theme-color" content="#000000"/>
    <!--keine Ahnung ob wir das brauchen, deswegen noch drin-->
    <link rel="manifest" href="%PUBLIC_URL%/manifest.json"/>
    <title> Geteilte Dateien</title>
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
<div class="datei-Struktur">
<?php
//Email holen 
$statement = $pdo->prepare ('SELECT * FROM benutzer WHERE benutzer_id=:benutzer_id');
$statement->bindParam(':benutzer_id',$_SESSION["benutzer_id"]);

if ($statement->execute()) {
if ($row = $statement->fetch()){ 
        $email = $row["email"];
    }}


    //Hole die geteilten Dateien  EMAIL muss irgendwo geholt werden
        $state = $pdo->prepare('SELECT * FROM teilen WHERE email = :email');
        $state->bindParam(':email', $email);
        if ($state->execute()){
            while ($row = $state->fetch()){
                $teilen_id = $row['teilen_id'];
                if (!empty($row["dateipfad"])) {
                    echo "<ul id='geteilte_datei-liste'>";
                        echo "<li>";
                            echo "<a href=".$row["dateipfad"] . " target ='blank' >". $row["dateiname_original"]. "</a><br>";
                            // Lösch-Buttons
                            echo "<form action='../../backend/delete_geteilt_do.php' method='post'>";
                            echo "<input type='hidden' name='teilen_id' value=".$teilen_id.">";
                            echo "<div class='papierkorb'>";
                            echo "<button type='submit'><img src='papierkorb.png' alt='Papierkorb'></button>";
                            echo "</div>";
                            echo "</form>";
                        echo "</li>";
                    echo "</ul>";
                }
            }
        }




//Sortieren und Suchen einfügen 

?>
</div>

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