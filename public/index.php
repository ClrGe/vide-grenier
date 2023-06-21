<?php
/**
 * Front controller
 *
 * PHP version 7.0
 */

session_start();

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Error and Exception handling
 */
error_reporting(0);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');
/** Swagger */
// generate openapi documentation with swagger-php
$openapi = \OpenApi\Generator::scan([dirname(__DIR__) . '/App/Controllers', dirname(__DIR__) . '/Core']);

// generate json
$openapi->toJson();

// print json to file
// save json to file
try {
    $openapi->saveAs("./openapi.json");
} catch (Exception $e) {
    echo $e->getMessage();
}


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes



/**
 * @OA\Get(
 *     path="/",
 *     @OA\Response(response="200", description="Display the home page"),
 *     tags={"Home"}
 * )
 */
$router->add('', ['controller' => 'Home', 'action' => 'index']);

/**
 * @OA\Get(
 *     path="/login",
 *     @OA\Response(response="200", description="Display the login form"),
 *     tags={"User"}
 * )
 */
$router->add('login', ['controller' => 'User', 'action' => 'login']);

/**
 * @OA\Get(
 *     path="/register",
 *     @OA\Response(response="200", description="Display the register form"),
 *     tags={"User"}
 * )
 */
$router->add('register', ['controller' => 'User', 'action' => 'register']);

/**
 * @OA\Get(
 *     path="/logout",
 *     @OA\Response(response="200", description="Logout the user"),
 *     security={{"api_key":{}}},
 *     tags={"User"}
 * )
 */
$router->add('logout', ['controller' => 'User', 'action' => 'logout' , 'private' => true]);

/**
 * @OA\Get(
 *     path="/account",
 *     @OA\Response(response="200", description="Display the user account"),
 *     security={{"api_key":{}}},
 *     tags={"User"}
 * )
 */
$router->add('account', ['controller' => 'User', 'action' => 'account', 'private' => true]);

/**
 * @OA\Get(
 *     path="/product",
 *     @OA\Response(response="200", description="Display a list of products"),
 *     security={{"api_key":{}}},
 *     tags={"Product"}
 * )
 */
$router->add('product', ['controller' => 'Product', 'action' => 'index', 'private' => true]);

/**
 * @OA\Get(
 *     path="/product/{id}",
 *     @OA\Response(response="200", description="Display a product"),
 *     security={{"api_key":{}}},
 *     tags={"Product"}
 * )
 */
$router->add('product/{id:\d+}', ['controller' => 'Product', 'action' => 'show']);


$router->add('{controller}/{action}');


/*
 * Gestion des erreurs dans le routing
 */
try {
    $router->dispatch($_SERVER['QUERY_STRING']);
} catch(Exception $e){
    switch($e->getMessage()){
        case 'You must be logged in':
            header('Location: /login');
            break;
    }
}
