<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class UserController {
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this -> db = new Database($config);
    }

    public function create(){
        loadView('users/create');
    }

    public function login(){
        loadView('users/login');
    }

    public function store() {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $pwd = $_POST['password'];
        $pwdConfirmation = $_POST['password_confirmation'];

        $errors = [];

        //Validation 
        if (!Validation::email($email)){
            $errors['email'] = 'Please enter a valid email address';
        }

        if (!Validation::string($name, 2, 50)){
            $errors['name'] = 'Name must be between 2 and 50 characters';
        }
        if (!Validation::string($pwd, 6, 100)){
            $errors['pwd'] = 'Password must be at least 6 characters';
        }
        if (!Validation::match($pwd, $pwdConfirmation)){
            $errors['password_confirmation'] = 'Passwords do not match';
        }

        if (!empty($errors)){
            loadView('users/create', [
                'errors' => $errors,
                'user' => [
                    'name' => $name,
                    'email' => $email,
                    'city' => $city,
                    'state' => $state
                ]
                ]);
                exit;
        }
        else {

        }
    }


}