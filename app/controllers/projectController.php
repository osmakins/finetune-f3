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

  public function project(){
    $method = $this->f3->get('SERVER.REQUEST_METHOD');

    if($method === 'GET'){
      $projects = $this->getProjects();
		  $this->f3->set('projects', $projects);
      $this->f3->set('content', 'pages/projects/project.htm');
      echo \Template::instance()->render('layout.htm');
      exit;
    }

    else if($method === 'POST'){
      $modal_display = $this->f3->get('POST.display');
      $submit = $this->f3->get('POST.submit');

      if(isset($modal_display)){
        switch($modal_display){
          case 'detail':
            $this->showModal('pages/projects/project_detail.htm');
            break;
          case 'create':
            $this->showModal('pages/projects/project_create.htm');
            break;
          case 'update':
            $this->showModal('pages/projects/project_update.htm');
            break;
          case 'delete':
            $this->showModal('pages/projects/project_delete.htm');
            break;
          default:
            $this->showModal('pages/error.htm');
            break;
        }
      }

    if(isset($submit)){
        switch($submit){
          case 'create':
            $this->createProject();
            break;
          case 'update':
            $this->updateProject();
            break;
          case 'delete':
            $this->removeProject();
            break;
          default:
            $this->f3->set('content', 'pages/error.htm');
            echo \Template::instance()->render('layout.htm');
            break;
        }
      }
    } 
  }

  public function showModal($content){
    $modal = $this->f3->get('POST.modal');
    $hid = $this->f3->get('POST.id');
    if(isset($modal)){
      if(isset($hid)){
        $id = $this->crypteri->decrypt($hid);
        $projectArray = $this->getProjectById($id);
        $projectArray["hid"] = $hid;
        $this->f3->mset($projectArray);
        echo \Template::instance()->render($content);
        exit;
      }
      echo \Template::instance()->render($content);
      exit;
    }
  }

  public function createProject() {

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
    $this->f3->reroute('/project');
  }

  public function updateProject(){

    $hid = $this->f3->get('POST.hid');
    $id = $this->crypteri->decrypt($hid);
    $dataSet = [
      ':id' => $id,
      ':title' => $this->f3->get('POST.title'),
      ':description' => $this->f3->get('POST.description'),
      ':client' => $this->f3->get('POST.client'),
      ':timetocomplete' => $this->f3->get('POST.timetocomplete'),
      ':updated_at' => $this->getCurrentdate()
    ];

    $this->editProject($dataSet);
    $this->f3->reroute('/project');
  }

  public function removeProject(){
    
    $hid = $this->f3->get('POST.hid');
    $id = $this->crypteri->decrypt($hid);
    
    $this->deleteProject($id);
    $this->f3->reroute('/project');
  }
}