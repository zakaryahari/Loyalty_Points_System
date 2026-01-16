<?php

namespace App\Models;

class User {
    private $db;
    private int $id;
    private string $email;
    private string $password_hash;
    private string $name;
    private int $total_points;
    private string $createdat;

    public function __construct($db , $data) {
        $this->db = $db;
        
        $this->id = $data['id'] ?? 0;
        $this->email = $data['email'] ?? '';
        $this->password_hash = $data['password_hash'] ?? '';
        $this->name = $data['name'] ?? '';
        $this->total_points = $data['total_points'] ?? 0;
        $this->createdat = $data['createdat'] ?? date('Y-m-d H:i:s');
    }

    public function getId(): int { 
        return $this->id; 
    }
    public function getEmail(): string { 
        return $this->email; 
    }
    public function getName(): string {
        return $this->name; 
    }
    public function getTotalPoints(): int { 
        return $this->total_points; 
    }

    public function getcreatedat(): DateTime {
        return $this->createdat;
    }

    public function setName(string $name): void { 
        $this->name = $name;
    }
    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setcreatedat(DateTime $createdat): void {
        $this->createdat = $createdat;
    }

    public function setPassword(string $password): void {
        $this->password_hash = password_hash($password, PASSWORD_BCRYPT);
    }

    public function verifyPassword(string $password): bool {
        return password_verify($password, $this->password_hash);
    }

    public function register(array $data): bool {
        try {
            $this->db->getConnection()->beginTransaction();

            $sql = "INSERT INTO users (email, password_hash ,name , total_points ,createdat) VALUES (:email, :password_hash , :name ,:total_points ,:createdat )";
            $query = $this->db->getConnection()->prepare($sql);
            $query->bindValue(":email", $data['email']);
            $hashed_pw = password_hash($password, PASSWORD_BCRYPT);
            $query->bindValue(":password_hash", $hashed_pw);
            $query->bindValue(":name", $data['name']);
            $query->bindValue(":total_points", $data['total_points']);
            $query->bindValue(":createdat", $data['createdat']);
            $query->execute();
            $newId = $db->lastInsertId();

            $this->id = (int) $newId;

            $this->db->getConnection()->commit();
            return true;
        } catch (Exception $e) {
            $this->db->getConnection()->rollBack();
            return false;
        }
    }

    public function login(string $email, string $password): bool {
        $sql = "SELECT * FROM users WHERE email = :email";
        $query = $this->db->getConnection()->prepare($sql);
        $query->bindValue(":email", $email);
        $query->execute();
        $result = $query->fetch();

        if (!$result) {
            return false;
        }
        else{
        
            $this->email = $result['email'];

            if (!$this->verifyPassword($password)) {
                return false;
            }
            return true;
        }
    }

    public function updatePoints(int $userId, int $points): bool {
        try {
            $this->db->getConnection()->beginTransaction();

            $sql = "UPDATE users SET total_points = :total_points WHERE id = :id" ;
            $query = $this->db->getConnection()->prepare($sql);
            $query->bindValue(":id", $userId , PDO::PARAM_INT);
            $query->bindValue(":total_points", $points , PDO::PARAM_INT);
            $query->execute();

            $this->db->getConnection()->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->getConnection()->rollBack();
            return false;
        }
    }
}