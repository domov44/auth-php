<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "zechifoumi");

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué: " . $conn->connect_error);
    }

    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT id, password FROM user WHERE pseudo = '$pseudo'");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $token = bin2hex(random_bytes(16));
            $_SESSION['token'] = $token;
            header("Location: index.php");
            exit();
        } else {
            echo "Mot de passe incorrect";
        }
    } else {
        echo "Utilisateur non trouvé";
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <form method="post">
        <label for="pseudo">Pseudo:</label>
        <input type="text" id="pseudo" name="pseudo" required><br>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Se connecter">
    </form>
</body>
</html>

