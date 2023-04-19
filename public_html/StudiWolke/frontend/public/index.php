<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" id="favicon">
    <link rel="stylesheet" type="text/css" href="../src/allgemein.css">
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

    </header>
    <main>
    <?php    // Verbindung zur Datenbank herstellen
        $pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de;dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset' => 'utf8'));

        // SQL-Abfrage zum Abrufen des Vornamens des Benutzers
        $stmt = $pdo->prepare("SELECT vorname FROM benutzer WHERE benutzer_id=:benutzer_id");
        $stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vornamen ausgeben um zu willkommen
        echo "<h1>" . $row['vorname'] . "'s Wolke!</h1>";

        // Geteilte Dateien Ordner fix
        echo '<img src="cloud-ordner.png" alt="Ordner-Icon">';
        echo '<h2><a href="in_geteilte_Ordner.php"> Geteilte Dateien </a></h2>';

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

     // Suchfeld
     echo '<input type="text" id="search-input" oninput="searchFolders()" placeholder="Suche nach Dateien...">'; 

     '<br>'

    // Button zum Sortieren nach Namen
    echo '<button onclick="sortByName()">Nach Namen sortieren</button>';

    // Liste der Ordner
    echo '<ul id="ordner-liste">';
    foreach ($rows as $row) {
        echo '<li>';
        echo '<img src="cloud-ordner.png" alt="Ordner-Icon">';
        echo '<h2><a href="in_Ordner.php?id=' . $row['ordner_id'] . '">' . $row['ordnername_original'] . '</a></h2>';
        echo '<a href="delete_ordner_do.php=' . $row['ordner_id'] . '">Löschen</a><br>';
        echo '</li>';
    }
    echo '</ul>';}
?>
  // JavaScript-Code zum Sortieren und Suchen der Liste
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