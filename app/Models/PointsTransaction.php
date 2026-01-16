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
        $point = (int) floor($amount/100) * 10;
        return $point;
    }

    public function addTransaction(int $userId, int $amount, string $type): bool {
        $sql_get_balance = "SELECT total_points FROM users WHERE id = :id";
        $query_get_balance = $this->db->getConnection()->prepare($sql_get_balance);
        $query_get_balance->bindValue(":id", $userId ,PDO::PARAM_INT);
        $query_get_balance->execute();
        $result_get_balance = $query_get_balance->fetch();

        $new_balance_after = ((int) $result_get_balance['total_points']) + $amount;

        try {
            $this->db->getConnection()->beginTransaction();
                
            $sql = "INSERT INTO points_transactions (user_id ,type, amount , description , balance_after) VALUES (:user_id ,:type, :amount , :description , :balance_after )";
            $query = $this->db->getConnection()->prepare($sql);
            $query->bindValue(":user_id", $userId ,PDO::PARAM_INT);
            $query->bindValue(":type", $type);
            $query->bindValue(":amount", $amount ,PDO::PARAM_INT);
            $query->bindValue(":description", "");
            $query->bindValue(":balance_after", $new_balance_after);
            $query->execute();

            $sql_update_user = "UPDATE users SET total_points = :new_points WHERE id = :id";
            $update_query = $conn->prepare($sql_update_user);
            $update_query->bindValue(":new_points", $new_balance_after, PDO::PARAM_INT);
            $update_query->bindValue(":id", $userId, PDO::PARAM_INT);
            $update_query->execute();

            $this->db->getConnection()->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->getConnection()->rollBack();
            return false;
        }        
    }

    public function getHistory(int $userId): array {
        $sql = "SELECT * FROM points_transactions WHERE user_id = :user_id ORDER BY createdat DESC";
        $query = $this->db->getConnection()->prepare($sql);
        $query->bindValue(":user_id", $userId, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}