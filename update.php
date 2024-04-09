<?php
// Vérifier si l'identifiant de l'employé est passé en paramètre
if(isset($_POST['employee_id'])) {
    $employee_id = $_POST['employee_id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $email = $_POST['email'];
    $num_mobile = $_POST['num_mobile'];
    $date_recrutement = $_POST['date_recrutement'];
    $numero_service = $_POST['numero_service'];

    // Créer la connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "36612045Dd";
    $dbname = "GestionService";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Requête SQL pour mettre à jour les détails de l'employé
    $sql = "UPDATE Personnel SET nom='$nom', prenom='$prenom', adresse='$adresse', email='$email', num_mobile='$num_mobile', date_recrutement='$date_recrutement', numero_service='$numero_service' WHERE numero=$employee_id";

    if ($conn->query($sql) === TRUE) {
        // Redirection vers index.php
        header("Location: index.php");
        exit(); // Arrêter l'exécution du script après la redirection
    } else {
        echo "Erreur lors de la mise à jour des détails de l'employé : " . $conn->error;
    }

    // Fermer la connexion
    $conn->close();
} else {
    echo "Identifiant de l'employé non fourni";
}
?>
