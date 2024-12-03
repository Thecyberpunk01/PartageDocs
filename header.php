<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}
?>
<header>
    <div class="container">
        <h1>Échange de Cours - Informatique</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="messagerie.php">Messagerie</a></li>
                <li><a href="forum.php">Forum</a></li>
                <?php if (isset($_SESSION['utilisateur_id'])): ?>
                    <li><a href="deconnexion.php">Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="connexion.php">Connexion</a></li>
                    <li><a href="inscription.php">Inscription</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
