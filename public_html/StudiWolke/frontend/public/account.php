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
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" id="favicon">
	<link rel="stylesheet" type="text/css" href="account.css">
	<link rel="stylesheet" type="text/css" href="allgemein.css">
	<title>Dein Konto</title>
</head>
<body>
<div class="grid-container">
<div class ="grid-header">
<header>
  <div class="logo">
    <a href="index.php"><img src="Logo StudiWolke.png"></a>
  </div>
  <div class="header-navigation">
  <nav>
    <ul>
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
          </a>
	</div>
	</li>
    </ul>
  </nav>
  </div>
</header>
</div>
<div class="grid-navi">
</div>
<div class="grid-main">
<main>
	<?php
	// SQL-Abfrage zum Abrufen der Benutzerdaten
	$stmt = $pdo->prepare("SELECT * FROM benutzer WHERE benutzer_id=:benutzer_id");
	$stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
	if ($stmt->execute()) {
		while ($row=$stmt ->fetch()) {
			$vorname = $row['vorname'];
			$nachname = $row['nachname'];
			$email = $row['email'];
			$nutzername = $row['nutzername'];
			$profilbild = $row['profilbild'];
		}
	}
	?>	

	<h1>Hallo, <?php echo $vorname; ?>!</h1>
	



	<form action="../../backend/account_do.php" method="post" enctype="multipart/form-data">
		<label for="profilbild">Profilbild ändern:</label><br>
		<?php // SQL-Abfrage zum Abrufen des Profilbilds des Benutzers
     	$stmt = $pdo->prepare("SELECT profilbild FROM benutzer WHERE benutzer_id=:benutzer_id");
     	$stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
     	if ($stmt->execute()) {
        	while ($row=$stmt->fetch()) {
            	if (!empty($row["profilbild"])) {
                	echo '<div class="profilbild"><img src="https://mars.iuk.hdm-stuttgart.de/~lr090/StudiWolke/frontend/profilbilder/' . $row["profilbild"] . '"></a></div>';
            	}
        	}
     	} ?><br>
  		<input type="file" name="profilbild" id="profilbild">
		<br>
	
		<label for="vorname">Vorname ändern:</label><br>
		<input type="text" name="vorname" id="vorname" value="<?php echo $vorname; ?>"><br>
		
		<label for="nachname">Nachname ändern:</label><br>
		<input type="text" name="nachname" id="nachname" value="<?php echo $nachname; ?>"><br>

		<label for="email">E-Mail ändern:</label><br>
		<input type="email" name="email" id="email" value="<?php echo $email; ?>"><br>

		<label for="nutzername">Nutzername ändern:</label><br>
		<input type="text" name="nutzername" id="nutzername" value="<?php echo $nutzername; ?>"><br>
		
		<label for="passwort">Passwort ändern:</label><br>
		<input type="password" name="passwort" placeholder="********" id="passwort"><br>
		
		<input type="submit" name="submit" value="Speichern">
	</form>
<br><br>
</main>	
</div>
<div class="grid-footer">	
<footer>
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
</div>
</div> 
</body>
</html>