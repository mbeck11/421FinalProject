<?php
    if(isset($_COOKIE["cart"])&&isset($_COOKIE["user"]))
    {
        $user = json_decode(htmlspecialchars_decode($_COOKIE["user"]));
        $cart = json_decode($_COOKIE["cart"]);
        require 'mysql.php';
        require "funcs.php";
        $sql = "SELECT Max(Order_Num) as maxOrder from mbeck11_421FinalProject.Orders";
        $result = $conn->query($sql);
        $r = queryToJson($result);
        $result->close();
        print_r($r[0]);
        $orderNum = ($r[0]->orderNum==null?1:$r[0]->orderNum+1);
        $sql = "INSERT INTO Orders (SKU,Order_Num,Customer_ID) VALUES (?,?,?)";   
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sii",$param_SKU,$param_Order_Num,$param_Customer);
            foreach($cart as $i){
                if($i->number>0){
                    $param_SKU = $i->sku;
                    $param_Order_Num=intval($orderNum);
                    $param_Customer = intval($user->Customer_ID);
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // Redirect to login page
                        //header("Location:login.html");
                    } else{
                        echo $stmt->error;
                    }
                }
            }

            // Close statement
            $stmt->close();
        }
        $conn->close();
    }
?>