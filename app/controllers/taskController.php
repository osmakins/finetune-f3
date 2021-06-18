<?php

class taskController extends taskModel{

  use pagesTrait;

  public function tasks(){
    $this->f3->set('content', 'pages/tasks.htm');
  }
}