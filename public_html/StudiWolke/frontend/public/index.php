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
    <!-- Verknüpfen der CSS-Datei für den Dark-Mode -->
    <link rel="stylesheet" type="text/css" href="../src/darkmode.css">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="theme-color" content="#000000"/>
    <!--keine Ahnung ob wir das brauchen, deswegen noch drin-->
    <link rel="manifest" href="%PUBLIC_URL%/manifest.json"/>
    <title>Start</title>
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
                <li><a href="../../backend/logout.php">LOGOUT</a></li>
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
    <button onclick="openCreateFolder()">Ordner erstellen</button>

    <div id="Folder" style="display:none;">
        <form id="CreateFolder" action="../../backend/create_ordner_do.php" method="post">
            Ordner erstellen: <br>
            <input type="text" name="ordnername" placeholder="Ordnername" required>
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

    <!-- Geteilte Dateien Ordner fix -->
    <div class="geteilte_ordner">
    <img src="geteilte_dateien_ordner.png" alt=" Geteilte Ordner-Icon">
    <h2><a href="in_geteilt.php">Geteilte Dateien</a></h2>
    </div>

<?php        
// SQL-Abfrage zum Abrufen der Ordner ID RAUS AUS LINK 
$statement = $pdo->prepare("SELECT * FROM ordner WHERE benutzer_id = :benutzer_id ORDER BY ordner_id");
$statement->bindParam(':benutzer_id', $benutzer_id);

if ($statement->execute()) {
    while ($row = $statement -> fetch ()){
        echo '<ul id="ordner-liste">';
            echo '<li>';
                echo '<div class="ordner">';
                echo '<img src="cloud-ordner.png" alt="Ordner-Icon">';
                echo '</div>'
                echo '<h2><a href="in_ordner.php">' . $row['ordnername_original'] . '</a></h2>';
                echo '<div> class="papierkorb"';
                echo '<img src="papierkorb.png" href="delete_ordner_do.php"><br>';
                echo '<div>';
            echo '</li>';
        echo '</ul>';
        $_SESSION["ordner_id"] = $row["ordner_id"];
    }}

    // Was macht das braucht man glaub au net
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
    <hr>
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
    <hr>
    <small class="footer_copyright">&copy; 2023 StudiWolke GmbH & Co. KG</small>
    <hr>
</footer>
</main>

</body>
</html>