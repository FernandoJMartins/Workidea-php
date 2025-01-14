<?php

namespace Framework\Middleware;

use Framework\Session;

class Authorization{
    //Check if user is authenticated
    public function isAuthenticated(){
        return Session::has('user');
    } 

    //Handle the user request
    public function handle($role){
        if($role === 'guest' && $this -> isAuthenticated()){
            header('Location: /public/');
            exit;
        }
        elseif($role === 'auth' && !$this -> isAuthenticated()){
            header('Location: /public/auth/login');
            exit; 
        }
    }
}