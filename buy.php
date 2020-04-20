<?php
    if(isset($_COOKIE["cart"])&&isset($_COOKIE["user"]))
    {
        //get the json of the two cookies
        $user = json_decode(htmlspecialchars_decode($_COOKIE["user"]));
        $cart = json_decode($_COOKIE["cart"]);
        //require to php files that have useful functions
        require 'mysql.php';
        require "funcs.php";
        //find the largest order number
        $sql = "SELECT Max(Order_Num) as maxOrder from mbeck11_421FinalProject.Orders";
        $result = $conn->query($sql);
        $r = json_decode(queryToJson($result));
        $result->close();
        //set a variable to that order number plus one.
        $orderNum = ($r[0]->maxOrder==null?1:intval($r[0]->maxOrder)+1);
        //setup the sql queries to the order and stats and call it for each SKU
        $sql = "INSERT INTO Orders (SKU,Order_Num,Customer_ID,QTY) VALUES (?,?,?,?)";
        $sql2 = "UPDATE Stats SET AmountSold=AmountSold+?, AmountAvailable=AmountAvailable-? WHERE SKU=?";
        $count = 0;
        $stmt = $conn->prepare($sql);
        $stmt2 = $conn->prepare($sql2);
        if($stmt&& $stmt2){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("siii",$param_SKU,$param_Order_Num,$param_Customer,$param_qty);
            $stmt2->bind_param("iis",$param_Sold,$param_Sold2,$param_SKU2);
            foreach($cart as $i){
                if($i->number>0){
                    $param_SKU = $i->sku;
                    $param_Order_Num=intval($orderNum);
                    $param_Customer = intval($user->Customer_ID);
                    $param_qty= intval($i->number);
                    $param_Sold=intval($i->number);
                    $param_Sold2=intval($i->number);
                    $param_SKU2=$i->sku;
                    // Attempt to execute the prepared statement
                    if($stmt->execute()&&$stmt2->execute()){
                        $count++;
                        if($count==count($cart,COUNT_NORMAL))
                        {
                            setcookie("cart","",time()-36000);
                            header("Location:index.html");
                        }
                    } else{
                        echo $stmt->error;
                        echo $stmt2->eror;
                    }
                }
                else{
                    $count++;
                }
            }
        }
        else{
            echo $stmt2->error;
        }
        // Close statement
        $stmt->close();
        $stmt2->close();
        $conn->close();
    }
?>