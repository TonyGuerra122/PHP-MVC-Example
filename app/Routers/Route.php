<?php

namespace App\Routers;


class Route{

    public static function get(string $uri, string|callable $controller){

        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            if(strpos($uri, '{') === false){
            
                        
                if($_SERVER['REQUEST_URI'] === $uri){
                    if(!is_string($controller)){
                        $controller();
                        exit;
                    }
        
                    list($controllerName, $methodName) = explode('@', $controller);
        
                    $controllerNamespace = "App\\Controllers\\$controllerName";
        
                    if(class_exists($controllerNamespace)){
                        
        
                        $controllerInstance = new $controllerNamespace;
        
                        if(method_exists($controllerInstance, $methodName)){
        
                            return $controllerInstance->$methodName();
        
                            exit;
                        }
        
        
                    }
        
                    http_response_code(500);
                    throw new \Exception("Controller Inexistente");
                }
    
            }else{
    
                $uriPattern = preg_replace('#\{([^\}]+)\}#', '([^\/]+)', ($uri));
                $uriPattern = str_replace('/', '\/', $uriPattern);
    
                if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match("#^$uriPattern$#", $_SERVER['REQUEST_URI'], $routeParams)) {
                    
                    $requestData = new \stdClass;
    
                    foreach($routeParams as &$params){
                        $params = urldecode($params);
                    }
                    unset($params);
    
                    $requestData->routeParams = $routeParams;
    
                    list($controllerName, $methodName) = explode('@', $controller);
                    $controllerNamespace = "App\\Controllers\\$controllerName";
    
                    if (class_exists($controllerNamespace)) {
                        $controllerInstance = new $controllerNamespace;
    
                        if (method_exists($controllerInstance, $methodName)) {
                            
                            return $controllerInstance->$methodName($requestData);
                         
                            
                            exit;
    
                        }
                    }
                }
            }
        }        

    }

    public static function post(string $uri, string|callable $controller){

        if($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === $uri){

            if(!is_string($controller)){

                $controller();
                return;
            }

            list($controllerName, $methodName) = explode('@', $controller);
            
            $controllerNamespace = "App\\Controllers\\$controllerName";
            
            if(class_exists($controllerNamespace)){

                $requestBody = file_get_contents("php://input");
                $requestData = json_decode($requestBody);

                $controllerInstance = new $controllerNamespace;

                if(method_exists($controllerInstance, $methodName)){

                    return $controllerInstance->$methodName($requestData);

                }else{
                    http_response_code(500);
                    throw new \Exception("Controller Inexistente");
                }

            }
        }

    }

}