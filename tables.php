<?php
include "mysql.php";
include "funcs.php";
$sql = "show tables;";
$result = $conn->query($sql);
echo queryToJson($result);
$conn->close();
$result->close();

?>