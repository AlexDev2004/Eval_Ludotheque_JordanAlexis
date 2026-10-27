<?php session_start(); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/css/style.css">
    <title>Ludothèque</title>
</head>
<body>
    <nav><?php 
        if(isset($_SESSION['prenom'])) { echo("
            <p>Bonjour $_SESSION[prenom].</p>
            <a href='../index.php'>Accueil</a>
            <a href='../ajout-jeu.php'>Ajouter un jeu</a>
            <a href='../mon-compte.php'>Mon compte</a>
            <a href='../deconnection.php'>Déconnection</a>
        ");}else{ echo("
            <a href='../index.php'>Accueil</a>
            <a href='../connection.php'>Connection</a>
            <a href='../Inscription.php'>Inscription</a>
        ");}
    ?></nav>
</body>
</html>