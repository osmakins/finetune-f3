<?php

class projectModel extends database{
    public function __construct($f3){
    parent::__construct($f3);
  }

  public function getProjectById($id){
    $this->setDatabase();
    $query = $this->getDatabase()->exec('SELECT * FROM projects WHERE id = :id', [':id' => $id]);
    return $query[0];
  }

  public function getProjects(){
    $this->setDatabase();
    $db = $this->getDatabase();
    $query = $db->exec('SELECT * FROM projects');
    foreach($query as $key => $value){
      $query[$key]['hid'] = $this->crypteri->encrypt($value['id']);
    }
    return $query;
  }

  public function addProject($dataPack){
    $this->setDatabase();
    $count = $this->getDatabase()->exec(
      'INSERT INTO 
        projects (title, description, client, timetocomplete, user_id, created_at) 
      VALUES (:title, :description, :client, :timetocomplete, :user_id, :created_at)', $dataPack);
  }

  public function editProject($dataSet){
    $this->setDatabase();
    $query = $this->getDatabase()->exec('UPDATE projects 
    SET title = :title, description = :description, client = :client, timetocomplete = :timetocomplete, updated_at = :updated_at 
    WHERE id = :id ', $dataSet);
  }

  public function deleteProject($id){
    $this->setDatabase();
    $query = $this->getDatabase()->exec('DELETE FROM projects WHERE id = :id', [':id' => $id]);
  }

  public function getMilestone($id){
    $this->setDatabase();
    $query = $this->getDatabase()->exec('SELECT tasks.timeassigned, projects.timetocomplete FROM projects 
    INNER JOIN tasks ON projects.id = tasks.project_id WHERE projects.id = :id ', [':id' => $id]);

    $totaltimeassigned = 0;
    $totaltimetocomplete = 0;
    foreach($query as $key => $value){
      $totaltimeassigned += $query[$key]['timeassigned'];
      $totaltimetocomplete = $query[$key]['timetocomplete'];
    }

    $milestone = round(abs((($totaltimeassigned/$totaltimetocomplete) * 100) - 100));

    return $milestone;
  }
}