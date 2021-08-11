<?php

class DB {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '1234';
    private $dbname = 'php-challenge';

    public function connect(){
        $conn_str = "mysql:host=$this->host;dbname=$this->dbname";
        $conn = new PDO($conn_str, $this->user, $this->pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $conn;
    }


}
