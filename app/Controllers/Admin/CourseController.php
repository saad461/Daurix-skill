<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Course;

class CourseController extends Controller
{
    private Course $courseModel;

    public function __construct($request, $response)
    {
        parent::__construct($request, $response);
        $this->courseModel = new Course();
    }

    // List all courses
    public function index(): void
    {
        $courses = $this->courseModel->findAll();
        $this->render('admin/courses/index', ['title' => 'Manage Courses', 'courses' => $courses]);
    }

    // Show form to create a new course
    public function create(): void
    {
        $this->render('admin/courses/create', ['title' => 'Create New Course']);
    }

    // Store a new course
    public function store(): void
    {
        $data = $this->request->getBody();
        // Add validation logic here
        $this->courseModel->create($data);
        $this->response->redirect('/admin/courses');
    }

    // Show form to edit a course
    public function edit(int $id): void
    {
        $course = $this->courseModel->findById($id);
        if (!$course) {
            // Handle not found
            $this->response->redirect('/admin/courses');
            return;
        }
        $this->render('admin/courses/edit', ['title' => 'Edit Course', 'course' => $course]);
    }

    // Update an existing course
    public function update(int $id): void
    {
        $data = $this->request->getBody();
        // Add validation logic here
        $this->courseModel->update($id, $data);
        $this->response->redirect('/admin/courses');
    }

    // Delete a course
    public function delete(int $id): void
    {
        $this->courseModel->delete($id);
        $this->response->redirect('/admin/courses');
    }
}
