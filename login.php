<?php
    if(empty($_POST["username"]))
    {
        echo "Please enter a username <br> <a href=\"login.html\">Return to Sign in</a>";
    }
    else{
        require "mysql.php";
        require "funcs.php";
        $sql = "select * from Customer where Username='".$_POST["username"]."';";
        $result = $conn->query($sql);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if($result->num_rows!=1){
            echo "Username not found <br> <a href=\"login.html\">Return to Sign in</a>";
        }
        if($row["Password"]==$_POST["password"])
        {
            setcookie("user",htmlspecialchars(json_encode($row)));
            header("Location:index.html");
        }
        else{
            echo "Incorrect password <br> <a href=\"login.html\">Return to Sign in</a>";
        }
        $result->close();
        $conn->close();
    }
?>