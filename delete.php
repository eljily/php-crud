<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un employé</title>
</head>
<body>
    <?php
    // Vérifier si l'identifiant de l'employé est passé en paramètre
    if(isset($_GET['employee_id'])) {
        $employee_id = $_GET['employee_id'];

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

        // Requête SQL pour supprimer l'employé avec l'identifiant spécifié
        $sql = "DELETE FROM Personnel WHERE numero = $employee_id";

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
</body>
</html>
