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

  public function tasks(){
    
  $method = $this->f3->get('SERVER.REQUEST_METHOD');

    if($method === 'GET'){
      $this->f3->set('tasks', $this->getTasks());
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
        $this->showModal('pages/tasks/task_create.htm');
        break;
      case 'update':
        $this->showModal('pages/tasks/task_update.htm');
        break;
      case 'delete':
        $this->showModal('pages/tasks/task_delete.htm');
        break;
      default:
        $this->showModal('pages/error.htm');
        $this->f3->reroute('/error');
        break;
    }
  }
}