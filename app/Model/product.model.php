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
    protected $tabela;
    /**
     * Columns from my table;;
     * @var array;
     */
    protected $colunas = [];
    
    public function __construct() {
        $database = new Database();
        $this->pdo = $database->getPdo();
        $this->tabela = 'product';
    }
    
    public function getAllProducts() {
        $sql = "SELECT * FROM $this->tabela";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function createProduct($data) {
        $sql = "INSERT INTO $this->tabela (name, price, type, attribute, sku) VALUES (:name, :price, :type, :attribute, :sku)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":name", $data->name);
        $stmt->bindValue(":price", $data->price);
        $stmt->bindValue(":type", $data->type);
        $stmt->bindValue(":attribute", $data->attribute);
        $stmt->bindValue(":sku", $data->sku);
        
        return $stmt->execute();
    }
    
    public function deleteProduts($id) {
        $sql = "DELETE FROM $this->tabela WHERE id = (:id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id->id);
        return $stmt->execute();
    }
}
?>
