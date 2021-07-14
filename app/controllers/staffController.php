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
        $staffArray = $this->getStaffById($id);
        $staffArray["hid"] = $hid;
        $this->f3->mset($staffArray);
        echo \Template::instance()->render($content);
        exit;
      }
      echo \Template::instance()->render($content);
      exit;
    }
  }

  public function createStaff(){
    $this->showModal('pages/staff/staff_create.htm');

    $password = password_hash($this->f3->get('POST.password'), PASSWORD_BCRYPT);
    $dataPack = [
      ':username' => $this->f3->get('POST.username'),
      ':password' => $password,
      ':firstname' => $this->f3->get('POST.firstname'),
      ':lastname' => $this->f3->get('POST.lastname'),
      ':email' => $this->f3->get('POST.email'),
      ':position' => $this->f3->get('POST.position'),
      ':phone' => $this->f3->get('POST.phone'),
      ':created_at' => $this->getCurrentdate()
    ];
    $this->f3->reroute('/staff');
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
  
  public function removeStaff(){
    $this->showModal('pages/staff/staff_delete.htm');
    
    $hid = $this->f3->get('POST.hid');
    $id = $this->crypteri->decrypt($hid);
    
    $this->deleteStaff($id);
    $this->f3->reroute('/staff');
  }

  public function staff(){

    $method = $this->f3->get('SERVER.REQUEST_METHOD');

    if($method === 'GET'){
      
      $page = $this->f3->get('GET.page');
      $page = isset($page)? $page : 1;

      $record_per_page = 5;

      $start_from = ($page - 1) * $record_per_page;
      
      $data = $this->getStaff($start_from, $record_per_page);
      
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
		  $this->f3->set('staff', $data['query'] );
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
        $this->createStaff();
        break;
      case 'update':
        $this->updateStaff();
        break;
      case 'delete':
        $this->removeStaff();
        break;
      default:
        $this->showModal('pages/error.htm');
        $this->f3->reroute('/error');
        break;
    }
  }
}
