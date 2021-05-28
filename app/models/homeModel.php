<?php

class homeModel extends database{
  
  public function __construct($f3){
    parent::__construct($f3);
  }

  public function getPosts(){
    $this->setDatabase();
    $db = $this->getDatabase();
    $query = $db->exec('SELECT * FROM tasks');
    return $query;
  }
}