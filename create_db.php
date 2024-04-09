<?php
$servername = "localhost";
$username = "root";
$password = "36612045Dd";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Drop existing database if it exists
$sql_drop_database = "DROP DATABASE IF EXISTS GestionService";
if ($conn->query($sql_drop_database) === TRUE) {
    echo "Existing database dropped successfully<br>";
} else {
    echo "Error dropping existing database: " . $conn->error . "<br>";
}

// Create database
$sql_create_database = "CREATE DATABASE GestionService";
if ($conn->query($sql_create_database) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();
?>
