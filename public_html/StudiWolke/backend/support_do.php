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

// Verbindung zur Datenbank herstellen
$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de;dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset'=>'utf8'));

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
    <title><?php echo $Ordner['Ordnername original']; ?></title>
</head>
<body>

<header>
    <?php
     // SQL-Abfrage zum Abrufen des Profilbilds des Benutzers
     $state = $pdo->prepare("SELECT profilbild FROM benutzer WHERE benutzer_id=:benutzer_id");
     $state->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
     if ($state->execute()) {
        while ($row=$state->fetch()) {
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
			</ul>
		</nav>
	</header>
<main>

<?php
$frage = htmlspecialchars ($_POST ["frage"]);

//Email holen 
$statement = $pdo->prepare ('SELECT * FROM benutzer WHERE benutzer_id=:benutzer_id');
$statement->bindParam(':benutzer_id', $benutzer_id);

if ($statement->execute()) {
if ($row = $statement->fetch()){ 
        $email = $row["email"];
    }}


//Weitere Daten übergeben (erstelldatum)
$erstelldatum = date("Y-m-d");

//in die DB einfügen
$stmt = $pdo->prepare("INSERT INTO fragen (email, erstelldatum, frage) 
VALUES (:email, :erstelldatum, :frage)");

$stmt->bindParam(':email', $email);
$stmt ->bindParam(':erstelldatum', $erstelldatum);
$stmt->bindParam(':frage', $frage);

if($stmt->execute())
{
    echo("Vielen Dank für Ihre Frage, unser Supportteam hat diese erhalten und bemüht sich diese so schnell wie möglich zu beantworten.");
}
else
{
    $errorInfo = $stmt->errorInfo();
    echo "Ihre Frage konnte leider nicht abgeschickt werden. Versuchen Sie es erneut". $errorInfo[2];
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