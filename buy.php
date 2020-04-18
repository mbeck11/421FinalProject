<?php
    require 'mysql.php';
    require "funcs.php";
    $sql = "SELECT Max(Order_Num) as maxOrder from mbeck11_421FinalProject.Orders";
    $result = $conn->query($sql);
    $r = queryToJson($result);
    $result->close();
    $orderNum = ($r[0].orderNum==null?1:$r[0].orderNum+1);
    echo $orderNum;
    $conn->close();
?>