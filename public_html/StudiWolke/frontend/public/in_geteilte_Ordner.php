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
    <title> Geteilte Dateien</title>
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
$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset'=>'utf8'));


if (isset($_GET['benutzer_id'])) {
    $ordner_id = $_GET['benutzer_id'];

    // Hole die freigegebenen Dateien
    $statement = $db->prepare('SELECT dateiname_original, dateipfad FROM teilen WHERE benutzer_id = :benutzer_id ');
    $statement->bindParam(':benutzer_id', $benutzer_id);
    $statement->execute();
    $teilen = $statement->fetchAll(PDO::FETCH_ASSOC);
} else {
    $_SESSION['error'] = 'Es ist ein Fehler aufgetreten. Bitte versuche es erneut.';
    header('Location: index.php');
    exit();
}
if ($statement->execute()) {
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

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

    // JavaScript-Code zum Sortieren und Suchen der Liste
    echo '<script>';
    echo 'function sortByName() {';
    echo '  var list = document.getElementById("dateien-liste'; 
    echo '  var items = list.getElementsByTagName("li");';
    echo '  var arr = Array.prototype.slice.call(items);';
    echo '  arr.sort(function(a, b) {';
    echo '    var aName = a.getElementsByTagName("h2")[0].textContent;';
    echo '    var bName = b.getElementsByTagName("h2")[0].textContent;';
    echo '    return aName.localeCompare(bName);';
    echo '  });';
    echo '  for (var i = 0; i < arr.length; i++) {';
    echo '    list.appendChild(arr[i]);';
    echo '  }';
    echo '}';
    echo 'function searchFolders() {';
    echo '  var input = document.getElementById("search-input");';
    echo '  var filter = input.value.toUpperCase();';
    echo '  var list = document.getElementById("dateien-liste");';
    echo '  var items = list.getElementsByTagName("li");';
    echo '  for (var i = 0; i < items.length; i++) {';
    echo '    var name = items[i].getElementsByTagName("h2")[0].textContent;';
    echo '    if (name.toUpperCase().indexOf(filter) > -1) {';
    echo '      items[i].style.display = "";';
    echo '    } else {';
    echo '      items[i].style.display = "none";';
    echo '    }';
    echo '  }';
    echo '}';
    echo '</script>';
}
    
    //Sollte es nicht geklappt haben, wird eine Fehler Info ausgegeben.
    
    else {
        echo 'Datenbank-Fehler:';
        echo $statement->errorInfo() [2];
        echo $statement->queryString;
        die();
    }
    ?> 
?>
</main>
<?php include("footer.php")?>

</body>
</html>