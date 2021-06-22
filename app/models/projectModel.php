<?php

class projectModel extends database{
    public function __construct($f3, $name){
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
    $this->id = $query[0]['id'];
    $this->title = $query[0]['title'];
    $this->description = $query[0]['description'];
    $this->timetocomplete = $query[0]['timetocomplete'];
    $this->user_id = $query[0]['user_id'];
    $this->created_at = $query[0]['created_at'];
    $this->updated_at = $query[0]['updated_at'];
  }

 

  public function getProjects(){
    $this->setDatabase();
    $db = $this->getDatabase();
    $query = $db->exec('SELECT * FROM projects');
    return $query;
  }

  public function addProject($data){

    if($this->f3->get("SESSION.user") === null){
      $this->f3->reroute("/login");
    }

    $data[] = $this->getCurrentUserId();
    $data[] = $this->getCurrentdate();
		$data[] = $this->getCurrentdate();

    $values = "";

   for($i = 0; $i < count($data); $i++){
     $values.= "'$data[$i]'".(($i === (count($data)-1)) ? "" : ", ");
   }

    $this->setDatabase();
    try{
      $query = $this->getDatabase()->exec("INSERT INTO 
        projects (`title`, `description`, `client`, `timetocomplete`, `user_id`, `created_at`, `updated_at`)
        VALUES($values)");
    }
    catch (\Exception $e){
      return false;
    }
    return true;
  }

  public function editProject($id){
    
  }

  public function removeProject($id){
    
  }
}