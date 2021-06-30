<?php

class modalController{
  public $f3;

  public function __construct($f3){
    $this->f3 = $f3;
    if($f3->get('SESSION.user') === NULL){
      $f3->reroute('/login');
    }
  }

  public function routeModal(){
    $action = $this->f3->get('GET.action');
      if($action === 'open'){
        echo 'opened';
        exit;
      }
      if($action === 'edit'){
        echo 'edited';
        exit;
      }

      if($action === 'delete'){
        echo 'deleted';
        exit;
      }
    }
  }
