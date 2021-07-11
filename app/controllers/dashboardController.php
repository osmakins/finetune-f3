<?php

class dashboardController extends dashboardModel{
  
  // use pagesTrait;

  public $f3;

  public function __construct($f3){
    $this->f3 = $f3;
    if($f3->get('SESSION.user') === NULL){
      $f3->reroute('/login');
    } 
  }


  public function dashboard(){

    $method = $this->f3->get('SERVER.REQUEST_METHOD');

    if($method === 'GET'){
    $this->f3->set('countstaff', $this->countStaff());
    $this->f3->set('countprojects', $this->countProjects());
    $this->f3->set('counttasks', $this->countTasks());

    //var_dump($this->f3->get('countstaff'), $this->f3->get('countprojects'), $this->f3->get('counttasks')); die;
    $this->f3->set('content', 'pages/dashboard.htm');
    echo \Template::instance()->render('layout.htm');
    exit;
    }
  }
}