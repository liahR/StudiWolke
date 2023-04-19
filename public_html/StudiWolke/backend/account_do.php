<?php
session_start();

if (!isset($_SESSION['benutzerId'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['submit'])) {
    // Datenbankverbindung herstellen
    $pdo=new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-lr090', 'lr090','eetho6Choh', array('charset'=>'utf8'));

    // Profilbild hochladen und Pfad speichern
    if (!empty($_FILES['profilbild']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profilbild"]["name"]);
        move_uploaded_file($_FILES["profilbild"]["tmp_name"], $target_file);
        $profilbild = $target_file;
    } else {
        $profilbild = "";
    }

    // Update der Benutzerdaten
    $query = "UPDATE benutzer SET vorname=:vorname, nachname=:nachname, email=:email, nutzername=:nutzername, passwort=:passwort, profilbild=:profilbild WHERE benutzer_id=:benutzer_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':vorname', $_POST['vorname']);
    $stmt->bindValue(':nachname', $_POST['nachname']);
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->bindValue(':nutzername', $_POST['nutzername']);
    $stmt->bindValue(':passwort', password_hash($_POST['passwort'], PASSWORD_DEFAULT));
    $stmt->bindValue(':profilbild', $profilbild);
    $stmt->bindValue(':benutzer_id', $_SESSION['benutzer_id']);
    $stmt->execute();

    // Datenbankverbindung schließen
    $pdo = null;

    // Erfolgsmeldung ausgeben und Weiterleitung
    $_SESSION['success_msg'] = "Deine Daten wurden erfolgreich aktualisiert!";
    header("Location: account.php");
    exit;
}