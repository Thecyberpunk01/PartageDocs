<?php
session_start();
require 'config.php'; // Connexion à la base de données

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = trim($_POST['titre']);

    if (!empty($titre)) {
        $stmt = $conn->prepare("INSERT INTO discussions (titre, date_creation) VALUES (?, NOW())");
        $stmt->bind_param("s", $titre);

        if ($stmt->execute()) {
            $message = "Discussion créée avec succès.";
            // Redirection vers la page du forum après 2 secondes
            header("refresh:2;url=forum.php");
        } else {
            $error = "Erreur : " . $conn->error;
        }
    } else {
        $error = "Veuillez entrer un titre pour la discussion.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une discussion - Échange de Cours Informatique</title>
    <link rel="stylesheet" href="Forum.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Créer une nouvelle discussion</h1>
            <nav>
                <a href="forum.php">Retour au forum</a>
            </nav>
        </header>
        
        <main>
            <?php if (!empty($message)): ?>
                <div class="message success"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <?php if (!empty($error)): ?>
                <div class="message error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="" class="discussion-form">
                <div class="form-group">
                    <label for="titre">Titre de la discussion :</label>
                    <input type="text" id="titre" name="titre" required>
                </div>
                
                <button type="submit" class="button">Créer la discussion</button>
            </form>
        </main>

        <footer>
            <p>&copy; 2024 Échange de Cours - Informatique. Tous droits réservés.</p>
        </footer>
    </div>
</body>
</html><?php
session_start();
require 'config.php'; // Connexion à la base de données

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = trim($_POST['titre']);

    if (!empty($titre)) {
        $stmt = $conn->prepare("INSERT INTO discussions (titre, date_creation) VALUES (?, NOW())");
        $stmt->bind_param("s", $titre);

        if ($stmt->execute()) {
            $message = "Discussion créée avec succès.";
            // Redirection vers la page du forum après 2 secondes
            header("refresh:2;url=forum.php");
        } else {
            $error = "Erreur : " . $conn->error;
        }
    } else {
        $error = "Veuillez entrer un titre pour la discussion.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une discussion - Échange de Cours Informatique</title>
    <link rel="stylesheet" href="Forum.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Créer une nouvelle discussion</h1>
            <nav>
                <a href="forum.php">Retour au forum</a>
            </nav>
        </header>
        
        <main>
            <?php if (!empty($message)): ?>
                <div class="message success"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <?php if (!empty($error)): ?>
                <div class="message error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="" class="discussion-form">
                <div class="form-group">
                    <label for="titre">Titre de la discussion :</label>
                    <input type="text" id="titre" name="titre" required>
                </div>
                
                <button type="submit" class="button">Créer la discussion</button>
            </form>
        </main>

        <footer>
            <p>&copy; 2024 Échange de Cours - Informatique. Tous droits réservés.</p>
        </footer>
    </div>
</body>
</html>