<?php
require_once('auth.php');
require_once('session.php');

if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    if (authenticateUser($pseudo, $password)) {
        header("Location: index.php");
        exit();
    } else {
        $message = "Identifiants incorrects";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="max-w-md w-full p-6 bg-white rounded-md shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Connexion</h2>

        <?php if (!empty($message)) : ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Erreur!</strong>
                <span class="block sm:inline"><?php echo $message; ?></span>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-4">
                <label for="pseudo" class="block text-gray-700 text-sm font-bold mb-2">Pseudo:</label>
                <input type="text" id="pseudo" name="pseudo" class="w-full px-3 py-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe:</label>
                <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded-md">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Se connecter</button>
            <a href="http://localhost/login/signup.php" class="block mt-2 text-blue-500">Créer un compte</a>
        </form>
    </div>
</body>

</html>