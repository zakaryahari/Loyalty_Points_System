<?php

namespace App\Models;

class Reward {
    private $db;
    private int $id;
    private string $name;
    private int $points_required;
    private int $stock;

    public function __construct($db) {
        $this->db = $db;
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