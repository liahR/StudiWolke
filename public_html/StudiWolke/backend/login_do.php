<?php
session_start();

$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; 
dbname=u-lr090', 'lr090', 'eetho6Choh',
    array('charset' => 'utf8'));

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <link rel="stylesheet" type="text/css" href="allgemein.css">
    <title>Dein Konto</title>
</head>
<body>
<main>
<header>
    <div class="logo">
			<img src="../frontend/public/Logo StudiWolke.png">
    </div>
</header>
<?php

$nutzername=htmlspecialchars ($_POST ["nutzername"]);
$passwort=$_POST ["passwort"];


$statement = $pdo->prepare ('SELECT * FROM benutzer WHERE nutzername=:nutzername');
$statement->bindParam(':nutzername',$nutzername);

if ($statement->execute()) {
if ($row = $statement->fetch()){ 
    if (password_verify ($passwort, $row["passwort"]))
    {
        $_SESSION["benutzer_id"] = $row["benutzer_id"];
        header("Location: ../frontend/public/index.php");
    }
    else
    {
        echo "Passwort oder Nutzername falsch";
        echo "<p><a href= '../frontend/public/login.html'> Erneut versuchen</a></p>";
    }}
else
{
    echo "something went wrong";
}}
else {
    echo "Fehler";
}

?>
</main>	
<footer>
    <small>&copy; 2023 StudiWolke GmbH & Co. KG</small>
    <hr>
</footer>
</body>
</html>

