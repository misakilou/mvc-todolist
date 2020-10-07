<?php

namespace Controller;

use Model\UserManager;
use Service\Session;

class UserController extends AbstractController
{


    public function __contruct(){
        if( Session::getInstance()->read('user_id')){
            header('Location: /');
        }

    }

    public function home(){

        return $this->twig->render('Auth/register.html.twig');

    }


    public function index()
    {


    }

    public function login(){
        return $this->twig->render('Auth/login.html.twig');
    }

    public function logout(){
        Session::getInstance()->logout();
        header('Location: /login');
    }

    public function auth(){

        $message_bag = array();
        if(empty($_POST['email']) || empty($_POST['password'])){
            $message_bag['field_empty'] = 'Veuillez saisir un email et un mot de passe';
            return $this->twig->render('Auth/login.html.twig' , ['message_bag' => $message_bag ]);
        }
        else{
            $email = htmlentities($_POST['email']);
            $password = htmlentities($_POST['password']);
            $userManager = new UserManager();
            $user = $userManager->selectWhere("email = '$email'");

            $user_password = $user[0]->getPassword();

            if($user && password_verify($password, $user_password )){

                Session::getInstance()->write('user_id',$user[0]->getId());
                Session::getInstance()->write('user_name',$user[0]->getName());

                header('Location: /');
            }
            
            $message_bag['auth_error'] = 'Login ou Password incorrect';
            return $this->twig->render('Auth/login.html.twig' , ['message_bag' => $message_bag ]);
        }



    }


    public function store(){

        $message_bag = array();
        //Verification du nom
        if(isset($_POST['name']) && !empty($_POST['name'])) {
            $name = htmlentities($_POST['name']);
        }
        else{
             $message_bag['name'] = 'Veuillez saisir un nom';
        }

         //Verification du mail
        if(isset($_POST['email']) && !empty($_POST['email'])) {
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $message_bag['email'] = 'Le mail n\'est pas valide';
            }
            else{
                $email = htmlentities($_POST['email']);
            }
        }
        else{
            $message_bag['mail'] = 'Veuillez saisir un email';
        }

        //Verification du password
        if(!empty($_POST['password'])){
            if($_POST['password'] != $_POST['confirm_password']){
                $message_bag['password']  = 'Le mot de passe de confirmation est différent';
            }
            else{
                $password = htmlentities($_POST['password']);
            }

        }
        else{
            $message_bag['password'] = 'Veuillez saisir un mot de passe';
        }

        if(count($message_bag) == 0 ){
            $userManager = new UserManager();
            $api_token = self::randomString();

            $data = array('name' => $name, 'email' => $email , 'password' => password_hash($password, PASSWORD_BCRYPT) , 'api_token' => $api_token);
            $user = $userManager->insert($data);
            
            Session::getInstance()->write('user_id',$user->id);
            Session::getInstance()->write('user_name',$user->name);

            header('Location: /');

        }
        else{

            return $this->twig->render('Auth/register.html.twig' , ['message_bag' => $message_bag ]);
        }


    } 

    private static function randomString($length = 80){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
        
    }



}
