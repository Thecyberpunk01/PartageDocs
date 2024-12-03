<!-- post_message.php -->
<?php
session_start();
require 'config.php'; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $discussion_id = $_POST['discussion_id'];
    $contenu = $_POST['contenu'];
    $utilisateur_id = $_SESSION['utilisateur_id'];

    if (!empty($contenu)) {
        $stmt = $conn->prepare("INSERT INTO messages (discussion_id, utilisateur_id, contenu) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $discussion_id, $utilisateur_id, $contenu);

        if ($stmt->execute()) {
            header("Location: discussion.php?id=".$discussion_id);
            exit();
        } else {
            echo "Erreur : " . $conn->error;
        }
    } else {
        echo "Veuillez entrer un message.";
    }
}
?>
