<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    private User $userModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userModel = new User();
    }

    public function test_can_create_a_new_user()
    {
        $email = 'testuser' . uniqid() . '@example.com';
        $userData = [
            'name' => 'Test User',
            'email' => $email,
            'password' => 'password123'
        ];

        $userId = $this->userModel->create($userData);

        $this->assertNotFalse($userId, "User creation failed.");

        $newUser = $this->userModel->findByEmail($email);

        $this->assertIsArray($newUser);
        $this->assertEquals('Test User', $newUser['name']);
    }

    public function test_can_find_user_by_email()
    {
        // This test relies on the seed data
        $user = $this->userModel->findByEmail('admin@daurix.local');
        $this->assertIsArray($user);
        $this->assertEquals('Admin User', $user['name']);
    }

    public function test_find_by_email_returns_false_for_nonexistent_user()
    {
        $user = $this->userModel->findByEmail('nonexistent@example.com');
        $this->assertFalse($user);
    }

    public function test_password_is_hashed_correctly()
    {
        $email = 'testuser_hash_' . uniqid() . '@example.com';
        $password = 'secure_password_123';
        $userData = [
            'name' => 'Hash Test User',
            'email' => $email,
            'password' => $password
        ];

        $this->userModel->create($userData);
        $user = $this->userModel->findByEmail($email);

        $this->assertTrue(
            password_verify($password, $user['password']),
            "Password was not hashed correctly."
        );
    }
}
