<?php

// upload.php

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



// Tableau des cours avec leurs IDs

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



$course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;



if ($course_id === null || !array_key_exists($course_id, $course_ids)) {

    echo "Cours non trouvé.";

    exit();

}



$course_name = $course_ids[$course_id];



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {

        $upload_dir = 'uploads/';

        $filename = basename($_FILES['document']['name']);

        $target_path = $upload_dir . $filename;



        if (move_uploaded_file($_FILES['document']['tmp_name'], $target_path)) {

            // Insérer les informations du fichier dans la base de données

            $sql = "INSERT INTO fichiers (nom_fichier, chemin_fichier, cours_id) VALUES (?, ?, ?)";

            $stmt = $pdo->prepare($sql);

            if ($stmt->execute([$filename, $target_path, $course_id])) {

                echo "Fichier téléchargé et enregistré avec succès.";

            } else {

                echo "Erreur lors de l'enregistrement du fichier dans la base de données.";

            }

        } else {

            echo "Erreur lors du téléchargement du fichier.";

        }

    } else {

        echo "Aucun fichier téléchargé.";

    }

}

?>

<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Upload de documents - <?php echo htmlspecialchars($course_name); ?></title>

</head>

<body>

    <h1>Upload de documents pour le cours : <?php echo htmlspecialchars($course_name); ?></h1>



    <form action="upload.php?course_id=<?php echo urlencode($course_id); ?>" method="POST" enctype="multipart/form-data">

        <label for="document">Choisir un fichier :</label>

        <input type="file" name="document" id="document" required>

        <button type="submit">Télécharger</button>

    </form>

</body>

</html>

