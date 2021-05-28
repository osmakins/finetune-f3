<?php

class dashboardController{
  public $f3;

  public function __construct($f3){
    $this->f3 = $f3;
    if($f3->get('SESSION.user') === NULL){
      $f3->reroute('/login');
    }
  }

  public function dashboard(){
    $this->f3->set('content', 'dashboard/dashboard.htm');
        echo \Template::instance()->render('layout.htm');
  }
  
  public function staff(){
    $this->f3->set('content', 'dashboard/staff.htm');
        echo \Template::instance()->render('layout.htm');
  }

  public function projects(){
    $this->f3->set('content', 'dashboard/projects.htm');
        echo \Template::instance()->render('layout.htm');
  }

  public function tasks(){
    $this->f3->set('content', 'dashboard/tasks.htm');
        echo \Template::instance()->render('layout.htm');
  }

  public function analytics(){
    $this->f3->set('content', 'dashboard/analytics.htm');
        echo \Template::instance()->render('layout.htm');
  }
}