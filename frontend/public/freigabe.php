<?php
    session_start();
    if (!isset($_SESSION['BenutzerId'])) {
        header("Location: login.html");
        exit();
    }

    // Verbinden mit der Datenbank
    $pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de;dbname=u-lr090', 'lr090', 'eetho6Choh', array('charset'=>'utf8'));

    // Überprüfen Sie, ob das Formular eingereicht wurde
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Extrahieren Sie die Informationen aus dem Formular
        $DateiId = $_POST['DateiId'];
        $BenutzerId = $_POST['BenutzerId'];
        $permission = $_POST['Berechtigungsart'];

        // Überprüfen Sie, ob der Benutzer bereits Zugriff auf den Ordner hat
        $stmt = $pdo->prepare("SELECT * FROM folder_shares WHERE OrdnerId = ? AND BenutzerId = ?");
        $stmt->execute([$OrdnerId, $BenutzerId]);
        $existing_share = $stmt->fetch();

        // Fügen Sie den Freigabeeintrag in die Datenbank ein oder aktualisieren Sie ihn
        if (!$existing_share) {
            $stmt = $pdo->prepare("INSERT INTO Freigabe (folder_id, user_id, permission) VALUES (?, ?, ?)");
            $stmt->execute([$folder_id, $user_id, $permission]);
        } else {
            $stmt = $pdo->prepare("UPDATE folder_shares SET permission = ? WHERE folder_id = ? AND user_id = ?");
            $stmt->execute([$permission, $folder_id, $user_id]);
        }

        // Zeigen Sie eine Bestätigungsnachricht an
        $message = "Ordner erfolgreich freigegeben!";
    }

    // Laden Sie die verfügbaren Ordner des Benutzers aus der Datenbank
    $stmt = $pdo->prepare("SELECT * FROM folders WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $folders = $stmt->fetchAll();

    // Laden Sie die verfügbaren Benutzer aus der Datenbank
    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll();
?>

<!-- HTML-Formular zum Auswählen des Ordners und Festlegen der Zugriffsberechtigungen -->
<form method="POST">
    <label for="folder_id">Ordner auswählen:</label>
    <select name="folder_id" id="folder_id">
        <?php foreach ($folders as $folder): ?>
            <option value="<?php echo $folder['id']; ?>"><?php echo $folder['name']; ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    <label for="user_id">Benutzer auswählen:</label>
    <select name="user_id" id="user_id">
        <?php foreach ($users as $user): ?>
            <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
       