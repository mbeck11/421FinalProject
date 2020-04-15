<?php
    function queryToJson($result){
        $myArray = array();
        if ($result) {

            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $myArray[] = $row;
            }
            return json_encode($myArray);
        }
    }   
?>