<?php

class homeController extends homeModel{

	public function __construct($f3){
		parent::__construct($f3);
	}

	public function home(){
		//$users = $this->getPosts();
		//$this->f3->set('users', $users);
		if($this->f3->get('SESSION.user') !== NULL){
			$this->f3->reroute('/dashboard');
		}
		$this->f3->set('content', 'pages/home.htm');
		echo \Template::instance()->render('layout.htm');
	}
}
