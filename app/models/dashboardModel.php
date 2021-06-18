<?php

class dashboardModel extends database{

  public function __construct($f3){
    parent::__construct($f3);
  }

  public function countStaff(){
    $this->setDatabase();
    $db = $this->getDatabase();
    $query = $db->exec('SELECT username FROM users WHERE username = :name', [':name' => $name]);
      return (count($query));
  }
}