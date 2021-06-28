<?php

class staffController extends staffModel{

  use pagesTrait;

  public function staff(){
    $this->f3->set('content', 'pages/staff/staff.htm');
  }
}