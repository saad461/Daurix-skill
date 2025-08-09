<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class User extends Model
{
    /**
     * Find a user by their email address.
     *
     * @param string $email
     * @return array|false
     */
    public function findByEmail(string $email): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Find a user by their ID.
     *
     * @param int $id
     * @return array|false
     */
    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare("SELECT id, name, email, role, points, dark_mode, profile_picture FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return int|false
     */
    public function create(array $data): int|false
    {
        // Hash the password before storing it
        $passwordHash = password_hash($data['password'], PASSWORD_BCRYPT);

        $stmt = $this->db->prepare(
            "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)"
        );

        $success = $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $passwordHash,
            'role' => $data['role'] ?? 'student', // Default to student
        ]);

        if ($success) {
            return (int)$this->db->lastInsertId();
        }

        return false;
    }

    /**
     * Add points to a user's account and log the transaction.
     *
     * @param int $userId
     * @param int $points
     * @param string $reason
     * @param int|null $relatedId
     * @param string|null $relatedType
     * @return bool
     */
    public function addPoints(int $userId, int $points, string $reason, ?int $relatedId = null, ?string $relatedType = null): bool
    {
        try {
            $this->db->beginTransaction();

            // Add points to user
            $stmt = $this->db->prepare("UPDATE users SET points = points + :points WHERE id = :user_id");
            $stmt->execute([':points' => $points, ':user_id' => $userId]);

            // Log the transaction
            $stmt = $this->db->prepare(
                "INSERT INTO points_transactions (user_id, points_change, reason, related_id, related_type)
                 VALUES (:user_id, :points_change, :reason, :related_id, :related_type)"
            );
            $stmt->execute([
                ':user_id' => $userId,
                ':points_change' => $points,
                ':reason' => $reason,
                ':related_id' => $relatedId,
                ':related_type' => $relatedType,
            ]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            // In a real app, log the exception $e
            return false;
        }
    }

    /**
     * Find all users.
     *
     * @return array
     */
    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT id, name, email, role, points, created_at FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update a user's details.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE users SET name = :name, email = :email, role = :role, points = :points WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':role' => $data['role'],
            ':points' => $data['points'] ?? 0,
        ]);
    }

    /**
     * Delete a user.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        // To prevent an admin from deleting themselves
        if (isset($_SESSION['user_id']) && $id === $_SESSION['user_id']) {
            return false;
        }
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
