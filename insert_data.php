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

// Check if services already exist
$sql_check_services = "SELECT COUNT(*) as count FROM Service";
$result = $conn->query($sql_check_services);

if ($result) {
    $row = $result->fetch_assoc();
    $service_count = $row["count"];

    if ($service_count > 0) {
        echo "Services already exist in the database<br>";
    } else {
        // Insert data into Service table with French service names
        $sql_insert_service = "INSERT INTO Service (nom_service, nombre_employe) VALUES
        ('Service des Ressources Humaines', 10),
        ('Service de Marketing', 15),
        ('Service de Développement', 20)";

        if ($conn->query($sql_insert_service) === TRUE) {
            echo "Data inserted into Service table successfully<br>";
        } else {
            echo "Error inserting data into Service table: " . $conn->error . "<br>";
        }
    }
} else {
    echo "Error checking existing services: " . $conn->error . "<br>";
}

// Insert data into Personnel table with Arabic employee names
$sql_insert_personnel = "INSERT INTO Personnel (nom, prenom, adresse, email, num_mobile, date_recrutement, numero_service) VALUES
('Ahmed', 'Mohammed', '123 Rue de Test', 'ahmed.mohammed@entrepriseY.com', '12345678', '2023-01-01', 1),
('Fatima', 'Ali', '456 Avenue de Test', 'fatima.ali@entrepriseY.com', '87654321', '2022-05-15', 2),
('Omar', 'Sami', '789 Boulevard de Test', 'omar.sami@entrepriseY.com', '55555555', '2024-03-10', 3)
";

if ($conn->query($sql_insert_personnel) === TRUE) {
    echo "Data inserted into Personnel table successfully<br>";
} else {
    echo "Error inserting data into Personnel table: " . $conn->error . "<br>";
}

$conn->close();
?>
