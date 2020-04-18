<?php
require "funcs.php";
require "mysql.php";
$sql = "select * from `Pair of Ears`;";
$result = $conn->query($sql);
$r = queryToJson($result);

$conn->close();
$result->close();
echo $r;
?>