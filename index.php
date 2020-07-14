<?php

session_start();
include('app//controller//ContactsController.php');

$route = new Route;

class Route
{
    private $routes;

    public function __construct(){
        $this->initRoutes();
        $this->run($this->getUrl());
    }

    public function initRoutes(){
        $this->routes['/'] = array('Controller' => 'ContactsController', 'action' => 'index');
        $this->routes['/contact'] = array('Controller' => 'ContactsController', 'action' => 'contact');
        $this->routes['/about'] = array('Controller' => 'ContactsController', 'action' => 'about');
        $this->routes['/home'] = array('Controller' => 'ContactsController', 'action' => 'home');
        $this->routes['/login'] = array('Controller' => 'ContactsController', 'action' => 'login');
        $this->routes['/logout'] = array('Controller' => 'ContactsController', 'action' => 'logout');
    }

    protected function run($url){
        if(array_key_exists($url, $this->routes)){
            $contact = new ContactsController();
            
            $return = $contact->handleRequest($this->routes[$url]['action']);
            echo json_encode($return, JSON_UNESCAPED_UNICODE);
        }else{
            require_once 'pages/error.php';
            echo '<script>console.log("Atenção! não existe essa URL, por favor contate o administrador!");</script>';
        }
    }

    public function getUrl(){
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);            
    }
}