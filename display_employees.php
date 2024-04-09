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

// Requête SQL pour récupérer les employés groupés par service
$sql = "SELECT s.nom_service, p.nom, p.prenom FROM Service s
        INNER JOIN Personnel p ON s.numero_service = p.numero_service
        ORDER BY s.nom_service, p.nom";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Affichage des employés groupés par service
    while($row = $result->fetch_assoc()) {
        echo "Service: " . $row["nom_service"]. " - Employé: " . $row["prenom"]. " " . $row["nom"]. "<br>";
    }
} else {
    echo "Aucun employé trouvé";
}

$conn->close();
?>
