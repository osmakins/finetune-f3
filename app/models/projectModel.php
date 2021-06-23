<?php

class projectModel extends database{
    public function __construct($f3){
    parent::__construct($f3);
  }

  protected $fields_data = array(
    "title",
    "description",
    "client",
    "timetocomplete"
  );

  private function sanitize_input(array $data, array $fieldnames){
    return array_intersect_key($data, array_flip($fieldnames));
  }

  private function getCurrentUserId(){
    $this->setDatabase();
    $query = $this->getDatabase()->exec('SELECT id FROM users WHERE username = :username LIMIT 1', [':username' => $this->f3->get("SESSION.user")]);
    return $query[0]['id'];
  }

  public function getProject($id){
    $this->setDatabase();
    $query = $this->getDatabase()->exec('SELECT * FROM projects WHERE id = :id', [':id' => $id]);
    return $query[0];
    // $this->id = $query[0]['id'];
    // $this->title = $query[0]['title'];
    // $this->description = $query[0]['description'];
    // $this->timetocomplete = $query[0]['timetocomplete'];
    // $this->user_id = $query[0]['user_id'];
    // $this->created_at = $query[0]['created_at'];
    // $this->updated_at = $query[0]['updated_at'];
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
    $count = $this->getDatabase()->exec('INSERT INTO projects (title, description, client, timetocomplete, user_id, created_at) VALUES (:title, :description, :client, :timetocomplete, :user_id, :created_at)', $dataPack);
    return ($count ? true: false);


  }

  public function editProject($id){
    
  }

  public function removeProject($id){
    
  }
}