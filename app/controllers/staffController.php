<?php

class staffController extends staffModel{

  // use pagesTrait;
  public $f3;

  public function __construct($f3){
    $this->f3 = $f3;
    if($f3->get('SESSION.user') === NULL){
      $f3->reroute('/login');
    }
  }

  public function showModal($content){
    $modal = $this->f3->get('POST.modal');
    if(isset($modal)){
      echo \Template::instance()->render($content);
      exit;
    }
  }

  public function staff(){

    $method = $this->f3->get('SERVER.REQUEST_METHOD');

    if($method === 'GET'){
      $this->f3->set('content', 'pages/staff/staff.htm');
      echo \Template::instance()->render('layout.htm');
      exit;
    }

    $submit = $this->f3->get('POST.submit');
    $crud_isset = ($method === 'POST' && $submit !== NULL) ? $submit : FALSE;

    switch($crud_isset){
      case 'detail':
        $this->showModal('pages/staff/staff_detail.htm');
        break;
      case 'create':
        $this->showModal('pages/staff/staff_create.htm');
        break;
      case 'update':
        $this->showModal('pages/staff/staff_update.htm');
        break;
      case 'delete':
        $this->showModal('pages/staff/staff_delete.htm');
        break;
      default:
        $this->showModal('pages/error.htm');
        $this->f3->reroute('/error');
        break;
    }
  }
}
