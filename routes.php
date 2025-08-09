<?php

use App\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Controllers\Api\AiController;
use App\Controllers\AuthController;
use App\Controllers\CourseController;
use App\Controllers\DashboardController;
use App\Middleware\AdminMiddleware;
use App\Middleware\AuthMiddleware;

/** @var App\Core\Router $router */

// This file is included from public/index.php and has access to the $router instance

// --- Web Routes ---

// Homepage
$router->get('/', function() {
    echo "Welcome to DaurixSkills!";
});

// Authentication
$router->get('/login', [AuthController::class, 'showLoginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegisterForm']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout'], [AuthMiddleware::class]);

// Student Dashboard
$router->get('/dashboard', [DashboardController::class, 'index'], [AuthMiddleware::class]);

// Courses
$router->get('/courses', [CourseController::class, 'index']);
$router->get('/courses/{slug}', [CourseController::class, 'show']);

// --- Admin Routes ---
// Note: A more robust implementation might use route grouping to apply middleware
$router->get('/admin/dashboard', [AdminDashboardController::class, 'index'], [AuthMiddleware::class, AdminMiddleware::class]);
use App\Controllers\Admin\CourseController as AdminCourseController;

use App\Controllers\Admin\NoteController as AdminNoteController;
use App\Controllers\NoteController;

// Add more admin routes for managing courses, users, etc.
$router->get('/admin/courses', [AdminCourseController::class, 'index'], [AuthMiddleware::class, AdminMiddleware::class]);
$router->get('/admin/courses/create', [AdminCourseController::class, 'create'], [AuthMiddleware::class, AdminMiddleware::class]);
$router->post('/admin/courses', [AdminCourseController::class, 'store'], [AuthMiddleware::class, AdminMiddleware::class]);
$router->get('/admin/courses/{id}/edit', [AdminCourseController::class, 'edit'], [AuthMiddleware::class, AdminMiddleware::class]);
$router->post('/admin/courses/{id}', [AdminCourseController::class, 'update'], [AuthMiddleware::class, AdminMiddleware::class]);
$router->post('/admin/courses/{id}/delete', [AdminCourseController::class, 'delete'], [AuthMiddleware::class, AdminMiddleware::class]);

// Admin Notes Management
$router->get('/admin/notes', [AdminNoteController::class, 'index'], [AuthMiddleware::class, AdminMiddleware::class]);
$router->post('/admin/notes/{id}/approve', [AdminNoteController::class, 'approve'], [AuthMiddleware::class, AdminMiddleware::class]);
$router->post('/admin/notes/{id}/reject', [AdminNoteController::class, 'reject'], [AuthMiddleware::class, AdminMiddleware::class]);

// Admin User Management
use App\Controllers\Admin\UserController as AdminUserController;
$router->get('/admin/users', [AdminUserController::class, 'index'], [AuthMiddleware::class, AdminMiddleware::class]);
$router->get('/admin/users/create', [AdminUserController::class, 'create'], [AuthMiddleware::class, AdminMiddleware::class]);
$router->post('/admin/users', [AdminUserController::class, 'store'], [AuthMiddleware::class, AdminMiddleware::class]);
$router->get('/admin/users/{id}/edit', [AdminUserController::class, 'edit'], [AuthMiddleware::class, AdminMiddleware::class]);
$router->post('/admin/users/{id}', [AdminUserController::class, 'update'], [AuthMiddleware::class, AdminMiddleware::class]);
$router->post('/admin/users/{id}/delete', [AdminUserController::class, 'delete'], [AuthMiddleware::class, AdminMiddleware::class]);

// Student Notes
$router->get('/my-notes', [NoteController::class, 'index'], [AuthMiddleware::class]);
$router->get('/my-notes/upload', [NoteController::class, 'create'], [AuthMiddleware::class]);
$router->post('/my-notes', [NoteController::class, 'store'], [AuthMiddleware::class]);


// --- API Routes ---
use App\Controllers\QuizController;

// Quizzes
$router->get('/courses/{id}/quiz', [QuizController::class, 'show'], [AuthMiddleware::class]);
$router->post('/courses/{id}/quiz', [QuizController::class, 'submit'], [AuthMiddleware::class]);
$router->get('/quiz/submission/{id}', [QuizController::class, 'showResult'], [AuthMiddleware::class]);


// --- API Routes ---
// A simple prefix check could be done in the Router or here for '/api'
$router->post('/api/ai/chat', [AiController::class, 'chat'], [AuthMiddleware::class]); // Assuming API access requires user login


// If you were to build a more complex API, you would add more endpoints here
// $router->get('/api/courses', [ApiCourseController::class, 'index']);
// $router->get('/api/courses/{id}', [ApiCourseController::class, 'show']);
