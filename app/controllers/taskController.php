<?php

class taskController extends taskModel{

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
        $taskArray = $this->getTaskById($id);
        $taskArray["hid"] = $hid;
        $this->f3->mset($taskArray);
        echo \Template::instance()->render($content);
        exit;
      }
      echo \Template::instance()->render($content);
      exit;
    }
  }

  public function createTask(){
    $this->f3->set('project_data', $this->getProjectData());
    $this->showModal('pages/tasks/task_create.htm');

    $dataPack = [  
      ':title' => $this->f3->get('POST.title'),
      ':description' => $this->f3->get('POST.description'),
      ':timeassigned' => $this->f3->get('POST.timeassigned'),
      ':project_id' => $this->f3->get('POST.project_id'),
      ':created_at' => $this->getCurrentdate()
    ];

    $this->addTask($dataPack);
    $this->f3->reroute('/tasks');
  }

  public function updateTask(){
    $this->showModal('pages/tasks/task_update.htm');

    $hid = $this->f3->get('POST.hid');
    $id = $this->crypteri->decrypt($hid);

    $dataSet = [
      ':id' => $id,
      ':title' => $this->f3->get('POST.title'),
      ':description' => $this->f3->get('POST.description'),
      ':timeassigned' => $this->f3->get('POST.timeassigned'),
      ':updated_at' => $this->getCurrentdate()
    ];

    $this->editTask($dataSet);
    $this->f3->reroute('/tasks');
  }

  public function removeTask(){
    $this->showModal('pages/tasks/task_delete.htm');
    
    $hid = $this->f3->get('POST.hid');
    $id = $this->crypteri->decrypt($hid);
    
    $this->deleteTask($id);
    $this->f3->reroute('/tasks');
  }

  public function tasks(){

  $method = $this->f3->get('SERVER.REQUEST_METHOD');

    if($method === 'GET'){
      $page = $this->f3->get('GET.page');
      $search_item = $this->f3->get('GET.search-item');

      $page = isset($page)? $page : 1;

      $record_per_page = 5;
      $start_from = ($page - 1) * $record_per_page;
      $data = $this->getTasks($start_from, $record_per_page, $search_item);
      $total_records = $data['count'];

      $total_pages = ceil($total_records/$record_per_page);

      $pages = [];
      for($i=1; $i <= $total_pages; $i++){
        $pages[] = $i;
      }

      $this->f3->set('previous', $page-1);
      $this->f3->set('next', $page+1);
      $this->f3->set('totalpages', $total_pages);
      $this->f3->set('page', $page);
      $this->f3->set('pages', $pages);
      $this->f3->set('tasks', $data['query']);
      $this->f3->set('content', 'pages/tasks/tasks.htm');
      echo \Template::instance()->render('layout.htm');
      exit;
    }
    
    $submit = $this->f3->get('POST.submit');
    $crud_isset = ($method === 'POST' && $submit !== NULL) ? $submit : FALSE;

    switch($crud_isset){
      case 'detail':
        $this->showModal('pages/tasks/task_detail.htm');
        break;
      case 'create':
        $this->createTask();
        break;
      case 'update':
        $this->updateTask();
        break;
      case 'delete':
        $this->removeTask();
        break;
      default:
        $this->showModal('pages/error.htm');
        $this->f3->reroute('/error');
        break;
    }
  }
}