<?php
    if(isset($_COOKIE["cart"])&&isset($_COOKIE["user"]))
    {
        $user = json_decode(htmlspecialchars_decode($_COOKIE["user"]));
        $cart = json_decode($_COOKIE["cart"]);
        require 'mysql.php';
        require "funcs.php";
        $sql = "SELECT Max(Order_Num) as maxOrder from mbeck11_421FinalProject.Orders";
        $result = $conn->query($sql);
        $r = json_decode(queryToJson($result));
        $result->close();
        $orderNum = ($r[0]->maxOrder==null?1:intval($r[0]->maxOrder)+1);
        $sql = "INSERT INTO Orders (SKU,Order_Num,Customer_ID,QTY) VALUES (?,?,?,?)";
        $count = 0;   
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("siii",$param_SKU,$param_Order_Num,$param_Customer,$param_qty);
            foreach($cart as $i){
                if($i->number>0){
                    $param_SKU = $i->sku;
                    $param_Order_Num=intval($orderNum);
                    $param_Customer = intval($user->Customer_ID);
                    $param_qty= intval($user->number);
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        $count++;
                        if($count==count($cart,COUNT_NORMAL))
                        {
                            setcookie("cart","",time()-36000);
                            header("Location:index.html");
                        }
                    } else{
                        echo $stmt->error;
                    }
                }
                else{
                    $count++;
                }
            }

            // Close statement
            $stmt->close();
        }
        $conn->close();
    }
?>