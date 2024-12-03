<?php

// Connexion à la base de données
$servername = "sql103.infinityfree.com";

$username = "if0_37212495";

$password = "Aqd29Ur7zD";

$dbname = "if0_37212495_inscription_sitetude";



$conn = new mysqli($servername, $username, $password, $dbname);



if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST['nom'];

    $email = $_POST['email'];

    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT); // Hachage du mot de passe



    // Vérifier si l'email existe déjà

    $sql = "SELECT * FROM utilisateurs WHERE email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();



    if ($result->num_rows > 0) {

        echo "Cet email est déjà utilisé.";

    } else {

        // Insérer l'utilisateur dans la base de données

        $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("sss", $nom, $email, $mot_de_passe);



        if ($stmt->execute()) {

            echo "Inscription réussie !";

            // Redirection vers la page de connexion ou le tableau de bord

            header("Location: connexion.php");

        } else {

            echo "Erreur lors de l'inscription.";

        }

    }



    $stmt->close();

}

$conn->close();

?>

