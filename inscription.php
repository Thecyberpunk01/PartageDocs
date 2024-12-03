<?php

include("config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['username'];
    $email = $_POST['email'];
    $motdepasse = password_hash($_POST['motdepasse'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO utilisateurs (username, email, motdepasse) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nom, $email, $motdepasse);

    if ($stmt->execute()) {
        header("Location: connexion.php");
        exit();
    } else {
        echo "Erreur lors de l'inscription.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="Form_Styles.css">
</head>
<body>
    <main>
        <div class="container">
            <h2>Inscription</h2>
            <form method="POST" action="">
                <label for="username">Nom:</label>
                <input type="text" id="username" name="username" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="motdepasse">Mot de passe:</label>
                <input type="password" id="motdepasse" name="motdepasse" required>

                <button type="submit" class="btn">S'inscrire</button>
            </form>
        </div>
    </main>
</body>
</html>
