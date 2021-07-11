<?php

class dashboardModel extends database{

  public function __construct($f3){
    parent::__construct($f3);
  }

  public function countStaff(){
    $this->setDatabase();
    $db = $this->getDatabase();
    $query = $db->exec('SELECT * FROM users');
      return (count($query));
  }

  public function countProjects(){
    $this->setDatabase();
    $db = $this->getDatabase();
    $query = $db->exec('SELECT * FROM projects');
      return (count($query));
  }
  public function countTasks(){
    $this->setDatabase();
    $db = $this->getDatabase();
    $query = $db->exec('SELECT * FROM tasks');
      return (count($query));
  }
}