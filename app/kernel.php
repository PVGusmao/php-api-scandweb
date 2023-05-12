<?php
require_once '../app/Controller/product.controller.php';

class Kernel {
  /**
   * Http-status-code;
   * @var number;
   */
  protected $status_code;

  /**
   * Base url;
   * @var string;
   */
  protected $base_url;

  /**
   * base method;
   * @var string;
   */
  protected $base_method;

  protected $data;
  public function __construct() {
    $this->data = file_get_contents('php://input');
    $this->data = json_decode($this->data);
    
    $this->base_method = $_SERVER['REQUEST_METHOD'];
    $this->base_url = $_SERVER['REQUEST_URI'];
  }

  public function formatResponseHeaders() {
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
  }

  public function throwError($message, $status_code = 500) {
    $object = new stdClass();
    
    http_response_code($status_code);

    $object->success = false;
    $object->message = $message;

    echo (json_encode($object));
  }

  public function routes() {
    $routes = [
      ['/', 'notFound', 'GET'],
      ['/addproduct', 'createProduct', 'POST'],
      ['/listall', 'getAllProducts', 'GET'],
      ['/removeproducts', 'deleteProduct', 'DELETE'],
    ];
    foreach ($routes as $index => $route) {
      $exists = $route[0] == $this->base_url;
      
      if (!$exists) {
        continue;
      }
      
      $correctMethod = $route[2] == $this->base_method;
      
      if (!$correctMethod) {
        continue;
      }

      $variable = new ProductController();
      $method = $route[1];
      
      if (!method_exists($variable, $method)) {
        $this->throwError("This route doesn't exist");
      }

      $response = $variable->$method($this->data);

      echo (json_encode($response));
      die();
    }
    
    $this->throwError('Not Found', 404);
  }

}
?>
