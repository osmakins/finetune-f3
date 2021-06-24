<?php

class authModel extends database
{
  public function __construct($db) 
  {
      parent::__construct($db);
  }
  
  public function getCurrentUser($name){
    $this->setDatabase();
    $db = $this->getDatabase();
    $query = $db->exec('SELECT username FROM users WHERE username = :name', [':name' => $name]);
    return (count($query) ? TRUE : FALSE);
  }
}