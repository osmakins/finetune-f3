<?php

class taskModel extends database{

  public function __construct($f3){
    parent::__construct($f3);
  }

  public function getTaskById($id){
    $this->setDatabase();
    $query = $this->getDatabase()->exec('SELECT tasks.*, pro.title AS p_title FROM tasks 
    LEFT JOIN projects AS pro ON tasks.project_id = pro.id WHERE tasks.id = :id', [':id' => $id]);
   
    return $query[0];
  }

  public function getTasks($starting, $offset, $item){

    $this->setDatabase();
    $db = $this->getDatabase();

    if(isset($item)){
      $query = $db->exec('SELECT tasks.*, projects.title AS p_title FROM tasks 
      INNER JOIN projects ON tasks.project_id = projects.id WHERE projects.title LIKE :item
      LIMIT :starting, :offset', [':item' => "%$item%", 'starting' => $starting, ':offset' => $offset]);

      $count = $db->exec('SELECT COUNT(tasks.id) AS count, tasks.*, projects.title AS p_title FROM tasks 
      INNER JOIN projects ON tasks.project_id = projects.id WHERE projects.title LIKE :item', [':item' => "%$item%"]);
    }
    else{
      $query = $db->exec("SELECT tasks.*, projects.title AS p_title FROM tasks 
      INNER JOIN projects ON tasks.project_id = projects.id 
      LIMIT :starting, :offset", [':starting' => $starting, ':offset' => $offset]);
    
      $count = $db->exec('SELECT COUNT(id) AS count FROM tasks');
    }

    foreach($query as $key => $value){
      $query[$key]['hid'] = $this->crypteri->encrypt($value['id']);
    }
    

    return ['count' => $count[0]['count'], 'query' => $query];
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