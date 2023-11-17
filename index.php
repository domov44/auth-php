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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="max-w-md w-full p-6 bg-white rounded-md shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Bienvenue sur la page protégée!</h2>

        <form method="post" action="logout.php">
            <button type="submit" name="logout" class="bg-red-500 text-white px-4 py-2 rounded-md">Déconnexion</button>
        </form>
    </div>
</body>

</html>