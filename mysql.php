<?php

$servername = "mysql.utk.edu";
$username = "mbeck11";
$password = "Pink123!";
$dbname = "mbeck11_421FinalProject";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>