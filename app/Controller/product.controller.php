<?php

require_once '../app/Model/product.model.php';

class ProductController {
  public function getAllProducts() {
    $model = new ProductModel();
    $allProducts = $model->getAllProducts();

    return $allProducts;
  }

  public function getByParam($value) {
    $model = new ProductModel();
    $existingValue = $model->getByParam($value);
    
    return $existingValue;
  }

  public function createProduct($data) {
    $existingValue = $this->getByParam($data->sku);

    var_export($existingValue);
    die();

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