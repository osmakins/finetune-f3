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

    if($this->f3->get("SESSION.user") === null){
      $this->f3->reroute("/login");
    }

    $this->setDatabase();
    $count = $this->getDatabase()->exec(
      'INSERT INTO 
        projects (title, description, client, timetocomplete, user_id, created_at) 
      VALUES (:title, :description, :client, :timetocomplete, :user_id, :created_at)', $dataPack);

    return ($count ? true: false);
  }

  public function editProject($dataSet){
    if($this->f3->get("SESSION.user") === null){
      $this->f3->reroute("/login");
    }

    $this->setDatabase();
    $query = $this->getDatabase()->exec('UPDATE projects 
    SET title = :title, description = :description, client = :client, timetocomplete = :timetocomplete, updated_at = :updated_at 
    WHERE id = :id ', $dataSet);
  }

  public function removeProject($id){
    
  }
}