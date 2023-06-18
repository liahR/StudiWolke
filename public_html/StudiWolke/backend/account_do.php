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

//Verbindung zur Datenbank
$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset' => 'utf8'));

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <link rel="stylesheet" type="text/css" href="../frontend/public/allgemein.css">
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
//Daten holen
$vorname=htmlspecialchars ($_POST ["vorname"]);
$nachname=htmlspecialchars ($_POST ["nachname"]);
$email=htmlspecialchars ($_POST ["email"]);
$nutzername=htmlspecialchars ($_POST ["nutzername"]);
$passwort= $_POST ["passwort"];

if (!empty($_POST ["passwort"])) {
    // Passwort hashen
    $hashp= password_hash("$passwort", PASSWORD_BCRYPT);

    if(!isset($hashp) | !isset($benutzer_id))
{
    die("Formular-Fehler");

    $stmt = $pdo->prepare("UPDATE benutzer SET passwort=:passwort WHERE benutzer_id=:benutzer_id");
    $stmt->bindParam(":passwort", $hashp);
    $stmt->bindParam(":benutzer_id", $benutzer_id);

    if ($stmt->execute())
    {
        echo "Änderungen erfolgreich übernommen";
    }
    else
    {
        echo "Fehler aufgetreten";
        echo $stmt->errorInfo()[2];
    }
}}


if (!empty($_FILES['profilbild']['name'])) {
    //erlaubter Typ
    $type = pathinfo($_FILES ["profilbild"]["name"], PATHINFO_EXTENSION);
    $erlaubteaealer = array ("jpg", "jpeg", "png"); 
    if (!in_array(strtolower($type), $erlaubteaealer)) {
        die ("Dateityp" .$type. "nicht erlaubt, nur jpg, jpeg, png. <a href='../frontend/public/account.php'>Erneut versuchen</a>");
    }

    if ($_FILES["profilbild"]["size"]>9000000){
        die ("Datei ist zu groß. <a href='../frontend/public/account.php'>Erneut versuchen</a>");
    }

    //zufälliger Name
    $s='1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $s.="abcdefghijklmnopqrstuvwxyz";
    $string='';
    for ($i=0; $i<20; $i++){
        $index=rand(0, strlen($s)-1);
        $string.=$s[$index];
    }
    $string.=".".$type;

    if (!move_uploaded_file($_FILES["profilbild"]["tmp_name"], "/home/lr090/public_html/StudiWolke/frontend/profilbilder/".$string)){
        die ("Fehler bei der Übertragung");
    }

    if(!isset($string) | !isset($benutzer_id))
{
    die("Formular-Fehler");
}

    $stmt = $pdo->prepare("UPDATE benutzer SET profilbild=:profilbild WHERE benutzer_id=:benutzer_id");
    $stmt->bindParam(":profilbild", $string);
    $stmt->bindParam(":benutzer_id", $benutzer_id);

    if ($stmt->execute())
    {
        echo "Änderungen erfolgreich übernommen";
    }
    else
    {
        echo "Fehler aufgetreten";
        echo $stmt->errorInfo()[2];
    }
}




if(!isset($vorname) | !isset($nachname) | !isset($email) | !isset($nutzername) | !isset($benutzer_id))
{
    die("Formular-Fehler");
}


$stmt = $pdo->prepare("UPDATE benutzer SET vorname=:vorname, nachname=:nachname, email=:email, nutzername=:nutzername WHERE benutzer_id=:benutzer_id");
$stmt->bindParam(':vorname', $vorname);
$stmt->bindParam(':nachname', $nachname);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':nutzername', $nutzername);
$stmt->bindParam(":benutzer_id", $benutzer_id);
    
if ($stmt->execute())
{
    header("Location: ../frontend/public/account.php");
}
else
{
    echo "Fehler aufgetreten";
    echo $stmt->errorInfo()[2];
}

?>

</main>	
<footer>
    <small>&copy; 2023 StudiWolke GmbH & Co. KG</small>
    <hr>
</footer>
</body>
</html>
