<?php
require 'mysql.php';

$sql = "INSERT INTO knoxville (team,game,topAuto,bottomAuto,topTeleop,bottomTeleop,notes)
VALUES (".$_POST["team"].",".$_POST["game"].",".$_POST["topAuto"].",".$_POST["bottomAuto"].",".$_POST["topTeleop"].",".$_POST["bottomTeleop"].",\"".$_POST["notes"]."\")";

if ($conn->query($sql) === TRUE) {
    echo "<a href=\"index.html\">return to form</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
