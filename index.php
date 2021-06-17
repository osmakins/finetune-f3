<?php
  require_once('vendor/autoload.php');

  $f3 = \Base::instance();
  
  $f3->LANGUAGE = $f3->get('sitelang');

  $f3->config('config/config.ini');
  $f3->config('config/routes.ini');

  $f3->logger = new Log('logs/'.date("Ymd").'.log');
  $f3->clear('CACHE');
  $f3->run();
?>