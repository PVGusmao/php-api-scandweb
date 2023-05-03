<?php

require_once '../app/Model/product.model.php';

class ProductController {
  public function getAllProducts() {
    $model = new ProductModel();
    $allProducts = $model->getAllProducts();

    return $allProducts;
  }

  public function createProduct($data) {
    $model = new ProductModel();

    try {
      return $model->createProduct($data);
    } catch (PDOException $e) {
      var_export($e->getMessage());
    }
  }

  public function deleteProduct() {
    
  }
}

?>