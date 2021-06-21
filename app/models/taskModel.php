<?php

class taskModel extends database{

  public function getTask($id){
    
  }

  public function getTasks(){
    $this->setDatabase();
    $db = $this->getDatabase();
    $query = $db->exec('SELECT * FROM tasks');
    return $query;
  }

  public function addTask(){
    
  }

  public function updateTask($id){
    
  }

  public function deleteTask($id){
    
  }
}