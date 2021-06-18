<?php

class staffController extends staffModel{
  public $f3;

  public function __construct($f3){
    $this->f3 = $f3;
    if($f3->get('SESSION.user') === NULL){
      $f3->reroute('/login');
    }
  }

  function afterroute() {
		echo \Template::instance()->render('layout.htm');
	}
  
  public function staff(){
    $this->f3->set('content', 'pages/staff.htm');
  }
}