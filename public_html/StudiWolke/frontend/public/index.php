<?php
    session_start();
    // Prüfen ob Benutzer nicht eingeloggt ist + ordner id setzen 
    if (!isset($_SESSION["benutzer_id"]))
{
    header("Location: login.html");
}
else {
    $benutzer_id = $_SESSION["benutzer_id"];
};

// Überprüfen, ob der Dark-Mode-Status in der Session vorhanden ist
if (!isset($_SESSION['darkmode'])) {

if ($_SESSION['darkmode']) {
  $themeStyle = 'darkmode.css';
} else {
  $themeStyle = 'allgemein.css';
}};

    $pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de;dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset' => 'utf8'));

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" id="favicon">
    <link rel="stylesheet" type="text/css" href="allgemein.css" id="hell_css">
    <link rel="stylesheet" type="text/css" href="ansicht.css">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="theme-color" content="#000000"/>
    <script>
        // Funktion zum Umschalten des Dark Modes
        function toggleDarkMode() {
            var themeStyle = document.getElementById('hell_css');
            if (themeStyle.getAttribute('href') === 'allgemein.css') {
                themeStyle.href = 'darkmode.css';
                $_SESSION["darkmode"];
            } else {
                themeStyle.href = 'allgemein.css';
            }
        };
        // Ereignislistener für den Button
        document.addEventListener('DOMContentLoaded', function() {
            var darkModeToggle = document.getElementById('dark-mode-toggle');
            darkModeToggle.addEventListener('click', toggleDarkMode);
        });
    </script>
    <title>Start</title>
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
      <li>
        <div class="ordner_erstellen_icon">
          <button onclick="openCreateFolder()"><img src="ordner_erstellen_icon.png" alt="Ordner Erstellen Icon"></button>
          <span style="display: none;">Ordner erstellen</span>
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
    <?php  

        // SQL-Abfrage zum Abrufen des Vornamens des Benutzers
        $stmt = $pdo->prepare("SELECT vorname FROM benutzer WHERE benutzer_id=:benutzer_id");
        $stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

   ?>

    <!-- Vornamen ausgeben um zu willkommen -->
    <h1><?php echo $row['vorname']; ?> 's Wolke! </h1>

    <!-- Ordner erstellen -->
    <div id="Folder"  style="display:none;">
        <form id="CreateFolder" class="popup-feld" action="../../backend/create_ordner_do.php" method="post">
            Ordner erstellen: <br>
            <input type="text" name="ordnername" placeholder="Ordnername" required><br><br>
            <input class="button" type="submit" value="Ordner erstellen" name="submit">
            <button class="button" type="button" onclick="closeCreateFolder()">Abbrechen</button>
        </form>
    <script>
        function openCreateFolder () {
            document.getElementById("Folder").style.display ="block";
        }
        function closeCreateFolder () {
            document.getElementById("Folder").style.display ="none";
        } 

    </script> 
    </div> <br>
<div class="Ordner-Struktur">
    <!-- Geteilte Dateien Ordner (fix) -->
    
    <div class="geteilte_ordner"><br>        
    
    <form action="in_geteilt.php" method="post">
    <button class="in_ordner_gehen" type="submit"><img src="geteilte-ordner.png" alt=" Geteilte Dateien Ordner-Icon"><h2>Geteilte Dateien</h2></button>
    </form>
    
    </div>
    

<?php        
// SQL-Abfrage zum Abrufen der Ordner 
$statement = $pdo->prepare("SELECT * FROM ordner WHERE benutzer_id = :benutzer_id ORDER BY ordner_id");
$statement->bindParam(':benutzer_id', $benutzer_id);

if ($statement->execute()) {
    while ($row = $statement->fetch()) {
        $ordner_id = $row['ordner_id'];
        echo '<ul id="ordner-liste">';
        echo '<li>';
        echo '<div class="ordner">';
        echo '<form action="in_ordner.php" method="post">';
        echo '<input type="hidden" name="ordner_id" value="' . $row['ordner_id'] . '">';
        echo '<button class="in_ordner_gehen" type="submit"> <img src="cloud-ordner.png" alt="Ordner-Icon"><h2>'.$row['ordnername_original'].'</h2></button>';
        echo '</form>';   
        // Lösch-Buttons
        echo "<form action='../../backend/delete_ordner_do.php' method='post'>";
        echo "<input type='hidden' name='ordner_id' value=".$ordner_id.">";
        echo "<div class='papierkorb'>";
        echo "<button type='submit'><img src='papierkorb.png' alt='Papierkorb'></button>";
        echo '</div>';
        echo "</form>";
        echo '</div>';
        echo '</li>';
        echo '</ul>';
    }
} 
?>
</div>



</main>
<button id="dark-mode-toggle">Dark Mode</button>
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