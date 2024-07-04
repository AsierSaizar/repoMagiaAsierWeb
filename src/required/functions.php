<?php
    function connection() {

        //LOCALEKO DATU BASEA
        //$servername = "sql7.freesqldatabase.com"; 
        //$username = "sql7716506"; 
        //$password = "Ryl7RuPmB4";  
        //$dbname = "sql7716506";

        $servername = "localhost"; 
        $username = "root"; 
        $password = "1WMG2023";  
        $dbname = "repermagico";
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        
        if ($conn->connect_error) {
            die("Errorea: " . $conn->connect_error);
        } 

        return $conn;
    }

 
        