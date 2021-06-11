<?php
  require_once('vendor/autoload.php');

  $f3 = \Base::instance();
  
  $f3->config('config.ini');
  $f3->config('routes.ini');

  $logger = new Log('logs/'.date("Ymd").'.log');
  $f3->logger = $logger;
  $f3->clear('CACHE');
  $f3->run();
?>