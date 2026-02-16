<?php
namespace App\Core;

class RouterWithNameSpace
{
    public function routeRequest()
    {
        $url = $_GET['url'] ?? null;

        $url = rtrim($url, '/');

        $urlParts = explode('/', $url);

        $controllerNamePart = (empty($urlParts[0])) ? 'Home' : ucfirst($urlParts[0]);
        $controllerClass = 'App\\Controllers\\' . $controllerNamePart . 'Controller';

        $methodName = (empty($urlParts[1])) ? 'index' : $urlParts[1];

        // Grâce à l'autoloader de Composer, on peut directement vérifier si la classe existe
        // sans inclure le fichier manuellement.
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            if (method_exists($controller, $methodName)) {
                $params = array_slice($urlParts, 2);

                // On utilise la Réflexion pour vérifier le nombre de paramètres requis par la méthode
                $reflectionMethod = new \ReflectionMethod($controller, $methodName);
                $requiredParamsCount = $reflectionMethod->getNumberOfRequiredParameters();

                if (count($params) >= $requiredParamsCount) {
                    // call_user_func_array fonctionne que la méthode attende des paramètres ou non
                    call_user_func_array([$controller, $methodName], $params);
                } else {
                    http_response_code(404);
                    echo "Erreur 404 - Paramètres insuffisants pour la méthode {$methodName}.";
                }
            } else {
                http_response_code(404);
                echo "Erreur 404 - La méthode '{$methodName}' n'existe pas dans le contrôleur '{$controllerClass}'.";
            }
        } else {
            http_response_code(404);
            echo "Erreur 404 - Le contrôleur '{$controllerClass}' n'a pas été trouvé.";
        }
    }
}