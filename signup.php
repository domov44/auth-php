<?php
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $conn = connectDB();

        $stmt = $conn->prepare("INSERT INTO user (pseudo, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $pseudo, $email, $password);

        if ($stmt->execute()) {
            echo "Inscription réussie!";
        } else {
            error_log("Erreur lors de l'inscription: " . $stmt->error);
            echo "Erreur lors de l'inscription. Veuillez réessayer ultérieurement.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Adresse email non valide. Veuillez fournir une adresse email valide.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="max-w-md w-full p-6 bg-white rounded-md shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Inscription</h2>
        <form action="signup.php" method="post">
            <div class="mb-4">
                <label for="pseudo" class="block text-gray-700 text-sm font-bold mb-2">Pseudo:</label>
                <input type="text" id="pseudo" name="pseudo" class="w-full px-3 py-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe:</label>
                <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded-md">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">S'inscrire</button>
            <a href="http://localhost/login/login.php" class="block mt-2 text-blue-500">J'ai déjà un compte</a>
        </form>
    </div>
</body>

</html>