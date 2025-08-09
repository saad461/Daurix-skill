<?php

declare(strict_types=1);

// Start the session
session_start();

// Define a constant for the project root
define('BASE_PATH', dirname(__DIR__));

// Autoload dependencies
require_once BASE_PATH . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

// Set error reporting based on environment
if ($_ENV['APP_ENV'] === 'development') {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    error_reporting(0);
}

// Instantiate the request and response objects
$request = new App\Core\Request();
$response = new App\Core\Response();

// Instantiate the router
$router = new App\Core\Router($request, $response);

// Load route definitions
require_once BASE_PATH . '/routes.php';

// Dispatch the router
try {
    $router->dispatch();
} catch (\Exception $e) {
    // In a real app, you'd have a more robust error handling page
    $response->setStatusCode(500);
    echo "<h1>500 - Server Error</h1>";
    if ($_ENV['APP_ENV'] === 'development') {
        echo "<pre>" . $e->getMessage() . "</pre>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
}
