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