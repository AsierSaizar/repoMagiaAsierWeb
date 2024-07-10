<?php
    function connection() {

        //RASPBERRY PI
        $servername = "192.168.1.23"; 
        $username = "asiersql"; 
        $password = "123";  
        $dbname = "diarioMagico";

        //$servername = "localhost"; 
        //$username = "root";
        //$password = "1WMG2023";  
        //$dbname = "repermagico";

        $conn = new mysqli($servername, $username, $password, $dbname);
    
        
        if ($conn->connect_error) {
            die("Errorea: " . $conn->connect_error);
        } 

        return $conn;
    }

 
        