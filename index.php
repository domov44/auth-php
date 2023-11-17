<?php
require_once('session.php');

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page protégée</title>
</head>
<body>
    <h2>Bienvenue sur la page protégée!</h2>
    
    <form method="post" action="logout.php"> <!-- Utilisez l'action pour pointer vers logout.php -->
        <input type="submit" name="logout" value="Déconnexion">
    </form>
</body>
</html>
