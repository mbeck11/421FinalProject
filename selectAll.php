<?php
require "funcs.php";
require "mysql.php";
$sql = "select * from Orders;";
$result = $conn->query($sql);
$r = queryToJson($result);

$conn->close();
$result->close();
echo $r;
?>