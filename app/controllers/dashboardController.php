<?php

class dashboardController{
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

  public function dashboard(){
    $this->f3->set('content', 'pages/dashboard.htm');
  }
  
  public function staff(){
    $this->f3->set('content', 'pages/staff.htm');
  }

  public function projects(){
    $this->f3->set('content', 'pages/projects.htm');
  }

  public function tasks(){
    $this->f3->set('content', 'pages/tasks.htm');
  }

  public function analytics(){
    $this->f3->set('content', 'pages/analytics.htm');
  }
}