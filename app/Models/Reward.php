<?php

namespace App\Models;

class Reward {
private $db;
    private int $id;
    private string $name;
    private int $points_required;
    private string $description; 
    private int $stock;

    public function __construct($db, $data = []) {
        $this->db = $db;

        $this->id = $data['id'] ?? 0;
        $this->name = $data['name'] ?? '';
        $this->points_required = $data['points_required'] ?? 0;
        $this->description = $data['description'] ?? '';
        $this->stock = $data['stock'];
    }


    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getPointsRequired(): int { return $this->points_required; }
    public function getDescription(): string { return $this->description; }
    public function getStock(): int { return $this->stock; }

    public function setName(string $name): void { 
        $this->name = $name; 
    }

    public function setPointsRequired(int $points): void { 
        $this->points_required = $points; 
    }

    public function setDescription(string $description): void { 
        $this->description = $description; 
    }

    public function setStock(int $stock): void { 
        $this->stock = $stock; 
    }

    public function getAll(): array {
        
    }

    public function getById(int $id): ?object {
        
    }

    public function isAvailable(int $id): bool {
        
    }

    public function decrementStock(int $id): bool {
        
    }
}