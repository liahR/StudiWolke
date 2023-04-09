<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<header>
        <img src="Logo StudiWolke.png" alt= "Das Logo von StudiWolke">
        <nav>
            <ul>
                <li><a href="index.php">START</a></li>
                <li><a href="support.php">SUPPORT</a></li>
                <li><a href="account.php">PROFIL</a></li> 
                <li><img src="<?php echo $profilbild_pfad ?>" alt="Profilbild">
                <div>
                <!-- HTML-Code für das Mond-Icon, Dark Mode, muss noch gefixt werden 
                <div class="dark-mode-toggle">
                <i class="fas fa-moon"></i> -->
                </div>
            </ul>
        </nav>
</header> 
<main>

<?php
session_start();
$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset'=>'utf8'));

if (isset($_GET['Profilbild'])) {
    $BenutzerID = $_GET['Profilbild'];

    // Hole das Profilbild
    $statement = $db->prepare('SELECT Profilbild FROM Benutzer WHERE id = :id');
    $statement->bindParam(':id', $BenutzerId);
    $statement->execute();
    $ordner = $statement->fetch(PDO::FETCH_ASSOC);

} else {
    $_SESSION['error'] = 'Es ist ein Fehler aufgetreten. Bitte versuche es erneut.';
    header('Location: index.php');
    exit();
}

?>
</main>
</body>
</html>