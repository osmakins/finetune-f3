<?php
class userController extends userModel{

    public function __construct($f3){
    parent::__construct($f3);
    }

    public function login(){
        $this->f3->set('content', 'login/login.htm');
        echo \Template::instance()->render('layout.htm');
    }

    public function authenticate(){

        $username = $this->f3->get('POST.username');
        $password = $this->f3->get('POST.password');

        if($this->getCurrentUser($username) === FALSE) {
            $this->f3->reroute('/login');
        }
        $user = new user($this->f3, $username);
        if(password_verify($password, $user->password)) {
            $this->f3->set('SESSION.user', $user->username);
            $this->f3->reroute('/dashboard');
        } else {
            $this->f3->reroute('/login');
        }
    }
    
    public function logout(){
        $this->f3->clear('SESSION');
        $this->f3->reroute('/login');
    }
}