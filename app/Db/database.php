<?php
class Database {
  /**
   *Mysql connection;
    *@var string
    */
  private $dsn = 'mysql:host=localhost;dbname=products;charset=utf8';
  /**
   *Usename;
    *@var string
    */
  private $usuario = 'pvgusmao';
  /**
   *User password;
    *@var string
    */
  private $senha = 'Paulo2010.Paulo2010.';
  /**
   *@var string
    */
  private $pdo = null;
  
  public function __construct() {
    try {
      $this->pdo = new PDO($this->dsn, $this->usuario, $this->senha);
    } catch (PDOException $e) {
      die($e->getMessage());
    }
  }
  
  public function __destruct() {
    $this->pdo = null;
  }
  
  public function getPdo() {
    return $this->pdo;  
  }
}
?>
