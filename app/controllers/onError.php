<?php

class onError{

  public $f3;

  public function __construct($f3){
    $this->f3 = $f3;
  }

  public function error(){
    $this->f3->set('content', 'pages/error.htm');
    echo \Template::instance()->render('layout.htm');
  }
}