<?php

class projectController extends projectModel{
  
  use pagesTrait;

  public function projects(){
    $this->f3->set('content', 'pages/projects.htm');
  }
}