<?php

class taskModel extends database{

  public function __construct($f3){
    parent::__construct($f3);
  }

  public function getTaskById($id){
    $this->setDatabase();
    $query = $this->getDatabase()->exec('SELECT * FROM tasks WHERE id = :id', [':id' => $id]);
    return $query[0];
  }

  public function getTasks(){
    $this->setDatabase();
    $db = $this->getDatabase();
    $query = $db->exec('SELECT * FROM tasks');
    return $query;
  }

  public function addTask($dataPack){
    $this->setDatabase();
    $count = $this->getDatabase()->exec(
      'INSERT INTO 
        tasks (title, description, project_id, timeassigned, created_at) 
      VALUES (:title, :description, :project_id, :timeassigned, :created_at)', $dataPack);

    return ($count ? true: false);
  }

  public function updateTask($dataSet){
    $this->setDatabase();
    $query = $this->getDatabase()->exec('UPDATE tasks
    SET title = :title, description = :description, project_id = :project_id, timeassigned = :timeassigned, updated_at = :updated_at 
    WHERE id = :id ', $dataSet);
  }

  public function deleteTask($id){
    $this->setDatabase();
    $query = $this->getDatabase()->exec('DELETE FROM tasks WHERE id = :id', [':id' => $id]);
  }
}