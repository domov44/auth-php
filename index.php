<?php
session_start();

// Vérifier si l'utilisateur est connecté en vérifiant la présence du token en session
if (!isset($_SESSION['token'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: login.php");
    exit();
}

// Votre contenu protégé ici

echo "Bienvenue sur la page protégée!";
?>
