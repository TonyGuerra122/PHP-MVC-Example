<?php

namespace App\Models;

use App\Connections\Connection;
use App\Interfaces\IModel;

class User implements IModel{

    private string $name;
    private string $email;
    private string $password;
    private static Connection $connection;

    public function __construct(string $name, string $email, string $password){
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getName(){
        return $this->name;
    }
    public function setName(string $name){
        $this->name = $name;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail(string $email){
        $this->email = $email;
    }
    public function setPassword(string $password){
        $this->password = $password;
    }

    public static function findById(int $id): ?User{
        self::$connection = new Connection;
        try{
            $query = self::$connection->connect()->prepare("SELECT * FROM users WHERE id = ?");
            $query->bindValue(1, $id, \PDO::PARAM_INT);
            $query->execute();
            if($query->rowCount() > 0){
                $row = $query->fetch(\PDO::FETCH_ASSOC);
                return new User($row['name'], $row['email'], $row['password']);
            }
        }catch(\PDOException $e){
            throw new \Exception($e->getMessage());
        }
        http_response_code(500);
        return null;
    }

    public function save(): bool{
        self::$connection = new Connection;
        $hash = password_hash($this->password, PASSWORD_BCRYPT);
        try{
            $query = self::$connection->connect()->prepare("INSERT INTO users VALUES (NULL, ?, ?, ?)");
            $query->bindValue(1, $this->name, \PDO::PARAM_STR);
            $query->bindValue(2, $this->email, \PDO::PARAM_STR);
            $query->bindValue(3, $hash, \PDO::PARAM_STR);
            $query->execute();
            return true;
        }catch(\PDOException $e){
            throw new \Exception($e->getMessage());
        }
        return false;
        http_response_code(500);
    }

    public static function findByEmail(string $email): ?User{
        self::$connection = new Connection;
        try{
            $query = self::$connection->connect()->prepare("SELECT * FROM users WHERE email LIKE ?");
            $query->bindValue(1, $email, \PDO::PARAM_INT);
            $query->execute();
            if($query->rowCount() > 0){
                $row = $query->fetch(\PDO::FETCH_ASSOC);
                return new User($row['name'], $row['email'], $row['password']);
            }
        }catch(\PDOException $e){
            throw new \Exception($e->getMessage());
        }
        return null;
    }

    public function verifyPassword(string $password){
        return password_verify($password, $this->password);
    }

}