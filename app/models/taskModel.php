<?php

class taskModel extends database{

  public function __construct($f3){
    parent::__construct($f3);
  }

  public function getTaskById($id){
    $this->setDatabase();
    $query = $this->getDatabase()->exec('SELECT tasks.*, pro.title as p_title FROM tasks 
    LEFT JOIN projects as pro ON tasks.project_id = pro.id WHERE tasks.id = :id', [':id' => $id]);
    //var_dump($query[0]);die;
    return $query[0];
  }

  public function getTasks(){
    $this->setDatabase();
    $db = $this->getDatabase();
    $query = $db->exec('SELECT * FROM tasks');
    foreach($query as $key => $value){
      if(isset($value['id'])){
        $query[$key]['hid'] = $this->crypteri->encrypt($value['id']);
      }
    }
    return $query;
  }

  public function getProjectData(){
    $this->setDatabase();
    $query = $this->getDatabase()->exec(
      'SELECT id, title FROM projects'
    );
    return $query;
  }

  public function addTask($dataPack){
    $this->setDatabase();
    $count = $this->getDatabase()->exec(
      'INSERT INTO 
        tasks (title, description, project_id, timeassigned, created_at) 
      VALUES (:title, :description, :project_id, :timeassigned, :created_at)', $dataPack);
  }

  public function editTask($dataSet){
    $this->setDatabase();
    $query = $this->getDatabase()->exec('UPDATE tasks
    SET title = :title, description = :description, timeassigned = :timeassigned, updated_at = :updated_at 
    WHERE id = :id', $dataSet);
  }

  public function deleteTask($id){
    $this->setDatabase();
    $query = $this->getDatabase()->exec('DELETE FROM tasks WHERE id = :id', [':id' => $id]);
  }
}