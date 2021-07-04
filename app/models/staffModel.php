<?php

class staffModel extends database{
  public function __construct($f3){
    parent::__construct($f3);
  }

  public function getStaffById($id){
    $this->setDatabase();
    $query = $this->getDatabase()->exec('SELECT * FROM users WHERE id = :id', [':id' => $id]);
    return $query[0];
  }

  public function getStaff(){
    $this->setDatabase();
    $db = $this->getDatabase();
    $query = $db->exec('SELECT * FROM users');
    foreach($query as $key => $value){
      $query[$key]['hid'] = $this->crypteri->encrypt($value['id']);
    }
    return $query;
  }

  public function addStaff(){
    
  }

  public function updateStaff($id){
    
  }

  public function deleteStaff($id){
    
  }
}