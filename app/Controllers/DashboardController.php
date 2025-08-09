<?php

declare(strict_types=1);

namespace App\Controllers;

class DashboardController extends Controller
{
    public function index(): void
    {
        // In a real application, you would fetch user-specific data here.
        // For example, number of enrolled courses, progress, etc.
        $stats = [
            'enrolled_courses' => 5, // Placeholder
            'completed_lessons' => 25, // Placeholder
            'quizzes_taken' => 10, // Placeholder
            'certificates_earned' => 2, // Placeholder
        ];

        $this->render('dashboard/index', [
            'title' => 'My Dashboard',
            'userName' => $_SESSION['user_name'],
            'stats' => $stats
        ]);
    }
}
