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

$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset'=>'utf8'));

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
    <title>Im Ordner</title>
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
                echo '<div class="profilbild"><a href="account.php"><img src="https://mars.iuk.hdm-stuttgart.de/~lr090/StudiWolke/frontend/profilbilder/' . $row["profilbild"] . '"></a></div>';
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
			</ul>
		</nav>
	</header>
<main>
<?php

    // Hole den Ordnernamen
    $statement = $pdo->prepare('SELECT ordnername_original FROM ordner WHERE ordner_id = :ordner_id');
    $statement->bindParam(':ordner_id', $_SESSION ["ordner_id"]);
    $statement->execute();
    $ordner = $statement->fetch(PDO::FETCH_ASSOC);
?>

    <!-- Ordnername ausgeben -->
    <h1><?php echo $ordner['ordnername_original']; ?></h1>

    <!--Upload File Button anzeigen mit ausführung -->
    <button onclick="openFileShare()">Datei hochladen</button>

    <div id="Share" style="display:none;">
        <form id="UploadFile" action="../../backend/upload_file_do.php" method="post" enctype="multipart/form-data" >
            Datei auswählen: <br>
            <input type ="hidden" name= "ordner_id" value="<?php echo $_SESSION["ordner_id"]?> ">
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
    </script> 

<?php
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


<!--Hole die Dateien des Ordners SACHE MIT DATEI_ID FÜR TEILEN VERSTEHEN-->
<?php
    $datei_id = '';
    $dateiname_original = '';
    $pfad = '';
    $state = $pdo->prepare('SELECT * FROM dateien WHERE ordner_id = :ordner_id');
    $state->bindParam(':ordner_id', $_SESSION ["ordner_id"]);
    if ($state->execute()){
        while ($row = $state->fetch()){
            $datei_id = $row['datei_id'];
            $dateiname_original = $row['dateiname_original'];
            $pfad = "https://mars.iuk.hdm-stuttgart.de/~lr090/StudiWolke/frontend/dateien/".$row["dateiname_zufall"];
            if (!empty($row["dateiname_zufall"])) {
                echo "<ul id='datei-liste'>";
                    echo "<li>";
                        echo "<a href='https://mars.iuk.hdm-stuttgart.de/~lr090/StudiWolke/frontend/dateien/".$row["dateiname_zufall"] . "' target ='blank' >". $row["dateiname_original"]. "</a><br>";
                        echo "<button onclick='openTeilen(".$datei_id.")'>Teilen</button>";
                        //Teilen forms
                        echo "<div id='Teilen-".$datei_id."' style='display:none;'>";
                        echo "<form id='UploadFile-' action='../../backend/teilen_do.php' method='post' enctype='multipart/form-data' >";
                        echo "Datei auswählen: <br>";
                        echo "<input type ='hidden' name='datei_id' value=". $datei_id. ">";
                        echo "<input type ='hidden' name='dateiname_original' value=". $dateiname_original. ">";
                        echo "<input type='hidden' name='Pfad' value= ".$pfad. " required><br>";
                        echo "<input type='text' name='GeteiltePersonen' placeholder='Mit max.mustermann@muster.de' required>";
                        echo "<input type='submit' value='Teilen' name='submit'>";
                        echo "<button type='button' onclick='closeTeilen(".$datei_id.")'>Abbrechen</button>";
                        echo "</form>";
                        echo "</div>"; 
                        // Teilen-Script
                        echo "<script>";
                        echo "function openTeilen (datei_id) {";
                        echo "document.getElementById('Teilen-' + datei_id).style.display ='block';";
                        echo "}";
                        echo "function closeTeilen (datei_id) {";
                        echo "document.getElementById('Teilen-' + datei_id).style.display ='none';";
                        echo "}";
                        echo"</script>";
                        // Lösch-Buttons
                        echo "<form action='../../backend/delete_file_do.php' method='post'>";
                        echo "<input type='hidden' name='datei_id' value=".$datei_id.">";
                        echo "<button type='submit'>Löschen</button>";
                        echo "</form>";
                    echo "</li>";
                echo "</ul>";
            }
        }
    }

?>




</main>
<footer>
    <hr>
    <div class="logo">
			<a href="index.php"><img src="Logo StudiWolke.png"></a>
		</div>
    <nav>
        <ul>
            <li><a href= "impressum.php">IMPRESSUM</a></li>
            <li><a href= "datenschutz.php">DATENSCHUTZ</a></li>
            <li><a href= "agbs.php">AGBs</a></li>
            <li><a href="../../backend/logout.php">LOGOUT</a></li>
    
        </ul>
    </nav>	
    <hr>
    <small>&copy; 2023 StudiWolke GmbH & Co. KG</small>
    <hr>
</footer>
</body>
</html>