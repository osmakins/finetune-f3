<?php

class projectController extends projectModel{
  
  // use pagesTrait;

  public $f3;

  public function __construct($f3){
    $this->f3 = $f3;
    if($f3->get('SESSION.user') === NULL){
      $f3->reroute('/login');
    }
    parent::__construct($f3);
  }

  public function projects(){
    $this->f3->set('content', 'pages/projects/project.htm');
    echo \Template::instance()->render('layout.htm');
  }

  public function createProject() {
    echo \Template::instance()->render('pages/projects/project_add.htm');
    $dataPack = [  
      ':title' => $this->f3->get('POST.title'),
      ':description' => $this->f3->get('POST.description'),
      ':client' => $this->f3->get('POST.client'),
      ':timetocomplete' => $this->f3->get('POST.timetocomplete'),
      ':user_id' => $this->f3->get('SESSION.user_id'),
      ':created_at' => $this->getCurrentdate()
    ];
    $status = TRUE;
    foreach($dataPack as $k=>$v){
      if(!strlen($v)){
        $this->f3->set('ERROR.'.substr($k, 1), $k);
        $status = FALSE;
      }
    }
    if($status){
      $this->addProject($dataPack);
    }else{
      print_r('<pre>');
      print_r($this->f3->get('ERROR'));
      print_r('</pre>');
    }
    $this->f3->reroute('/projects');
  }

  public function readProjects(){
    $projects = $this->getProjects();
		$this->f3->set('projects', $projects);
    $this->f3->set('content', 'pages/projects/project.htm');
    echo \Template::instance()->render('layout.htm');
  }

  
  public function SelectProjectId(){
    $hid = $this->f3->get('POST.id');
    $id = $this->crypteri->decrypt($hid);
    $projectArray = $this->getProjectById($id);
    $this->f3->mset($projectArray);
    echo \Template::instance()->render('pages/projects/project_edit.htm');
  }

  public function updateProject(){
    $dataSet = [
      ':id' => $id,
      ':title' => $this->f3->get('POST.title'),
      ':description' => $this->f3->get('POST.description'),
      ':client' => $this->f3->get('POST.client'),
      ':timetocomplete' => $this->f3->get('POST.timetocomplete'),
      ':updated_at' => $this->getCurrentdate()
    ];
    $this->editProject($dataSet);
    $this->f3->reroute('/projects');
  }

  public function deleteProject(){

  }

  public function readProjectById(){
    $hid = $this->f3->get('POST.id');
    $id = $this->crypteri->decrypt($hid);
    $projectArray = $this->getProjectById($id);
    $this->f3->mset($projectArray);
    echo \Template::instance()->render('pages/projects/project_details.htm');
  }
}