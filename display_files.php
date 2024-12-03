<?php

session_start();

$dsn = 'mysql:host=sql103.infinityfree.com;dbname=if0_37212495_inscription_sitetude;charset=utf8';

$username = 'if0_37212495';

$password = 'Aqd29Ur7zD';



try {

    $pdo = new PDO($dsn, $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    echo 'Erreur de connexion : ' . $e->getMessage();

    exit();

}

$course_ids = [

    1 => 'Introduction des réseaux',

    2 => 'Programmation web: (HTML, JavaScript, CSS)',

    3 => 'Techniques de Communication',

    4 => 'Langage C',

    5 => 'Architectures des réseaux',

    6 => 'Initiation en Informatique',

    7 => 'Économie d\'entreprise',

    8 => 'Probabilités',

    9 => 'Analyse',

    10 => 'Utilisation des SE et Scripts',

    11 => 'Architecture des Ordinateurs',

    12 => 'Algorithmique et structures de données',

    13 => 'Introduction aux SGBD',

    14 => 'Système de Gestion de Base de Données',

    15 => 'Modélisation SI',

    16 => 'Programmation orientée-Objet-JAVA',

    17 => 'Veille technologique',

    18 => 'Développement mobile',

    19 => 'Préparation à l\'insertion professionnelle',

    20 => 'Techniques complémentaires de Production de Logiciels'

];





$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : null;



if ($course_id === null || !array_key_exists($course_id, $course_ids)) {

    echo "Cours non trouvé.";

    exit();

}



$course_name = $course_ids[$course_id];



// Rechercher les fichiers pour le cours spécifié

$sql = "SELECT nom_fichier, chemin_fichier FROM fichiers WHERE cours_id = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([$course_id]);

$files = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Fichiers du cours - <?php echo htmlspecialchars($course_name); ?></title>

</head>

<body>

    <h1>Fichiers disponibles pour le cours : <?php echo htmlspecialchars($course_name); ?></h1>



    <?php if ($files): ?>

        <ul>

            <?php foreach ($files as $file): ?>

                <li>

                    <a href="<?php echo htmlspecialchars($file['chemin_fichier']); ?>" download><?php echo htmlspecialchars($file['nom_fichier']); ?></a>

                </li>

            <?php endforeach; ?>

        </ul>

    <?php else: ?>

        <p>Aucun fichier disponible pour ce cours.</p>

    <?php endif; ?>



    <a href="index.php">Retour à l'accueil</a>

</body>

</html>

