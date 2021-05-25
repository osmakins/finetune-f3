<?php

class homeModel extends database{
  
  public function __construct($f3){
    parent::__construct($f3);
  }

  public function getUsers(){
    $this->setDatabase();
    $db = $this->getDatabase();
    $query = $db->exec('SELECT username, email FROM users');
    return $query;
  }
}