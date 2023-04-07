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
		