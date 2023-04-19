<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
session_start();
$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset'=>'utf8'));

if (isset($_GET['profilbild'])) {
    $benutzer_id = $_GET['profilbild'];

    // Hole das Profilbild
    $statement = $db->prepare('SELECT profilbild FROM benutzer WHERE benutzer_id = :benutzer_id');
    $statement->bindParam(':benutzer_id', $benutzer_id);
    $statement->execute();
    $benutzer = $statement->fetch(PDO::FETCH_ASSOC);

} else {
    $_SESSION['error'] = 'Es ist ein Fehler aufgetreten. Bitte versuche es erneut.';
    header('Location: index.php');
    exit();
}
?>
<body>
<header>
        <img src="Logo StudiWolke.png" alt= "Das Logo von StudiWolke">
        <nav>
            <ul>
                <li><a href="index.php">START</a></li>
                <li><a href="support.php">SUPPORT</a></li>
                <li><a href="account.php">PROFIL</a></li> 
                <li><img src="<?php echo $Profilbild ?>" alt="Profilbild">
                <div>
                <!-- HTML-Code für das Mond-Icon, Dark Mode, muss noch gefixt werden 
                <div class="dark-mode-toggle">
                <i class="fas fa-moon"></i> -->
                </div>
            </ul>
        </nav>
</header> 
</body>
</html>
<?php ?>