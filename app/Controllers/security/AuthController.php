<?php

namespace App\Controllers\security;

use App\Models\User;
use App\Utils\View;

class AuthController{

    public function loginPage(){

        View::render('pages/login');
    }

    public function register($request){

        $name = filter_var($request->name, FILTER_DEFAULT);
        $email = filter_var($request->email, FILTER_SANITIZE_EMAIL);
        $password = filter_var($request->password, FILTER_DEFAULT);

        if(empty($name) || empty($email) || empty($password)){
            http_response_code(400);
            return json_encode(['error' => "Esses valores são inválidos"]);
        }

        $user = new User($name, $email, $password);
        
        if($user->save()){
            http_response_code(201);
            return json_encode(['success' => true]);
        }else{
            http_response_code(500);
            return json_encode(['error' => "Ocorreu um erro"]);
        }
    }

}