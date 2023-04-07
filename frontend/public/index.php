<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" id="favicon">
    <link rel="stylesheet" type="text/css" href="allgemein.css">
    <!-- Verknüpfen der CSS-Datei für den Dark-Mode -->
    <link rel="stylesheet" type="text/css" href="darkmode.css">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
   <!--keine Ahnung ob wir das brauchen, deswegen noch drin-->
    <link rel="manifest" href="%PUBLIC_URL%/manifest.json" />
    <title>Start</title>
  </head>
  <body>
    <?php
		session_start();
		// Prüfen, ob Benutzer eingeloggt ist
		if(isset($_SESSION['BenutzerId'])) 
        header("Location: login.php");
		exit;
    ?>
      <header>
        <nav>
          <ul>
            <li><a href="index.php">Startseite</a></li>
            <li><a href="account.php">Account</a></li>
          </ul>
        </nav>
      </header>
      <main>
       <?php
       // Verbindung zur Datenbank herstellen
			$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset'=>'utf8'));
			if ($pdo->connect_error) {
				die("Verbindung fehlgeschlagen: " . $pdo->connect_error);
			}
			// SQL-Abfrage zum Abrufen des Vornamens des Benutzers
			$stmt = $pdo->prepare("SELECT Vorname FROM Benutzer WHERE Nutzername=:username");
			$stmt->bindValue(':username', $_SESSION['username']);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			// Vornamen ausgeben
			echo "<h1>" . $row['Vorname'] . "'s Wolke!</h1>";
		}
    $statement= $pdo->prepare("SELECT Ordnername original FROM Ordner");
        
    if ($statement->execute())
    {
        while ($row = $statement->fetch()) {
    
          // Sortierungsfunktion
          function sortByName($a, $b)
          {
         return strcmp($a['Ordnername original'], $b['Ordnername original']);
}

        // Standard-Sortierreihenfolge (nach ID)
        usort($rows, function($a, $b) {
        return $a['id'] - $b['id'];
        });

      // Button zum Sortieren nach Namen
      echo '<button onclick="sortByName()">Nach Namen sortieren</button>';

      // Suchfeld
      echo '<input type="text" id="search-input" oninput="searchFolders()" placeholder="Suche nach Dateien...">';

      // Liste der Ordner
  echo '<ul id="ordner-liste">';
  foreach ($rows as $row) {
    echo '<li>';
    echo '<img src="cloud-ordner.png" alt="Ordner-Icon">';
    echo '<h2>'. $row['Ordnername original'] . '</h2>';
    echo '<a href="delete_ordner_do.php?id='. $row['id'] .'">Löschen</a><br>';
    echo '</li>';
  }
  echo '</ul>';

  // JavaScript-Code zum Sortieren und Suchen der Liste
  echo '<script>';
  echo 'function sortByName() {';
  echo '  var list = document.getElementById("ordner-liste");';
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
  echo '  var list = document.getElementById("ordner-liste");';
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
    
    //Sollte es niocht geklappt haben, wird eine Fehler Info ausgegeben.
    
    else {
        echo 'Datenbank-Fehler:';
        echo $statement->errorInfo() [2];
        echo $statement->queryString;
        die();
    }?>
      <footer>
    <ul>
        <li><a href="impressum.html">IMPRESSUM</a></li>
        <li><a href="datenschutz.html">DATENSCHUTZ</a></li>
        <li><a href="logout.php">Abmelden</a></li>
        <!-- HTML-Code für das Mond-Icon -->
        <div class="dark-mode-toggle">
        <i class="fas fa-moon"></i>
        </div>
       <?php // JavaScript-Code zum Umschalten des Dark-Mode
       var darkModeToggle = document.querySelector('.dark-mode-toggle');
       var body = document.querySelector('body');
       darkModeToggle.addEventListener('click', function() {
       body.classList.toggle('dark-mode');
      });?>
    </ul>
    <hr/>
</footer>
</html>
