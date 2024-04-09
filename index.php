<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Employés</title>
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
        ul {
            list-style-type: none;
            padding: 0;
            margin: 20px 0;
            text-align: center;
        }
        ul li {
            display: inline;
            margin-right: 10px;
        }
        ul li a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        ul li a:hover {
            color: #0056b3;
        }
        .fas {
            margin-left: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f2f2f2;
        }
        .actions a {
            text-decoration: none;
            margin-right: 5px;
            color: #007bff;
        }
        .actions a:hover {
            color: #0056b3;
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
        }
        .pagination a.active {
            background-color: #007bff;
            color: white;
        }
        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }
        
        .search-container {
            text-align: center;
            margin-top: 20px;
        }

        .search-container form {
            display: inline-block;
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .search-container input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 200px;
            margin-right: 5px;
        }

        .search-container button {
            padding: 10px;
            border: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <ul>
        <li><a href="add.php">Ajouter un nouvel employé <i class='fas fa-plus'></i></a></li>
    </ul>

    <div class="search-container">
        <form action="" method="post">
            <input type="text" id="searchInput" placeholder="Rechercher par nom..." name="search" required>
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Adresse</th>
                <th>Email</th>
                <th>Numéro de mobile</th>
                <th>Date de recrutement</th>
                <th>Numéro de service</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
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

            // Pagination variables
            $rowsPerPage = 5;
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
            $startFrom = ($currentPage - 1) * $rowsPerPage;

            // Vérifier si le formulaire de recherche a été soumis
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $search_name = $_POST['search'];
                $sql = "SELECT * FROM Personnel WHERE nom LIKE '%$search_name%' LIMIT $startFrom, $rowsPerPage";
            } else {
                // Requête SQL pour récupérer les employés pour la page actuelle
                $sql = "SELECT * FROM Personnel LIMIT $startFrom, $rowsPerPage";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Afficher les données des employés dans la table
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["numero"] . "</td>";
                    echo "<td>" . $row["nom"] . "</td>";
                    echo "<td>" . $row["prenom"] . "</td>";
                    echo "<td>" . $row["adresse"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["num_mobile"] . "</td>";
                    echo "<td>" . $row["date_recrutement"] . "</td>";
                    echo "<td>" . $row["numero_service"] . "</td>";
                    echo "<td>";
                    echo "<a href='edit.php?employee_id=" . $row["numero"] . "'><i class='fas fa-edit'></i></a>";
                    echo " | ";
                    // Ajout de la demande de confirmation pour la suppression
                    echo "<a href='delete.php?employee_id=" . $row["numero"] . "' onclick='return confirm(\"Voulez-vous vraiment supprimer cet employé ?\")'><i class='fas fa-trash-alt'></i></a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>Aucun employé trouvé</td></tr>";
            }

            // Fermer la connexion
            $conn->close();
            ?>

        </tbody>
    </table>
    <div class="pagination">
        <?php
        // Check if a search term is provided
        if (!isset($_POST['search']) && !isset($_GET['search'])) {
            // Pagination variables
            $rowsPerPage = 5;
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
            $startFrom = ($currentPage - 1) * $rowsPerPage;

            // Calculate total number of pages
            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = "SELECT COUNT(*) AS total FROM Personnel";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $totalRows = $row["total"];
            $totalPages = ceil($totalRows / $rowsPerPage);

            // Display pagination links
            echo "<a href='?page=1'>&laquo;</a>"; // First page
            for ($i = 1; $i <= $totalPages; $i++) {
                // Highlight the current page
                $activeClass = ($currentPage == $i) ? 'active' : '';
                echo "<a href='?page=$i' class='$activeClass'>$i</a>";
            }
            echo "<a href='?page=$totalPages'>&raquo;</a>"; // Last page
        }
        ?>
    </div>
    <script>
        // JavaScript to keep the search term in the placeholder
        window.onload = function() {
            var searchInput = document.getElementById('searchInput');
            var currentSearch = localStorage.getItem('searchTerm');

            if (currentSearch) {
                searchInput.placeholder = currentSearch;
                searchInput.value = currentSearch;
            }

            searchInput.addEventListener('input', function() {
                localStorage.setItem('searchTerm', this.value);
            });
        };
    </script>
</body>
</html>
