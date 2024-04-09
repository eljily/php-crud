<?php
// Retrieve errors and POST data
$errors = isset($_GET['errors']) ? unserialize(urldecode($_GET['errors'])) : [];
$postData = $_GET;

// Function to display errors
function displayError($fieldName, $errors) {
    if (isset($errors[$fieldName])) {
        echo '<div class="error">' . $errors[$fieldName] . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un nouvel employé</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }
        label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

/* Select style */
select {
    width: 100%;
    padding: 8px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <form action="insert_employee.php" method="post">
        <?php
        // Display validation errors next to input fields
        displayError('nom', $errors);
        ?>
        <label for="nom">Nom:</label><br>
        <input type="text" id="nom" name="nom" value="<?php echo isset($postData['nom']) ? $postData['nom'] : ''; ?>"><br>
        
        <?php
        displayError('prenom', $errors);
        ?>
        <label for="prenom">Prénom:</label><br>
        <input type="text" id="prenom" name="prenom" value="<?php echo isset($postData['prenom']) ? $postData['prenom'] : ''; ?>"><br>
        
        <?php
        displayError('adresse', $errors);
        ?>
        <label for="adresse">Adresse:</label><br>
        <input type="text" id="adresse" name="adresse" value="<?php echo isset($postData['adresse']) ? $postData['adresse'] : ''; ?>"><br>
        
        <?php
        displayError('email', $errors);
        ?>
        <label for="email">Email:</label><br>
        <input type="text" id="email" name="email" value="<?php echo isset($postData['email']) ? $postData['email'] : ''; ?>"><br>
        
        <?php
        displayError('num_mobile', $errors);
        ?>
        <label for="num_mobile">Numéro de mobile:</label><br>
        <input type="text" id="num_mobile" name="num_mobile" value="<?php echo isset($postData['num_mobile']) ? $postData['num_mobile'] : ''; ?>"><br>
        
        <?php
        displayError('date_recrutement', $errors);
        ?>
        <label for="date_recrutement">Date de recrutement:</label><br>
        <input type="date" id="date_recrutement" name="date_recrutement" value="<?php echo isset($postData['date_recrutement']) ? $postData['date_recrutement'] : ''; ?>"><br>
        
        <?php
        displayError('numero_service', $errors);
        ?>
        <label for="service">Service:</label><br>
        <select id="service" name="numero_service" required>
        <option value="" selected disabled>Choisir le service</option>
            <?php
            // Établir la connexion à la base de données
            $servername = "localhost";
            $username = "root";
            $password = "36612045Dd";
            $dbname = "GestionService";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Vérifier la connexion
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Requête SQL pour récupérer tous les services
            $sql = "SELECT * FROM Service";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Afficher les options pour les services
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["numero_service"] . "'>" . $row["nom_service"] . "</option>";
                }
            } else {
                echo "<option value=''>Aucun service trouvé</option>";
            }

            // Fermer la connexion
            $conn->close();
            ?>
        </select><br>

        
        <input type="submit" value="Ajouter">
    </form>
</body>
</html>
