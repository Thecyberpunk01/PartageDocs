<?php



$servername = "sql103.infinityfree.com";



$username = "";



$password = "";



$dbname = "if0_37212495_inscription_sitetude";







// Créer la connexion



$conn = new mysqli($servername, $username, $password, $dbname);







// Vérifier la connexion



if ($conn->connect_error) {



    die("La connexion a échoué : " . $conn->connect_error);



}



?>



