<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    private User $userModel;

    public function __construct($request, $response)
    {
        parent::__construct($request, $response);
        $this->userModel = new User();
    }

    // List all users
    public function index(): void
    {
        $users = $this->userModel->findAll();
        $this->render('admin/users/index', ['title' => 'Manage Users', 'users' => $users]);
    }

    // Show form to create a new user
    public function create(): void
    {
        $this->render('admin/users/create', ['title' => 'Create New User']);
    }

    // Store a new user
    public function store(): void
    {
        $data = $this->request->getBody();
        // Add more robust validation here
        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            $this->response->redirect('/admin/users/create?error=validation');
            return;
        }
        $this->userModel->create($data);
        $this->response->redirect('/admin/users');
    }

    // Show form to edit a user
    public function edit(int $id): void
    {
        $user = $this->userModel->findById($id);
        if (!$user) {
            $this->response->redirect('/admin/users');
            return;
        }
        $this->render('admin/users/edit', ['title' => 'Edit User', 'user' => $user]);
    }

    // Update an existing user
    public function update(int $id): void
    {
        $data = $this->request->getBody();
        // Add validation
        $this->userModel->update($id, $data);
        $this->response->redirect('/admin/users');
    }

    // Delete a user
    public function delete(int $id): void
    {
        $this->userModel->delete($id);
        $this->response->redirect('/admin/users');
    }
}
