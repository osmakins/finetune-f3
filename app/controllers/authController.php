<?php
class authController extends authModel{

    public function __construct($f3){
    parent::__construct($f3);
    }

    function afterroute() {
		echo \Template::instance()->render('layout.htm');
	}

    public function login(){
        $this->f3->set('content', 'user/login.htm');
    }

    public function authenticate(){

        $ip = $_SERVER['REMOTE_ADDR'];
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        $username = $this->f3->get('POST.username');
        $password = $this->f3->get('POST.password');

        if($this->getCurrentUser($username) === FALSE) {
            $this->f3->reroute('/login');
        }

        $user = new user($this->f3, $username);

        if(password_verify($password, $user->password)) {
            $this->f3->logger->write( "LOG IN: ".$this->f3->get('POST.username')." login success (ip: " .$ip .")",'r'  );
            $this->f3->set('SESSION.user', $user->username);
            $this->f3->set('SESSION.user_id', $user->id);
            $this->f3->reroute('/dashboard');
        }
        else {
            $this->f3->logger->write("LOG IN: ".$this->f3->get('POST.username')." login failed (ip: " .$ip .")",'r'  );
            //$this->f3->reroute('/login');
            $this->f3->set('message', $this->f3->get('i10en_wrong_login'));
            $this->f3->set('content', 'user/login.htm');
        }
    }
    
    public function logout(){
        $this->f3->clear('SESSION');
        $this->f3->reroute('/login');
    }
}