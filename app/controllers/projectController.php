<?php

class projectController extends projectModel{
  
  use pagesTrait;

  public function projects(){
    $this->f3->set('content', 'pages/projects.htm');
  }


  public function createProject() {
    $data = [$this->f3->get('POST.title'),
    $this->f3->get('POST.description'),
    $this->f3->get('POST.client'),
    $this->f3->get('POST.timetocomplete')];

    $this->addProject($data);
    $this->f3->set('content', 'pages/projects.htm');
  }
}