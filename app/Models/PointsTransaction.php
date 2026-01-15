<?php

namespace App\Models;

class PointsTransaction {
    private $db;
    private int $id;
    private int $user_id;
    private string $type;
    private int $amount;
    private int $balance_after;

    public function __construct($db) {
        $this->db = $db;
    }

    public function calculatePoints(float $amount): int {
        
    }

    public function addTransaction(int $userId, int $amount, string $type): bool {
        
    }

    public function getHistory(int $userId): array {
        
    }
}