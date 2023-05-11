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
    $params = [];

    foreach ($data as $key => $value) {
      if (empty($value)) {
        return "All fields are mandatory, please submit required data.";
      }

      $params[] = $key;
    }

    if (!empty(array_diff(["sku", "name", "price", "type", "attribute"], $params))) {
      return ("Field doesn't exists on database.");
    }

    $existingValue = $this->getByParam($data->sku);

    if (!empty($existingValue)) {
      $json = new stdClass();
      $json->message = 'This object already exists.';

      http_response_code(409);

      return $json;
    }

    $model = new ProductModel();

    $json = new stdClass();

    try {
      $json->response = $model->createProduct($data);
      $json->message = 'Object created successfully';
      return $json;
    } catch (PDOException $e) {
      var_export($e->getMessage());
    }
  }

  public function deleteProduct($ids) {
    $model = new ProductModel();

    $json = new stdClass();

    try {
      $json->response = $model->deleteProduts($ids);

      if ($json->response >= 1) {
        $json->message = 'Items removed with success.';
      } else {
        $json->message = 'This id does not exist.';
      }
      
      return $json;
    } catch (PDOException $e) {
      var_export($e->getMessage());
    }
  }
}

?>