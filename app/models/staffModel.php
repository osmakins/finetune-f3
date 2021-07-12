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
      if(isset($value['id'])){
        $query[$key]['hid'] = $this->crypteri->encrypt($value['id']);
      }
    }
    return $query;
  }

  public function addStaff($dataPack){
    // var_dump($dataPack); die;
    $this->setDatabase();
    $count = $this->getDatabase()->exec(
      'INSERT INTO 
        users (firstname, lastname, username, password, email, phone, position, created_at) 
      VALUES (:firstname, :lastname, :username, :password, :email, :phone, :position, :created_at)', $dataPack);
  }

  public function editStaff($dataSet){
    //var_dump($dataSet); die;
    $this->setDatabase();
    $query = $this->getDatabase()->exec('UPDATE users 
    SET firstname = :firstname, lastname = :lastname, email = :email, phone = :phone, position = :position, updated_at = :updated_at 
    WHERE id = :id ', $dataSet);
  }

  public function deleteStaff($id){
    
  }
}