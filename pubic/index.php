<?php
  require_once '../app/kernel.php';

  $kernel = new Kernel();

  $kernel->formatResponseHeaders();
  $kernel->routes();

?>
