<?php
require_once('session.php');

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

echo "Bienvenue sur la page protégée!";
?>
