<!-- discussion.php -->
<?php
session_start();
require 'config.php'; // Connexion à la base de données

// Vérifie la présence du paramètre 'id' et la validité de l'ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Discussion invalide.";
    exit();
}

$discussion_id = (int)$_GET['id'];

// Prépare et exécute la requête pour récupérer les messages
$stmt = $conn->prepare("SELECT m.id, m.contenu, m.date_envoi, u.username FROM messages m JOIN utilisateurs u ON m.utilisateur_id = u.id WHERE m.discussion_id = ? ORDER BY m.date_envoi ASC");
$stmt->bind_param("i", $discussion_id);
$stmt->execute();
$messages = $stmt->get_result();

// Prépare et exécute la requête pour récupérer les détails de la discussion
$stmt = $conn->prepare("SELECT titre FROM discussions WHERE id = ?");
$stmt->bind_param("i", $discussion_id);
$stmt->execute();
$discussion = $stmt->get_result()->fetch_assoc();

// Vérifie si la discussion existe
if (!$discussion) {
    echo "Discussion non trouvée.";
    exit();
}

// Génère un token CSRF
$csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Forum.css">
    <title><?php echo htmlspecialchars($discussion['titre']); ?></title>
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($discussion['titre']); ?></h1>

        <div class="messages">
            <?php while ($message = $messages->fetch_assoc()): ?>
                <div class="message">
                    <div class="message-header">
                        <strong><?php echo htmlspecialchars($message['username']); ?></strong> 
                        <small><?php echo date('d/m/Y H:i', strtotime($message['date_envoi'])); ?></small>
                    </div>
                    <div class="message-content">
                        <?php echo htmlspecialchars($message['contenu']); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <form method="POST" action="post_message.php" class="message-form">
            <input type="hidden" name="discussion_id" value="<?php echo htmlspecialchars($discussion_id); ?>">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
            <textarea name="contenu" placeholder="Écrivez un message..." required></textarea>
            <button type="submit">Envoyer</button>
        </form>

        <p><a href="forum.php">Retour au forum</a></p>
    </div>
</body>
</html>
<!-- discussion.php -->
<?php
session_start();
require 'config.php'; // Connexion à la base de données

// Vérifie la présence du paramètre 'id' et la validité de l'ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Discussion invalide.";
    exit();
}

$discussion_id = (int)$_GET['id'];

// Prépare et exécute la requête pour récupérer les messages
$stmt = $conn->prepare("SELECT m.id, m.contenu, m.date_envoi, u.username FROM messages m JOIN utilisateurs u ON m.utilisateur_id = u.id WHERE m.discussion_id = ? ORDER BY m.date_envoi ASC");
$stmt->bind_param("i", $discussion_id);
$stmt->execute();
$messages = $stmt->get_result();

// Prépare et exécute la requête pour récupérer les détails de la discussion
$stmt = $conn->prepare("SELECT titre FROM discussions WHERE id = ?");
$stmt->bind_param("i", $discussion_id);
$stmt->execute();
$discussion = $stmt->get_result()->fetch_assoc();

// Vérifie si la discussion existe
if (!$discussion) {
    echo "Discussion non trouvée.";
    exit();
}

// Génère un token CSRF
$csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Forum.css">
    <title><?php echo htmlspecialchars($discussion['titre']); ?></title>
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($discussion['titre']); ?></h1>

        <div class="messages">
            <?php while ($message = $messages->fetch_assoc()): ?>
                <div class="message">
                    <div class="message-header">
                        <strong><?php echo htmlspecialchars($message['username']); ?></strong> 
                        <small><?php echo date('d/m/Y H:i', strtotime($message['date_envoi'])); ?></small>
                    </div>
                    <div class="message-content">
                        <?php echo htmlspecialchars($message['contenu']); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <form method="POST" action="post_message.php" class="message-form">
            <input type="hidden" name="discussion_id" value="<?php echo htmlspecialchars($discussion_id); ?>">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
            <textarea name="contenu" placeholder="Écrivez un message..." required></textarea>
            <button type="submit">Envoyer</button>
        </form>

        <p><a href="forum.php">Retour au forum</a></p>
    </div>
</body>
</html>
