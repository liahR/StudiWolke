<?php
session_start();

if (!isset($_SESSION['BenutzerId'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['submit'])) {
    // Datenbankverbindung herstellen
    $pdo=new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090','eetho6Choh', array('charset'=>'utf8'));

    // Profilbild hochladen und Pfad speichern
    if (!empty($_FILES['Profilbild']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["Profilbild"]["name"]);
        move_uploaded_file($_FILES["Profilbild"]["tmp_name"], $target_file);
        $Profilbild = $target_file;
    } else {
        $Profilbild = "";
    }

    // Update der Benutzerdaten
    $query = "UPDATE Benutzer SET Vorname=:Vorname, Nachname=:Nachname, Email=:Email, Nutzername=:Nutzername, Passwort=:Passwort, Profilbild=:Profilbild WHERE BenutzerId=:BenutzerId";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':Vorname', $_POST['Vorname']);
    $stmt->bindValue(':Nachname', $_POST['Nachname']);
    $stmt->bindValue(':Email', $_POST['Email']);
    $stmt->bindValue(':Nutzername', $_POST['Nutzername']);
    $stmt->bindValue(':Passwort', password_hash($_POST['Passwort'], PASSWORD_DEFAULT));
    $stmt->bindValue(':Profilbild', $Profilbild);
    $stmt->bindValue(':BenutzerId', $_SESSION['BenutzerId']);
    $stmt->execute();

    // Datenbankverbindung schließen
    $pdo = null;

    // Erfolgsmeldung ausgeben und Weiterleitung
    $_SESSION['success_msg'] = "Deine Daten wurden erfolgreich aktualisiert!";
    header("Location: account.php");
    exit;
}