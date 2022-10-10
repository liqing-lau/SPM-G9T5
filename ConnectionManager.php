<?php

class ConnectionManager {

    public function connect() {
        $servername = 'localhost';
        $username = 'root';
        $password = 'root';
        $dbname = 'ljms';
        
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);     

        return $conn;
    }

}