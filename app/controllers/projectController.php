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

  public function showModal($content){
    $modal = $this->f3->get('POST.modal');
    $hid = $this->f3->get('POST.id');
    if(isset($modal)){
      if(isset($hid)){
        $id = $this->crypteri->decrypt($hid);
        //var_dump($this->getMilestone($id));die;
        $projectArray = $this->getProjectById($id);
        $projectArray["hid"] = $hid;
        $projectArray["milestone"] = $this->getMilestone($id);
        $this->f3->mset($projectArray);
        echo \Template::instance()->render($content);
        exit;
      }
      echo \Template::instance()->render($content);
      exit;
    }
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
      $this->f3->reroute('/error');
    }
    $this->f3->reroute('/projects');
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
    $this->f3->reroute('/projects');
  }

  public function removeProject(){
    $this->showModal('pages/projects/project_delete.htm');
    
    $hid = $this->f3->get('POST.hid');
    $id = $this->crypteri->decrypt($hid);
    
    $this->deleteProject($id);
    $this->f3->reroute('/projects');
  }

  public function projects(){

    $method = $this->f3->get('SERVER.REQUEST_METHOD');

    if($method === 'GET'){
      
      $page = $this->f3->get('GET.page');
      $page = isset($page)? $page : 1;

      $record_per_page = 5;

      $start_from = ($page - 1) * $record_per_page;
      
      $data = $this->getProjects($start_from, $record_per_page);
      
      $total_records = $data['count'];

      $total_pages = ceil($total_records/$record_per_page);

      $pages = [];
      for($i=1; $i <= $total_pages; $i++){
        $pages[] = $i;
      }

      $this->f3->set('previous', $page-1);
      $this->f3->set('next', $page+1);
      $this->f3->set('totalpages', $total_pages);

      //var_dump($this->getProjects($start_from, $record_per_page));die;

      //var_dump($record_per_page, $start_from, $page);die;

      $this->f3->set('page', $page);
      $this->f3->set('pages', $pages);
		  $this->f3->set('projects', $data['query'] );
      $this->f3->set('content', 'pages/projects/projects.htm');
      //echo \Template::instance()->extend('pagebrowser', '\Pagination::renderTag');
      echo \Template::instance()->render('layout.htm');
      exit;
    }
    
    $submit = $this->f3->get('POST.submit');
    $crud_isset = ($method === 'POST' && $submit !== NULL) ? $submit : FALSE;

    switch($crud_isset){
      case 'detail':
        $this->showModal('pages/projects/project_detail.htm');
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