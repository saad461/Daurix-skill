<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class Course extends Model
{
    /**
     * Find all courses.
     *
     * @return array
     */
    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT id, title, description, slug, featured_image FROM courses ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find a single course by its slug.
     *
     * @param string $slug
     * @return array|false
     */
    public function findBySlug(string $slug): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE slug = :slug");
        $stmt->execute(['slug' => $slug]);
        $course = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($course) {
            $course['modules'] = $this->findModulesForCourse($course['id']);
        }

        return $course;
    }

    /**
     * Find a single course by its ID.
     *
     * @param int $id
     * @return array|false
     */
    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Find all modules and their lessons for a given course ID.
     *
     * @param int $courseId
     * @return array
     */
    public function findModulesForCourse(int $courseId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM modules WHERE course_id = :course_id ORDER BY `order` ASC");
        $stmt->execute(['course_id' => $courseId]);
        $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $lessonStmt = $this->db->prepare("SELECT * FROM lessons WHERE module_id = :module_id ORDER BY `order` ASC");

        foreach ($modules as $key => $module) {
            $lessonStmt->execute(['module_id' => $module['id']]);
            $modules[$key]['lessons'] = $lessonStmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $modules;
    }

    /**
     * Create a new course.
     *
     * @param array $data
     * @return int|false
     */
    public function create(array $data): int|false
    {
        $slug = $this->generateSlug($data['title']);
        $sql = "INSERT INTO courses (title, description, slug, featured_image) VALUES (:title, :description, :slug, :featured_image)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':slug' => $slug,
            ':featured_image' => $data['featured_image'] ?? null
        ]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Update an existing course.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $slug = $this->generateSlug($data['title']);
        $sql = "UPDATE courses SET title = :title, description = :description, slug = :slug WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':slug' => $slug
        ]);
    }

    /**
     * Delete a course.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM courses WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    private function generateSlug(string $title): string
    {
        $slug = strtolower($title);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        $slug = trim($slug, '-');
        // Check for uniqueness
        $stmt = $this->db->prepare("SELECT id FROM courses WHERE slug = ?");
        $stmt->execute([$slug]);
        if ($stmt->fetch()) {
            $slug .= '-' . uniqid();
        }
        return $slug;
    }
}
