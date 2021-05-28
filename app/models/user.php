<?php

class user extends database {
  public $id;
  public $email;
  public $password;
  public $username;
  
  public function __construct($f3, $name){
    parent::__construct($f3);
    $this->setUser($name);
  }


  private function setUser($name){
    $this->setDatabase();
    $query = $this->getDatabase()->exec('SELECT * FROM users WHERE username = :name', [':name' => $name]);
    $this->id = $query[0]['id'];
    $this->email = $query[0]['email'];
    $this->password = $query[0]['password'];
    $this->username = $query[0]['username'];
  }
}