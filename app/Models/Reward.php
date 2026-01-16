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

    public function getAll(): ?array {
        $sql = "SELECT * FROM rewards";
        $query = $this->db->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        if (!$result) {
            return Null;
        }
        else{
            return $result;
        }
    }

    public function getById(int $id): ?self {
        $sql = "SELECT * FROM rewards WHERE id = :id";
        $query = $this->db->getConnection()->prepare($sql);
        $query->bindValue(":id", $id ,PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch();

        if (!$result) {
            return Null;
        }
        else{
            return new self($this->db,$result);
        }
    }

    public function isAvailable(int $id): bool {
        $sql = "SELECT stock FROM rewards WHERE id = :id";
        $query = $this->db->getConnection()->prepare($sql);
        $query->bindValue(":id", $id ,PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch();

        if (!$result) {
            return false;
        }
        else if ($result['stock'] > 0 || $result['stock'] == -1) {
            return true;
        }
    }

    public function decrementStock(int $id): bool {
        $sql_check_stock = "SELECT stock FROM rewards WHERE id = :id";
        $query_check_stock = $this->db->getConnection()->prepare($sql_check_stock);
        $query_check_stock->bindValue(":id", $id ,PDO::PARAM_INT);
        $query_check_stock->execute();
        $result_check_stock = $query_check_stock->fetch();

        if ($result_check_stock['stock'] > 0) {
            try {
                $this->db->getConnection()->beginTransaction();
                  
                $sql = "UPDATE rewards SET stock = stock - 1  WHERE id = :id" ;
                $query = $this->db->getConnection()->prepare($sql);
                $query->bindValue(":id", $id , PDO::PARAM_INT);
                $query->execute();

                $this->db->getConnection()->commit();
                return true;
                
            } catch (Exception $e) {
                $this->db->getConnection()->rollBack();
                return false;
            }        
        }
        elseif ($result_check_stock['stock'] == -1) {
            return true;
        }
        return false;
    }
}