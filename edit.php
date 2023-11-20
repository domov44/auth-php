<?php
require_once('db.php');
require_once('auth.php');
require_once('session.php');

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (!empty($password) && $password === $confirmPassword) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $conn = connectDB();

            $stmt = $conn->prepare("UPDATE user SET pseudo=?, email=?, password=? WHERE id=?");

            $user_id = $_SESSION['user_id'];

            $stmt->bind_param("sssi", $pseudo, $email, $passwordHash, $user_id);

            if ($stmt->execute()) {
                $_SESSION['pseudo'] = $pseudo;
                header("Location: index.php");
                exit();
            } else {
                $message = "Erreur lors de la modification du compte. Veuillez réessayer ultérieurement.";
                error_log("Erreur lors de la modification du compte : " . $stmt->error);
            }

            $stmt->close();
            $conn->close();
        } else {
            $message = "Adresse e-mail invalide. Veuillez fournir une adresse e-mail valide.";
        }
    } elseif (empty($password)) {
        $conn = connectDB();

        $stmt = $conn->prepare("UPDATE user SET pseudo=?, email=? WHERE id=?");

        $user_id = $_SESSION['user_id'];

        $stmt->bind_param("ssi", $pseudo, $email, $user_id);

        if ($stmt->execute()) {
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['email'] = $email;
            header("Location: index.php");
            exit();
        } else {
            $message = "Erreur lors de la modification du compte. Veuillez réessayer ultérieurement.";
            error_log("Erreur lors de la modification du compte : " . $stmt->error);
        }

        $stmt->close();
        $conn->close();
    } else {
        $message = "Les mots de passe ne correspondent pas. Veuillez les saisir à nouveau.";
    }
}

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
    <title>Modifiez votre compte</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="max-w-md w-full p-6 bg-white rounded-md shadow-md">
        <h2 class="text-2xl font-semibold mb-6"><?php echo $_SESSION['pseudo']; ?>, modifiez votre compte</h2>
        <form action="edit.php" method="post">
            <div class="mb-4">
                <label for="pseudo" class="block text-gray-700 text-sm font-bold mb-2">Nouveau pseudo:</label>
                <input type="text" id="pseudo" name="pseudo" class="w-full px-3 py-2 border rounded-md" value="<?php echo $_SESSION['pseudo']; ?>">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Nouvel email:</label>
                <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-md" value="<?php echo $_SESSION['email']; ?>">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Nouveau mot de passe:</label>
                <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">Confirmez le nouveau mot de passe:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="w-full px-3 py-2 border rounded-md">
            </div>

            <?php if (!empty($message)) : ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Erreur!</strong>
                    <span class="block sm:inline"><?php echo $message; ?></span>
                </div>
            <?php endif; ?>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Sauvegarder</button>
            <a href="index.php" class="bg-white-500 text-blue px-4 py-2 rounded-md">Annuler</a>
        </form>
    </div>
</body>

</html>