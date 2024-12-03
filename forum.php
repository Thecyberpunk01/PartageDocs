<?php

session_start();
if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: connexion.php');
    exit();
}


require 'config.php'; // Connexion à la base de données



// Pagination

$discussions_par_page = 10;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$offset = ($page - 1) * $discussions_par_page;



// Récupération du nombre total de discussions

$total_stmt = $conn->prepare("SELECT COUNT(*) FROM discussions");

$total_stmt->execute();

$total_discussions = $total_stmt->get_result()->fetch_row()[0];

$total_pages = ceil($total_discussions / $discussions_par_page);



// Récupération des discussions pour la page actuelle

$stmt = $conn->prepare("SELECT id, titre, date_creation FROM discussions ORDER BY date_creation DESC LIMIT ? OFFSET ?");

$stmt->bind_param("ii", $discussions_par_page, $offset);

$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Échange de Cours - Informatique</title>

    <link rel="stylesheet" href="Forum.css">

</head>

<body>

    <div class="container">

        <header>

            <h1>Forum d'Échange de Cours - Informatique</h1>

            <nav>

                <a href="index.php">Accueil</a>

                <a href="create_discussion.php" class="button">Créer une nouvelle discussion</a>

            </nav>

        </header>

        

        <main>

            <h2>Discussions récentes</h2>

            <ul class="discussion-list">

                <?php while ($row = $result->fetch_assoc()): ?>

                    <li>

                        <a href="discussion.php?id=<?php echo $row['id']; ?>">

                            <h3><?php echo htmlspecialchars($row['titre']); ?></h3>

                            <time datetime="<?php echo $row['date_creation']; ?>">

                                <?php echo date('d/m/Y H:i', strtotime($row['date_creation'])); ?>

                            </time>

                        </a>

                    </li>

                <?php endwhile; ?>

            </ul>



            <div class="pagination">

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>

                    <a href="?page=<?php echo $i; ?>" <?php echo ($i == $page) ? 'class="active"' : ''; ?>>

                        <?php echo $i; ?>

                    </a>

                <?php endfor; ?>

            </div>

        </main>



        <footer>

            <p>&copy; 2024 Échange de Cours - Informatique. Tous droits réservés.</p>

        </footer>

    </div>

</body>

</html>