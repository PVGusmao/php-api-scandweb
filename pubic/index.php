<?php
  require_once '../app/Controller/product.controller.php';
  
  $status_code = 200;

  formatResponseHeaders();

  $base_URL = $_SERVER['REQUEST_URI'];
  $base_Method = $_SERVER['REQUEST_METHOD'];

  $data = file_get_contents('php://input');
  $data = json_decode($data);

  route($base_Method, $base_URL, $data);

  function route($base_Method, $base_URL, $data = '') {
    $routes = [
      ['/addproduct', 'createProduct', 'POST'],
      ['/listall', 'getAllProducts', 'GET'],
      ['/removeproducts', 'deleteProduct', 'DELETE'],
    ];
  
    foreach ($routes as $index => $route) {
      $exists = $route[0] == $base_URL;
      
      if (!$exists) {
        continue;
      }
      
      $correctMethod = $route[2] == $base_Method;
      
      if (!$correctMethod) {
        continue;
      }

      $variable = new ProductController();
      $method = $route[1];
      
      if (!method_exists($variable, $method)) {
        throwError("This route doesn't exist");
      }

      $response = $variable->$method($data);

      echo (json_encode($response));
      die();
    }

    throwError('Not Found', 404);
  }

  function throwError($message, $status_code = 500) {
    $object = new stdClass();
    
    http_response_code($status_code);

    $object->success = false;
    $object->message = $message;

    echo (json_encode($object));
  }

  function formatResponseHeaders() {
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
    header("Access-Control-Allow-Headers: Content-Type");

    if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
      header("HTTP/1.1 200 OK");
      die();
    }
    // header("HTTP/1.1 200 OK");
  }
?>
