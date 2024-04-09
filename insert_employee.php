<?php
$servername = "localhost";
$username = "root";
$password = "36612045Dd";
$dbname = "GestionService";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errors = []; // Array to store validation errors

// Validate and insert employee data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $email = $_POST['email'];
    $num_mobile = $_POST['num_mobile'];
    $date_recrutement = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['date_recrutement'])));
    $numero_service = $_POST['numero_service'];

    // Validation des données saisies
    if (!ctype_alpha($nom) || !ctype_alpha($prenom)) {
        $errors['nom'] = "Le nom et le prénom doivent être des caractères alphabétiques.";
    }

    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $adresse)) {
        $errors['adresse'] = "L'adresse doit être alphanumérique.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'adresse e-mail n'est pas valide.";
    }

    if (!preg_match("/^[0-9]{8}$/", $num_mobile)) {
        $errors['num_mobile'] = "Le numéro de mobile doit être composé de 8 chiffres.";
    }

    // If there are no errors, insert the data into the database
    if (empty($errors)) {
        $sql = "INSERT INTO Personnel (nom, prenom, adresse, email, num_mobile, date_recrutement, numero_service) 
                VALUES ('$nom', '$prenom', '$adresse', '$email', '$num_mobile', '$date_recrutement', '$numero_service')";

        if ($conn->query($sql) === TRUE) {
            // Redirection vers index.php
            header("Location: index.php");
            exit(); // Arrêter l'exécution du script après la redirection
        } else {
            echo "Erreur lors de la mise à jour des détails de l'employé : " . $conn->error;
        }
    } else {
        // Redirect back to add.php with errors
        header("Location: add.php?errors=" . urlencode(serialize($errors)) . "&" . http_build_query($_POST));
        exit();
    }
}

$conn->close();
?>
