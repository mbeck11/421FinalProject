<?php
    require "mysql.php";
    $username = $password = $confirm_password = "";
    if(empty($_POST['username']))
    {
        echo "You must enter a username.";
    }else{
        $sql = "SELECT username FROM Customer WHERE username = ?";
        
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    echo "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
        if(!empty($username)){
            $sql = "INSERT INTO Customer (Username, Password, Address, Name, State, Zip, CardNumber) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
            if($stmt = $conn->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("sssssii", $param_username, $param_password, $param_address,$param_name, $param_state,$param_zip,$param_card);
                
                // Set parameters
                $param_username = $username;
                $param_password = $_POST["password"];
                $param_address=$_POST["address"];
                $param_name=$_POST["name"];
                $param_state=$_POST["state"];
                $param_zip=intval($_POST["zip"]);
                $param_card=intval($_POST["cardnumber"]);
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Redirect to login page
                    header("Location:login.html");
                } else{
                    echo "Something went wrong. Please try again later.";
                }

                // Close statement
                $stmt->close();
            }
        }
    }
    $conn->close();
?>
