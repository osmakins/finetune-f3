<?php

class projectController extends projectModel{

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

    if($method === 'POST'){
      $submit = $this->f3->get('POST.submit');
      if(isset($submit)){
        switch($submit){
          case 'detail':
            $this->detailProject();
            break;
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
            $this->showModal('pages/error.htm');
            $this->f3->reroute('/error');
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

  public function detailProject(){
    $this->showModal('pages/projects/project_detail.htm');
  }

  public function createProject() {
    $this->showModal('pages/projects/project_create.htm');

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
    $this->showModal('pages/projects/project_update.htm');

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
    $this->showModal('pages/projects/project_delete.htm');
    
    $hid = $this->f3->get('POST.hid');
    $id = $this->crypteri->decrypt($hid);
    
    $this->deleteProject($id);
    $this->f3->reroute('/project');
  }
}