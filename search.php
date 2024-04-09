<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechercher un employé</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"] {
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
        .icon {
            margin-right: 5px;
            cursor: pointer;
        }
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination a {
            color: #007bff;
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            margin: 0 5px;
        }
        .pagination a.active {
            background-color: #007bff;
            color: white;
        }
        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <form action="search.php" method="post">
        <label for="nom">Nom:</label><br>
        <input type="text" id="nom" name="nom" placeholder="Entrez le nom à rechercher"><br>
        
        <input type="submit" value="Rechercher">
    </form>

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

    // Pagination
    $results_per_page = 5;
    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }
    $start_from = ($page - 1) * $results_per_page;

    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer la valeur du champ de recherche
        $search_name = $_POST['nom'];

        // Requête SQL pour rechercher l'employé par nom avec les informations sur le service
        $sql = "SELECT Personnel.numero, Personnel.nom, Personnel.prenom, Personnel.adresse, Personnel.email, Personnel.num_mobile, Personnel.date_recrutement, Service.nom_service 
                FROM Personnel 
                INNER JOIN Service ON Personnel.numero_service = Service.numero_service
                WHERE Personnel.nom LIKE '%$search_name%'
                LIMIT $start_from, $results_per_page";

        // Exécutez la requête
        $result = $conn->query($sql);

        // Vérifiez s'il y a des résultats
        if ($result->num_rows > 0) {
            // Afficher les résultats de la recherche dans un tableau
            echo "<table>";
            echo "<tr><th>Numéro</th><th>Nom</th><th>Prénom</th><th>Adresse</th><th>Email</th><th>Numéro de mobile</th><th>Date de recrutement</th><th>Service</th><th>Action</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["numero"] . "</td>";
                echo "<td>" . $row["nom"] . "</td>";
                echo "<td>" . $row["prenom"] . "</td>";
                echo "<td>" . $row["adresse"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["num_mobile"] . "</td>";
                echo "<td>" . $row["date_recrutement"] . "</td>";
                echo "<td>" . $row["nom_service"] . "</td>";
                echo "<td>";
                echo "<a href='edit.php?employee_id=" . $row["numero"] . "'><i class='fas fa-edit'></i></a>";
                echo " | ";
                // Adding confirmation for deletion
                echo "<a href='delete.php?employee_id=" . $row["numero"] . "' onclick='return confirm(\"Voulez-vous vraiment supprimer cet employé ?\")'><i class='fas fa-trash-alt'></i></a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";

            // Pagination links
            $sql = "SELECT COUNT(*) AS total FROM Personnel WHERE nom LIKE '%$search_name%'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $total_pages = ceil($row["total"] / $results_per_page);

            echo "<div class='pagination'>";
            for ($i = 1; $i <= $total_pages; $i++) {
                // Add the search term and page number as query parameters
                echo "<a href='?page=" . $i . "&nom=" . urlencode($_POST['nom']) . "'>" . $i . "</a>";
            }
            echo "</div>";
        } else {
            echo "Aucun résultat trouvé pour cette recherche.";
        }
    }

    // Fermer la connexion
    $conn->close();
    ?>

</body>
</html>
