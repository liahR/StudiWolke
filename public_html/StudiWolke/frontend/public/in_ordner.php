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
    <title><?php echo $Ordner['Ordnername original']; ?></title>
</head>
<body>
<?php
    session_start();
    // Prüfen ob Benutzer nicht eingeloggt ist + ordner id setzen 
    if (!isset($_SESSION["benutzer_id"]))
{
    header("Location: login.html");
}
else {
    $benutzer_id = $_SESSION["benutzer_id"];
    if (isset($_GET["ordner_id"])) {
        $ordner_id = $_GET["ordner_id"];
        $_SESSION["ordner_id"] = $ordner_id;
    }
}
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
<?php
    $pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset'=>'utf8'));


    // Hole den Ordnernamen
    $statement = $pdo->prepare('SELECT ordnername_original FROM ordner WHERE ordner_id = :ordner_id');
    $statement->bindParam(':ordner_id', $ordner_id);
    $statement->execute();
    $ordner = $statement->fetch(PDO::FETCH_ASSOC);


//neues If für Sortieren
if ($statement->execute()) {
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
}

    // Sortierungsfunktion
    function sortByName($a, $b)
    {
        return strcmp($a['dateiname_original'], $b['dateiname_original']);
    }

    // Standard-Sortierreihenfolge (nach ID)
    usort($rows, function ($a, $b) {
        return $a['datei_id'] - $b['datei_id'];
    });

    // Button zum Sortieren nach Namen
    echo '<button onclick="sortByName()">Nach Namen sortieren</button>';

    // Suchfeld
    echo '<input type="text" id="search-input" oninput="searchFolders()" placeholder="Suche nach Dateien...">';

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
    


<h1><?php echo $ordner['ordnername_original']; ?></h1>

<!--Upload File Button anzeigen mit ausführung -->
<button onclick="openFileShare()">Datei hochladen</button>

<div id="Share" style="display:none;">
    <form onsubmit="return RequiredFileShare()" id="UploadFile" action="../../backend/upload_file_do.php" method="post" enctype="multipart/form-data" >
        Datei auswählen: <br>
        <input type="file" name="File" required><br>
        <input type="text" name="Dateiname" placeholder="Dateiname" required>
        <input type="submit" value="Datei hochladen" name="submit">
        <button type="button" onclick="closeFileShare()">Abbrechen</button>
</form>
</div> 

<script>
    function openFileShare () {
        document.getElementById("Share").style.display ="block";
    }
    function closeFileShare () {
        document.getElementById("Share").style.display ="none";
    }
    function RequiredFileShare() {
        const file = document.getElementByName("File").value;
        const dateiname = document.getElementByName("Dateiname").value;
        if (file =="" || dateiname =="") {
            alert("Alle Felder ausfüllen");
            return false;
        } else {
            closeForm();
            return true;
        }
    }
    
</script> 


<!--Dateien ausgeben die im Ordner sind // Hole die Dateien des Ordners-->
<?php
    $statement = $pdo->prepare('SELECT * FROM dateien WHERE ordner_id = :ordner_id ORDER BY dateiname_original');
    $statement->bindParam(':ordner_id', $ordner_id);
    $statement->execute();
    $dateien = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

</main>
<footer>

</footer>
<div>
        <img src="Logo StudiWolke.png">
    </div>
    <hr/>
    <small>&copy; 2023 StudiWolke GmbH & Co. KG</small>
    <hr/>
    <nav>
        <ul>
            <li><a href= "impressum.html">IMPRESSUM</a></li>
            <li><a href= "datenschutz.html">DATENSCHUTZ</a></li>
            <li><a href= "agbs.html">AGBs</a></li>
            <li><a href="../../backend/logout.php">LOGOUT</a></li>
    
        </ul>
    </nav>	
</body>
</html>