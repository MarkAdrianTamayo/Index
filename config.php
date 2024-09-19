<?php
$servername = "b0rhnptpftrgxirv6jou-mysql.services.clever-cloud.com";  // Replace with your server name
$username = "ujwbjodj6oladydu";     // Replace with your MySQL username
$password = "oZVriIFpm8EVS34sCkpN";     // Replace with your MySQL password
$dbname = "b0rhnptpftrgxirv6jou";       // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";

// Close the connection
// $conn->close();
?>
