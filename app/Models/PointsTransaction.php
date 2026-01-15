<?php

namespace App\Models;

class PointsTransaction {
private $db;
    private int $id;
    private int $user_id;
    private string $type;
    private int $amount;
    private string $description;
    private int $balance_after;
    private string $createdat;

    public function __construct($db, $data = []) {
        $this->db = $db;
        $this->id = $data['id'] ?? 0;
        $this->user_id = $data['user_id'] ?? 0;
        $this->type = $data['type'] ?? 'earned';
        $this->amount = $data['amount'] ?? 0;
        $this->description = $data['description'] ?? '';
        $this->balance_after = $data['balance_after'] ?? 0;
        $this->createdat = $data['createdat'] ?? date('Y-m-d H:i:s');
    }

    public function getId(): int { return $this->id; }
    public function getUserId(): int { return $this->user_id; }
    public function getType(): string { return $this->type; }
    public function getAmount(): int { return $this->amount; }
    public function getDescription(): string { return $this->description; }
    public function getBalanceAfter(): int { return $this->balance_after; }
    public function getCreatedAt(): string { return $this->createdat; }


    public function setUserId(int $user_id): void { $this->user_id = $user_id; }
    public function setType(string $type): void { $this->type = $type; }
    public function setAmount(int $amount): void { $this->amount = $amount; }
    public function setDescription(string $description): void { $this->description = $description; }
    public function setBalanceAfter(int $balance): void { $this->balance_after = $balance; }

    public function calculatePoints(float $amount): int {
        
    }

    public function addTransaction(int $userId, int $amount, string $type): bool {
        
    }

    public function getHistory(int $userId): array {
        
    }
}