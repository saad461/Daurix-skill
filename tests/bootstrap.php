<?php

// Set a base path constant
define('BASE_PATH', dirname(__DIR__));

// Require the autoloader
require_once BASE_PATH . '/vendor/autoload.php';

// Load environment variables for the test environment
$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();
