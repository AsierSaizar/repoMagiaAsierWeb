<?php
    function connection() {

        //RASPBERRY PI
        
        //$servername = "172.23.31.204"; 

        //$servername = "localhost";
        //$username = "root"; 
        //$password = "1WMG2023";  

        $servername = "192.168.1.23";
        $username = "asiersql"; 
        $password = "123";  
        
        $dbname = "diarioMagico";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        
        if ($conn->connect_error) {
            die("Errorea: " . $conn->connect_error);
        } 

        return $conn;
    }

 
        