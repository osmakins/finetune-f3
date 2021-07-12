<?php

class staffController extends staffModel{

  // use pagesTrait;
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
        $projectArray = $this->getStaffById($id);
        $projectArray["hid"] = $hid;
        $this->f3->mset($projectArray);
        echo \Template::instance()->render($content);
        exit;
      }
      echo \Template::instance()->render($content);
      exit;
    }
  }
  public function updateStaff(){
    $this->showModal('pages/staff/staff_update.htm');

    $hid = $this->f3->get('POST.hid');
    $id = $this->crypteri->decrypt($hid);
    $dataSet = [
      ':id' => $id,
      ':firstname' => $this->f3->get('POST.firstname'),
      ':lastname' => $this->f3->get('POST.lastname'),
      ':email' => $this->f3->get('POST.email'),
      ':phone' => $this->f3->get('POST.phone'),
      ':position' => $this->f3->get('POST.position'),
      ':updated_at' => $this->getCurrentdate()
    ];

    $this->editStaff($dataSet);
    $this->f3->reroute('/staff');
  }
  
  public function staff(){

    $method = $this->f3->get('SERVER.REQUEST_METHOD');

    if($method === 'GET'){
      $this->f3->set('staff', $this->getStaff());
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
        $this->updateStaff();
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
