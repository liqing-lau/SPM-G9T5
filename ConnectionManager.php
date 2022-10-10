<?php

class ConnectionManager {

    public function connect() {
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'ljms';
        
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);     

        return $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // if fail, exception will be thrown
        // Return connection object
        return $conn;
    }
    
}