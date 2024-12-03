<?php
session_start();
require 'config.php'; // Connexion à la base de données

// Afficher toutes les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "Formulaire soumis"; // Vérification que le formulaire est bien soumis

    $email = $_POST['email'];
    $motdepasse = $_POST['motdepasse'];

    // Vérifie si la connexion à la base de données fonctionne
    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id, username, motdepasse FROM utilisateurs WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $utilisateur = $result->fetch_assoc();

    if ($utilisateur && password_verify($motdepasse, $utilisateur['motdepasse'])) {
        $_SESSION['utilisateur_id'] = $utilisateur['id'];
        $_SESSION['username'] = $utilisateur['username'];
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['erreur_connexion'] = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="Form_Styles.css">
</head>
<body>
    <main>
        <div class="container">
            <h2>Connexion</h2>
            <form method="POST" action="">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="motdepasse">Mot de passe:</label>
                <input type="password" id="motdepasse" name="motdepasse" required>

                <button type="submit" class="btn">Se connecter</button>
            </form>
            <?php
            if (isset($_SESSION['erreur_connexion'])) {
                echo "<p style='color: red;'>".$_SESSION['erreur_connexion']."</p>";
                unset($_SESSION['erreur_connexion']);
            }
            ?>
            <p>Pas encore inscrit ? <a href="inscription.php">Inscrivez-vous ici</a></p>
        </div>
    </main>
</body>
</html>
