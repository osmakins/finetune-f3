<?php

class dashboardController extends dashboardModel{
  
  use pagesTrait;

  public function dashboard(){
    $this->f3->set('content', 'pages/dashboard.htm');
  }
}