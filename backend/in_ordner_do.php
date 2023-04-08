<?php
session_start();
$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset'=>'utf8'));


if (isset($_GET['OrdnerId'])) {
    $ordner_id = $_GET['OrdnerId'];

    // Hole den Ordnernamen
    $statement = $db->prepare('SELECT Ordnername original FROM Ordner WHERE id = :id');
    $statement->bindParam(':id', $ordner_id);
    $statement->execute();
    $ordner = $statement->fetch(PDO::FETCH_ASSOC);

    // Hole die Dateien des Ordners
    $statement = $db->prepare('SELECT * FROM Dateien WHERE OrdnerId = :OrdnerId ORDER BY Dateiname original');
    $statement->bindParam(':OrdnerId', $OrdnerId);
    $statement->execute();
    $dateien = $statement->fetchAll(PDO::FETCH_ASSOC);
} else {
    $_SESSION['error'] = 'Es ist ein Fehler aufgetreten. Bitte versuche es erneut.';
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title><?php echo $Ordner['Ordnername original']; ?></title>
</head>
<body>
    <h1><?php echo $Ordner['Ordnername original']; ?></h1>

    <table>
        <thead>
            <tr>
                <th>Dateiname</th>
                <th>Größe</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dateien as $datei) { ?>
                <tr>
                    <td><?php echo $datei['dateiname']; ?></td>
                    <td><?php echo $datei['groesse']; ?></td>
                    <td>
                        <a href="delete_file_do.php=<?php echo $Datei['id']; ?>&OrdnerId=<?php echo $OrdnerId; ?>">Löschen</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="upload.php<?php echo $OrdnerId; ?>">Datei hochladen</a>
</body>
</html>