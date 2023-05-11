<?php

require_once '../app/Db/database.php';

class ProductModel {
    /**
     * Database instance;
     * @var PDO;
     */
    protected $pdo;
    /**
     * Model using table;
     * @var string;
     */
    protected $table;
    /**
     * Columns from my table;;
     * @var array;
     */
    protected $columns = [];

    public function __construct() {
        $database = new Database();
        $this->pdo = $database->getPdo();
        $this->table = 'product';
    }

    public function getAllProducts() {
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByParam($value) {
        $sql = "SELECT * FROM $this->table WHERE sku = "."'".$value."'";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM $this->table WHERE id = "."'".$id."'";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createProduct($data) {
        $sql = "INSERT INTO $this->table (name, price, type, attribute, sku) VALUES (:name, :price, :type, :attribute, :sku)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":name", $data->name);
        $stmt->bindValue(":price", $data->price);
        $stmt->bindValue(":type", $data->type);
        $stmt->bindValue(":attribute", $data->attribute);
        $stmt->bindValue(":sku", $data->sku);

        return $stmt->execute();
    }

    public function deleteProduts($ids) {
        $data = implode("','", $ids->id);
        $sql = "DELETE FROM $this->table WHERE id IN ('".$data."')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>
