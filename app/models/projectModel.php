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
    
  }

  public function addProject($data){

    //$data[] = $this->sanitize_input($unsanitizeddata, $this->fields_data);

    $data[] = $this->getCurrentUserId();
    // $data[] = $this->getCurrentdate();
		// $data[] = $this->getCurrentdate();

   // $values = implode(', ', $data);

   $values = "";

   foreach($data as $d){
     $values.= (end($data) === $d)?"'$d'" : "'$d', ";
   }
  
  // var_dump($values);

  // echo "<pre>".print_r($data, true);


    $this->setDatabase();
    try{
      $query = $this->getDatabase()->exec("INSERT INTO projects (`title`, `description`, `client`, `timetocomplete`, `user_id`)
      VALUES($values)");
    }
    catch (\Exception $e){
      return false;
    }
    return true;
  }

  public function updateProject($id){
    
  }

  public function deleteProject($id){
    
  }
}