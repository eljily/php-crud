<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Status</title>
</head>
<body>
    <h1>Database Connection Status</h1>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "36612045Dd";

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        echo "<p>La connexion a échoué : " . $conn->connect_error . "</p>";
    } else {
        echo "<p>Connexion réussie</p>";
    }
    ?>
</body>
</html>

