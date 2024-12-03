<?php
session_start();
if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: connexion.php');
    exit();
}

// Liste des cours
$courses = [
    1 => ['title' => 'Introduction des réseaux', 'level' => 'licence1'],
    2 => ['title' => 'Programmation web: (HTML, JavaScript, CSS)', 'level' => 'licence1'],
    3 => ['title' => 'Techniques de Communication', 'level' => 'licence1'],
    4 => ['title' => 'Langage C', 'level' => 'licence1'],
    5 => ['title' => 'Architectures des réseaux', 'level' => 'licence1'],
    6 => ['title' => 'Initiation en Informatique', 'level' => 'licence1'],
    7 => ['title' => 'Économie d\'entreprise', 'level' => 'licence1'],
    8 => ['title' => 'Probabilités', 'level' => 'licence1'],
    9 => ['title' => 'Analyse', 'level' => 'licence1'],
    10 => ['title' => 'Utilisation des SE et Scripts', 'level' => 'licence1'],
    11 => ['title' => 'Architecture des Ordinateurs', 'level' => 'licence1'],
    12 => ['title' => 'Algorithmique et structures de données', 'level' => 'licence1'],
    13 => ['title' => 'Introduction aux SGBD', 'level' => 'licence1'],
    14 => ['title' => 'Anglais: Technique d\'expression', 'level' => 'licence1'],
    15 => ['title' => 'Système de Gestion de Base de Données', 'level' => 'licence2'],
    16 => ['title' => 'Modélisation SI', 'level' => 'licence2'],
    17 => ['title' => 'Programmation orientée-Objet-JAVA', 'level' => 'licence2'],
    18 => ['title' => 'Veille technologique', 'level' => 'licence2'],
    19 => ['title' => 'Développement mobile', 'level' => 'licence2'],
    20 => ['title' => 'Préparation à l\'insertion professionnelle', 'level' => 'licence2'],
    21 => ['title' => 'SE', 'level' => 'licence2'],
    22 => ['title' => 'Reseaux', 'level' => 'licence2'],
    23 => ['title' => 'Statistique', 'level' => 'licence2'],
    24 => ['title' => 'Economie', 'level' => 'licence2'],
    25 => ['title' => 'SGBD', 'level' => 'licence2'],
    26 => ['title' => 'Anglais', 'level' => 'licence2'],
    27 => ['title' => 'Backend', 'level' => 'licence2'],
    28 => ['title' => 'Culture et Société', 'level' => 'licence2'],
    29 => ['title' => 'RO', 'level' => 'licence2'],
    30 => ['title' => 'GDE', 'level' => 'licence2'],
    31 => ['title' => 'GDP', 'level' => 'licence2'],
    32 => ['title' => 'Memoire', 'level' => 'licence2'],
    33 => ['title' => 'Techniques complémentaires de Production de Logiciels', 'level' => 'licence2']
];


// Structure pour lier les fichiers aux cours
$course_files = [];

// Fonction pour récupérer les fichiers et les associer aux cours
function updateCourseFiles() {
    global $course_files, $courses;
    $uploaded_files = array_diff(scandir("uploads/"), array('.', '..'));
    $course_files = [];
    foreach ($uploaded_files as $file) {
        $file_info = pathinfo($file);
        $file_name = $file_info['filename'];
        $course_id = intval(explode('_', $file_name)[0]);
        if (isset($courses[$course_id])) {
            if (!isset($course_files[$course_id])) {
                $course_files[$course_id] = [];
            }
            $course_files[$course_id][] = $file;
        }
    }
}

// Appel initial pour mettre à jour la liste des fichiers
updateCourseFiles();

// Fonction de téléchargement de fichier
function downloadFiles($course_id) {
    global $course_files;
    if (isset($course_files[$course_id])) {
        // Créer un fichier zip pour contenir tous les fichiers du cours
        $zip = new ZipArchive();
        $zip_filename = "cours_$course_id.zip";
        if ($zip->open($zip_filename, ZipArchive::CREATE) !== TRUE) {
            exit("Impossible de créer le fichier zip.");
        }

        foreach ($course_files[$course_id] as $file) {
            $file_path = "uploads/" . $file;
            if (file_exists($file_path)) {
                $zip->addFile($file_path, $file);
            }
        }

        $zip->close();

        // Envoyer le fichier zip au navigateur pour téléchargement
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . basename($zip_filename) . '"');
        header('Content-Length: ' . filesize($zip_filename));
        flush();
        readfile($zip_filename);

        // Supprimer le fichier zip après téléchargement
        unlink($zip_filename);

        exit;
    } else {
        echo "Aucun fichier disponible pour ce cours.";
    }
}

// Gestion des téléchargements
if (isset($_GET['download']) && isset($_GET['course_id'])) {
    downloadFiles($_GET['course_id']);
}

// Gestion de l'upload de fichiers
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"]) && isset($_POST['course_id'])) {
    $course_id = intval($_POST['course_id']);
    $target_dir = "uploads/";
    $file_info = pathinfo($_FILES["fileToUpload"]["name"]);
    $file_extension = $file_info['extension'];
    $original_filename = $file_info['basename'];
    $target_file = $target_dir . $course_id . "_" . $original_filename;
    $uploadOk = 1;
    $fileType = strtolower($file_extension);

    // Vérifications de sécurité
    $allowed_extensions = array("pdf", "doc", "docx", "txt", "zip","ppt","pptm","pptx");
    if (!in_array($fileType, $allowed_extensions)) {
        $upload_message = "Désolé, seuls les fichiers PDF, DOC, DOCX, TXT,PPT et ZIP sont autorisés.";
        $uploadOk = 0;
    }

    

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $upload_message = "Le fichier ". htmlspecialchars($original_filename) . " a été uploadé et associé au cours.";
            updateCourseFiles(); // Mettre à jour la liste des fichiers
        } else {
            $upload_message = "Désolé, une erreur s'est produite lors de l'upload de votre fichier.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Échange de Cours - Informatique</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1>Échange de Cours - Informatique</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="forum.php">Forum</a></li>
                    <li><a href="deconnexion.php">Déconnexion</a></li>
                </ul>
            </nav>
        </div>
    </header>

    
        <section class="intro">
        <div class="text-animation-container">
            <div class="text-animation">
                BIENVENUE SUR MON SITE DE PARTAGE
            </div>
        </div>
    </section>

        <section class="background-image">
          <p>Partagez vos connaissances et apprenez des autres étudiants</p>
        </section>

        <section class="courses">
            <h2>Cours Disponibles</h2>
            <div class="course-filter">
                <button class="btn" onclick="filterCourses('all')">Tous</button>
                <button class="btn" onclick="filterCourses('licence1')">Licence 1</button>
                <button class="btn" onclick="filterCourses('licence2')">Licence 2</button>
            </div>
            <div class="course-grid" id="course-grid">
                <?php foreach($courses as $id => $course): ?>
                <div class="course-card <?php echo $course['level']; ?>">
                    <h4><?php echo $course['title']; ?></h4>
                    <button class="btn" onclick="openModal(<?php echo $id; ?>)">Voir les fichiers</button>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Modal pour télécharger et uploader -->
        <div id="courseModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2 id="modalTitle"></h2>
                <div class="file-list" id="fileList"></div>
                <div id="uploadSection">
                    <h3>Uploader un nouveau fichier pour ce cours</h3>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="hidden" name="course_id" id="course_id_input">
                        <input type="submit" value="Uploader le fichier" name="submit" class="btn">
                    </form>
                    <?php if(isset($upload_message)): ?>
                        <p><?php echo $upload_message; ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
    var courses = <?php echo json_encode($courses); ?>;
    var course_files = <?php echo json_encode($course_files); ?>;

    function openModal(courseId) {
        var modal = document.getElementById("courseModal");
        var fileList = document.getElementById("fileList");
        var modalTitle = document.getElementById("modalTitle");
        var courseIdInput = document.getElementById("course_id_input");
        
        modalTitle.textContent = "Fichiers pour : " + courses[courseId].title;
        courseIdInput.value = courseId;
        
        // Vider la liste de fichiers existante
        fileList.innerHTML = '';
        
        // Ajouter les fichiers spécifiques au cours
        if (course_files[courseId]) {
            course_files[courseId].forEach(function(file) {
                var fileItem = document.createElement('div');
                fileItem.className = 'file-item';
                fileItem.innerHTML = `
                    <span>${file}</span>
                    <a href="?download=${encodeURIComponent(file)}&course_id=${courseId}" class="btn">Télécharger</a>
                `;
                fileList.appendChild(fileItem);
            });
        } else {
            fileList.innerHTML = '<p>Aucun fichier disponible pour ce cours.</p>';
        }
        
        modal.style.display = "block";
    }

    function closeModal() {
        var modal = document.getElementById("courseModal");
        modal.style.display = "none";
    }

    function filterCourses(level) {
        var courseCards = document.querySelectorAll('.course-card');
        courseCards.forEach(function(card) {
            if (level === 'all' || card.classList.contains(level)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Fermer la modal si l'utilisateur clique en dehors
    window.onclick = function(event) {
        var modal = document.getElementById("courseModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>
</body>
</html>

