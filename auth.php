<?php
require_once('db.php');

function authenticateUser($pseudo, $password)
{
    $conn = connectDB();

    $stmt = $conn->prepare("SELECT id, pseudo, email, password FROM user WHERE pseudo = ?");
    $stmt->bind_param("s", $pseudo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $token = bin2hex(random_bytes(16));
            $_SESSION['token'] = $token;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['pseudo'] = $row['pseudo'];
            $_SESSION['email'] = $row['email'];
            $stmt->close();
            $conn->close();
            return true;
        }
    }

    $stmt->close();
    $conn->close();
    return false;
}
