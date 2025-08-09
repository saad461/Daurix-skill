<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;

class AuthController extends Controller
{
    protected User $userModel;

    public function __construct($request, $response)
    {
        parent::__construct($request, $response);
        $this->userModel = new User();
    }

    public function showLoginForm(): void
    {
        $this->render('auth/login', ['title' => 'Login'], 'auth');
    }

    public function showRegisterForm(): void
    {
        $this->render('auth/register', ['title' => 'Register'], 'auth');
    }

    public function login(): void
    {
        $data = $this->request->getBody();
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        // Basic validation
        if (empty($email) || empty($password)) {
            // In a real app, use a flash message system
            $this->response->redirect('/login?error=credentials');
            return;
        }

        $user = $this->userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // Password is correct, start session
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_points'] = $user['points']; // Add points to session

            // Redirect based on role
            if ($user['role'] === 'admin') {
                $this->response->redirect('/admin/dashboard');
            } else {
                $this->response->redirect('/dashboard');
            }
        } else {
            // Invalid credentials
            $this->response->redirect('/login?error=invalid');
        }
    }

    public function register(): void
    {
        $data = $this->request->getBody();
        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $confirmPassword = $data['confirm_password'] ?? '';

        // Basic validation
        if (empty($name) || empty($email) || empty($password) || $password !== $confirmPassword) {
            $this->response->redirect('/register?error=validation');
            return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->response->redirect('/register?error=email');
            return;
        }

        // Check if user already exists
        if ($this->userModel->findByEmail($email)) {
            $this->response->redirect('/register?error=exists');
            return;
        }

        // Create user
        $userId = $this->userModel->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        if ($userId) {
            // Log the new user in immediately
            $user = $this->userModel->findById($userId);
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_points'] = $user['points']; // Add points to session for new user
            $this->response->redirect('/dashboard');
        } else {
            $this->response->redirect('/register?error=server');
        }
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        $this->response->redirect('/login');
    }
}
