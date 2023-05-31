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
    <meta charset="utf-8"/>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" id="favicon">
    <link rel="stylesheet" type="text/css" href="allgemein.css">
    <link rel="stylesheet" type="text/css" href="ansicht.css">
    <!-- Verknüpfen der CSS-Datei für den Dark-Mode -->
    <link rel="stylesheet" type="text/css" href="../src/darkmode.css">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="theme-color" content="#000000"/>
    <title>Start</title>
</head>
<body>

<header>
  <div class="logo">
    <a href="index.php"><img src="Logo StudiWolke.png"></a>
  </div>
  <nav>
    <ul><br>
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
          </a><br>
        </div>
        <div class="ordner_erstellen_icon">
          <button onclick="openCreateFolder()"><img src="ordner_erstellen_icon.png" alt="Ordner Erstellen Icon"></button>
          <span style="display: none;">Ordner erstellen</span>
        </div>
      </li>
      
    </ul>
  </nav>
</header>

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
            <input type="text" name="ordnername" placeholder="Ordnername" required><br>
            <input type="submit" value="Ordner erstellen" name="submit">
            <button type="button" onclick="closeCreateFolder()">Abbrechen</button>
        </form>
    <script>
        function openCreateFolder () {
            document.getElementById("Folder").style.display ="block";
        }
        function closeCreateFolder () {
            document.getElementById("Folder").style.display ="none";
        } 

    </script> 
    </div> 
<div class="Ordner-Struktur">
    <!-- Geteilte Dateien Ordner (fix) -->
    <div class="geteilte_ordner">        
    <img src="geteilte-ordner.png" alt=" Geteilte Dateien Ordner-Icon">
    <h2><a href="in_geteilt.php">Geteilte Dateien</a></h2>
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
        echo '<img src="cloud-ordner.png" alt="Ordner-Icon">';
        echo '</div>';
        //Button für in ordner
        echo '<form action="in_ordner.php" method="post">';
        echo '<input type="hidden" name="ordner_id" value="' . $row['ordner_id'] . '">';
        echo '<h2><button type="submit">' . $row['ordnername_original'] . '</button></h2>';
        echo '</form>';
        // Lösch-Buttons
        echo "<form action='../../backend/delete_ordner_do.php' method='post'>";
        echo "<input type='hidden' name='ordner_id' value=".$ordner_id.">";
        echo "<div class='papierkorb'>";
        echo "<button type='submit'><img src='papierkorb.png' alt='Papierkorb'></button>";
        echo '</div>';
        echo "</form>";
        echo '</li>';
        echo '</ul>';
    }
} 
?>
</div>
<?php
    // Sortierungsfunktion 
    function sortByName($a, $b)
    {
        return strcmp($a['ordnername_original'], $b['ordnername_original']);
    }

    ?>
    
    <!-- Suchfeld -->
    <input type="text" id="search-input" oninput="searchFolders()" placeholder="Suche nach Dateien...">
    <br>

    <!-- Button zum Sortieren nach Namen -->
    <button onclick="sortByName()">Nach Namen sortieren</button>
    


  <!-- JavaScript-Code zum Sortieren und Suchen der Liste -->
        <script>
        function sortByName() {
        var list = document.getElementById("ordner-liste");
        var items = list.getElementsByTagName("li");
        var arr = Array.prototype.slice.call(items);

        arr.sort(function(a, b) {
        var aName = a.getElementsByTagName("h2")[0].textContent;
        var bName = b.getElementsByTagName("h2")[0].textContent;
        return aName.localeCompare(bName);
        });
        for (var i = 0; i < arr.length; i++) {
        list.appendChild(arr[i]);
        }
        }

        function searchFolders() {
        var input = document.getElementById("search-input");
        var filter = input.value.toUpperCase()
        var list = document.getElementById("ordner-liste");
        var items = list.getElementsByTagName("li");
             for (var i = 0; i < items.length; i++) {
        var name = items[i].getElementsByTagName("h2")[0].textContent;

        if (name.toUpperCase().indexOf(filter) > -1) {
            items[i].style.display = "";
        } else {
            items[i].style.display = "none";
        }
        }
        }
        </script>


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
</main>

</body>
</html>