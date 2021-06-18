<?php

class projectController extends projectModel{
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

  public function projects(){
    $this->f3->set('content', 'pages/projects.htm');
  }
}