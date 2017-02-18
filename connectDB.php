<?php
$servername = "localhost";
$usernameDB = "root";
$passwordDB = "mydb";

// Create connection
$conn = new mysqli($servername, $usernameDB, $passwordDB);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";
$testDB = true;



?>