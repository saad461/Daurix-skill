<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class Note extends Model
{
    /**
     * Create a new note record.
     *
     * @param array $data
     * @return int|false
     */
    public function create(array $data): int|false
    {
        $sql = "INSERT INTO notes (user_id, course_id, title, file_path) VALUES (:user_id, :course_id, :title, :file_path)";
        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            ':user_id' => $data['user_id'],
            ':course_id' => $data['course_id'],
            ':title' => $data['title'],
            ':file_path' => $data['file_path'],
        ]);

        if ($success) {
            return (int)$this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Find all notes for a specific user.
     *
     * @param int $userId
     * @return array
     */
    public function findByUser(int $userId): array
    {
        $sql = "SELECT n.*, c.title as course_title FROM notes n JOIN courses c ON n.course_id = c.id WHERE n.user_id = :user_id ORDER BY n.uploaded_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find all notes, joining with user and course data for admin view.
     *
     * @return array
     */
    public function findAllForAdmin(): array
    {
        $sql = "SELECT n.*, u.name as user_name, c.title as course_title
                FROM notes n
                JOIN users u ON n.user_id = u.id
                JOIN courses c ON n.course_id = c.id
                ORDER BY n.status ASC, n.uploaded_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find a single note by its ID.
     *
     * @param int $noteId
     * @return array|false
     */
    public function findById(int $noteId): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM notes WHERE id = :id");
        $stmt->execute([':id' => $noteId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update the status of a note.
     *
     * @param int $noteId
     * @param string $status
     * @return bool
     */
    public function updateStatus(int $noteId, string $status): bool
    {
        // Ensure status is one of the allowed enum values
        if (!in_array($status, ['approved', 'rejected'])) {
            return false;
        }

        $sql = "UPDATE notes SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':status' => $status, ':id' => $noteId]);
    }
}
