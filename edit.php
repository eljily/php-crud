<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un employé</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
        }
        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
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

        // Requête SQL pour sélectionner les détails de l'employé à modifier
        $sql = "SELECT * FROM Personnel WHERE numero = $employee_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Afficher le formulaire de modification avec les détails de l'employé
            $row = $result->fetch_assoc();
            ?>
            <form action="update.php" method="post">
                <input type="hidden" name="employee_id" value="<?php echo $row['numero']; ?>">
                
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="<?php echo $row['nom']; ?>">
                
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" value="<?php echo $row['prenom']; ?>">
                
                <label for="adresse">Adresse:</label>
                <input type="text" id="adresse" name="adresse" value="<?php echo $row['adresse']; ?>">
                
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo $row['email']; ?>">
                
                <label for="num_mobile">Numéro de mobile:</label>
                <input type="text" id="num_mobile" name="num_mobile" value="<?php echo $row['num_mobile']; ?>">
                
                <label for="date_recrutement">Date de recrutement:</label>
                <input type="date" id="date_recrutement" name="date_recrutement" value="<?php echo $row['date_recrutement']; ?>">
                
                <label for="service">Service:</label>
                <select id="service" name="numero_service">
                    <?php
                    // Requête SQL pour récupérer tous les services
                    $sql = "SELECT * FROM Service";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Afficher les options pour les services
                        while($serviceRow = $result->fetch_assoc()) {
                            $selected = ($serviceRow['numero_service'] == $row['numero_service']) ? 'selected' : '';
                            echo "<option value='" . $serviceRow["numero_service"] . "' $selected>" . $serviceRow["nom_service"] . "</option>";
                        }
                    } else {
                        echo "<option value='' selected disabled>Choisir le service</option>";
                    }

                    ?>
                </select>
                
                <input type="submit" value="Modifier">
            </form>
            <?php
        } else {
            echo "Aucun employé trouvé avec cet identifiant.";
        }

        // Fermer la connexion
        $conn->close();
    } else {
        echo "Identifiant de l'employé non fourni";
    }
    ?>
</body>
</html>
