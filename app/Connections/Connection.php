<?php

namespace App\Connections;

use Dotenv\Dotenv;

class Connection{

    private $host;
    private $dbName;
    private $user;
    private $password;

    public function __construct(){
        
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $this->host = $_ENV['DB_HOST'];
        $this->dbName = $_ENV['DB_NAME'];
        $this->user = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];
    }

    private function getPdo(){
        try{
            $pdo = new \PDO("mysql:host=".$this->host.";dbname=".$this->dbName, $this->user, $this->password,
            array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
        }catch(\PDOException $e){
            throw new \Exception($e->getMessage());
        }
        return $pdo;
    }

    public function connect(){
        return $this->getPdo();
    }

}