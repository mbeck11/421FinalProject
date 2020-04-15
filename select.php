<?php
require "funcs.php";
function select($statement){
    require "mysql.php";
    $sql = $statement;
    $result = $conn->query($sql);
    $r = queryToJson($result);

    $conn->close();
    $result->close();
    return $r;
}
?>
