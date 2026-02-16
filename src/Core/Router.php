<?php

class Router
{
    public function routeRequest()
    {
        $url = $_GET['url'] ?? null;

        $urlParts = explode('/', $url);

        $controllerName = (empty($urlParts[0])) ? 'HomeController' : ucfirst($urlParts[0]) . 'Controller';

        $methodName = (empty($urlParts[1])) ? 'index' : $urlParts[1];

        $controllerFile = dirname(__DIR__) . '/Controllers/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if (method_exists($controller, $methodName)) {
                    $params = array_slice($urlParts, 2); //On récupère dans un tableau les paramètres depuis l'index 2 de $urlParts
                    $reflectionMethod = new ReflectionMethod($controller, $methodName);
                    $methodParams = $reflectionMethod->getParameters();

                    if (count($methodParams) > 0) {
                        //Méthode avec paramètres
                        if (count($params) >= count($methodParams)) {
                            call_user_func_array([$controller, $methodName], $params);
                        } else {
                            echo "error 404 - insufficient URL parameters";
                        }
                    } else {
                        //Méthode sans paramètre
                        $controller->$methodName();
                    }
                } else {
                    echo "error 404 - {$methodName}() method not found";
                }
            } else {
                echo "error 404 - {$controllerName} class not found";
            }
        } else {
            echo "error 404 - {$controllerFile} Controller not found";
        }
    }
}