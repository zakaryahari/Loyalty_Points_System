<?php

namespace App\Models;

class User {
    private $db;
    private int $id;
    private string $email;
    private string $password_hash;
    private string $name;
    private int $total_points;

    public function __construct($db) {
        $this->db = $db;
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

    public function setName(string $name): void { 
        $this->name = $name;
    }
    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setPassword(string $password): void {
        $this->password_hash = password_hash($password, PASSWORD_BCRYPT);
    }

    public function verifyPassword(string $password): bool {
        return password_verify($password, $this->password_hash);
    }

    public function register(array $data): bool {
        
    }

    public function login(string $email, string $password): bool {
        
    }

    public function updatePoints(int $userId, int $points): bool {
        
    }
}