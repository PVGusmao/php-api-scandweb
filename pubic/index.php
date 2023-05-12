<?php
  require_once '../app/kernel.php';

  // $data = file_get_contents('php://input');
  // $data = json_decode($data);

  $kernel = new Kernel();

  $kernel->formatResponseHeaders();
  $kernel->routes();

?>
