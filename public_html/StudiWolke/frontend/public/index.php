<!DOCTYPE html>
<html lang="en">
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
<?php
        session_start();
        // Prüfen, ob Benutzer nicht eingeloggt ist
        if (!isset($_SESSION['benutzer_id'])) {
            header("Location: login.html");
            exit;
        };
?>
    <header>
    <?php
        // Verbindung zur Datenbank herstellen
	$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset'=>'utf8'));
	if ($pdo->connect_error) {
		die("Verbindung fehlgeschlagen: " . $pdo->connect_error);
	}
     // SQL-Abfrage zum Abrufen des Profilbilds des Benutzers
     $stmt = $pdo->prepare("SELECT profilbild FROM benutzer WHERE benutzer_id=:benutzer_id");
     $stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
     $stmt->execute();
     $row = $stmt->fetch(PDO::FETCH_ASSOC);
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
		<div class="account">
			<a href="account.php"><img src="<?php echo $benutzer['profilbild']; ?>" alt="Profilbild"></a>
		</div>
	</header>
    <main>
    <?php    // Verbindung zur Datenbank herstellen
        $pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de;dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset' => 'utf8'));

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
        <form onsubmit="return RequiredCreateFolder()" id="CreateFolder" action="../../backend/create_ordner_do.php" method="post">
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
        function RequiredCreateFolder() {
            const ordnername = document.getElementByName("Ordnername").value;
            if (ordnername =="") {
                alert("Alle Felder ausfüllen");
                return false;
            } else {
                closeForm();
                return true;
            }
        }

    </script> 
    </div> 

    <!-- Geteilte Dateien Ordner fix -->
    <div class="ordner">
    <img src="cloud-ordner.png" alt="Ordner-Icon">
    <h2><a href="in_geteilte_Ordner.php"> Geteilte Dateien </a></h2>
    <div>

<?php        
// SQL-Abfrage zum Abrufen der Ordner
$statement = $pdo->prepare("SELECT ordner_id, ordnername_original FROM ordner");

if ($statement->execute()) {
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Sortierungsfunktion
    function sortByName($a, $b)
    {
        return strcmp($a['ordnername_original'], $b['ordnername_original']);
    }

    // Standard-Sortierreihenfolge (nach ID)
    usort($rows, function ($a, $b) {
        return $a['ordner_id'] - $b['ordner_id'];
    });
    ?>
    <!-- Suchfeld -->
    <input type="text" id="search-input" oninput="searchFolders()" placeholder="Suche nach Dateien...">

    <br>

    <!-- Button zum Sortieren nach Namen -->
    <button onclick="sortByName()">Nach Namen sortieren</button>

    <!-- Liste der Ordner -->
    <?php
    echo '<ul id="ordner-liste">';
    foreach ($rows as $row) {
        echo '<li>';
        echo '<div class="ordner">'
        echo '<img src="cloud-ordner.png" alt="Ordner-Icon">';
        echo '<h2><a href="in_ordner.php?id=' . $row['ordner_id'] . '">' . $row['ordnername_original'] . '</a></h2>';
        echo '<a href="delete_ordner_do.php=' . $row['ordner_id'] . '">Löschen</a><br>';
        echo '<div>'
        echo '</li>';
    }
    echo '</ul>';}
?>
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

</body>
</html>