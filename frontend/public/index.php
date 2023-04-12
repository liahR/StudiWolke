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
<header>
<?php
   include "header.php";
   ?>
</header> 
<main>
<?php
session_start();
// Prüfen, ob Benutzer nicht eingeloggt ist -- BITTE NOCH AKTIVIEREN
//if (!isset($_SESSION['BenutzerId'])) {
//    header("Location: login.html");
//    exit;
//}


// Verbindung zur Datenbank herstellen
$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset' => 'utf8'));
if ($pdo->connect_error) {
    die("Verbindung fehlgeschlagen: " . $pdo->connect_error);
}


// SQL-Abfrage zum Abrufen des Vornamens des Benutzers
$stmt = $pdo->prepare("SELECT Vorname FROM Benutzer WHERE Nutzername=:Nutzername");
$stmt->bindValue(':Nutzername', $_SESSION['Nutzername']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);


// Vornamen ausgeben
echo "<h1>" . $row['Vorname'] . "'s Wolke!</h1>";

// Geteilte Dateien Ordner fix
echo <img src="cloud-ordner.png" alt="Ordner-Icon">;
echo <h2><a href="in_geteilte_Ordner.php"> Geteilte Dateien </a></h2>;

// SQL-Abfrage zum Abrufen der Ordner
$statement = $pdo->prepare("SELECT OrdnerId, Ordnername_original FROM Ordner");

if ($statement->execute()) {
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Sortierungsfunktion
    function sortByName($a, $b)
    {
        return strcmp($a['Ordnername_original'], $b['Ordnername_original']);
    }

    // Standard-Sortierreihenfolge (nach ID)
    usort($rows, function ($a, $b) {
        return $a['OrdnerId'] - $b['OrdnerId'];
    });

    // Button zum Sortieren nach Namen
    echo <button onclick="sortByName()">Nach Namen sortieren</button>;

    // Suchfeld
    echo <input type="text" id="search-input" oninput="searchFolders()" placeholder="Suche nach Dateien...">;

    // Liste der Ordner
    echo '<ul id="ordner-liste">';
    foreach ($rows as $row) {
        echo <li>;
        echo <img src="cloud-ordner.png" alt="Ordner-Icon">;
        echo <h2><a href="in_Ordner.php=' . $row['OrdnerId'] . '">' . $row['Ordnername_original'] . '</a></h2>;
        echo <a href="delete_ordner_do.php=' . $row['OrdnerId'] . '">Löschen</a><br>;
        echo </li>;
    }
    echo </ul>;

    // JavaScript-Code zum Sortieren und Suchen der Liste
    echo <script>;
    echo function sortByName() {;
    echo   var list = document.getElementById("ordner-liste");
    echo   var items = list.getElementsByTagName("li");
    echo   var arr = Array.prototype.slice.call(items);
    echo   arr.sort(function(a, b) {;
    echo     var aName = a.getElementsByTagName("h2")[0].textContent;
    echo     var bName = b.getElementsByTagName("h2")[0].textContent;
    echo     return aName.localeCompare(bName);
    echo   });
    echo   for (var i = 0; i < arr.length; i++) {;
    echo     list.appendChild(arr[i]);
    echo   };
    echo };
    echo function searchFolders() {;
    echo   var input = document.getElementById("search-input");
    echo   var filter = input.value.toUpperCase();
    echo   var list = document.getElementById("ordner-liste");
    echo   var items = list.getElementsByTagName("li");
    echo   for (var i = 0; i < items.length; i++) {;
    echo     var name = items[i].getElementsByTagName("h2")[0].textContent;
    echo     if (name.toUpperCase().indexOf(filter) > -1) {;
    echo       items[i].style.display = "";;
    echo     } else {;
    echo       items[i].style.display = "none";
    echo     };
    echo   };
    echo };
    echo </script>;
}
    
    //Sollte es nicht geklappt haben, wird eine Fehler Info ausgegeben.
    
    else {
        echo 'Datenbank-Fehler:';
        echo $statement->errorInfo() [2];
        echo $statement->queryString;
        die();
    }
    ?>  
    </main>
    <?php include("footer.php")?>
</html>
