<?php

class database{
  public $f3;
  private $db;

  public function __construct($f3){
    $this->f3 = $f3;
  }

  public function getDatabase(){
    return $this->db;
  }

  public function setDatabase(){
    $this->db = new \DB\SQL(
      'mysql:host=' . $this->f3->DATABASE_ADDRESS 
    . ';port=' . $this->f3->DATABASE_PORT 
    . ';dbname=' . $this->f3->DATABASE_NAME, 
    $this->f3->DATABASE_USER, 
    $this->f3->DATABASE_PWD, 
    array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES LATIN1;'));
  }
}