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

// Create Service table
$sql_service = "CREATE TABLE IF NOT EXISTS Service (
    numero_service INT AUTO_INCREMENT PRIMARY KEY,
    nom_service VARCHAR(50),
    nombre_employe INT
)";

if ($conn->query($sql_service) === TRUE) {
    echo "Table Service created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// Create Personnel table
$sql_personnel = "CREATE TABLE IF NOT EXISTS Personnel (
    numero INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    adresse VARCHAR(100),
    email VARCHAR(100),
    num_mobile VARCHAR(20),
    date_recrutement DATE,
    numero_service INT,
    FOREIGN KEY (numero_service) REFERENCES Service(numero_service)
)";

if ($conn->query($sql_personnel) === TRUE) {
    echo "Table Personnel created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
