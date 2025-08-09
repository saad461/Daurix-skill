<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Course;

class CourseController extends Controller
{
    private Course $courseModel;

    public function __construct($request, $response)
    {
        parent::__construct($request, $response);
        $this->courseModel = new Course();
    }

    /**
     * Display a listing of all courses.
     */
    public function index(): void
    {
        $courses = $this->courseModel->findAll();

        $this->render('courses/index', [
            'title' => 'All Courses',
            'courses' => $courses
        ]);
    }

    /**
     * Display a single course and its content.
     *
     * @param string $slug
     */
    public function show(string $slug): void
    {
        $course = $this->courseModel->findBySlug($slug);

        if (!$course) {
            // Simple 404 handler
            $this->response->setStatusCode(404);
            $this->render('errors/404', ['title' => 'Course Not Found']);
            return;
        }

        $this->render('courses/show', [
            'title' => $course['title'],
            'course' => $course
        ]);
    }
}
