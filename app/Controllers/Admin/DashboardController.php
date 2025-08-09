<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(): void
    {
        // Fetch data for admin dashboard (e.g., user counts, revenue, etc.)
        $stats = [
            'total_students' => 1250, // Placeholder
            'active_courses' => 15,    // Placeholder
            'total_enrollments' => 3400, // Placeholder
            'pending_notes' => 8,      // Placeholder
        ];

        // Data for charts
        $chartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'datasets' => [
                [
                    'label' => 'New Signups',
                    'data' => [65, 59, 80, 81, 56, 55],
                    'borderColor' => 'rgba(0, 224, 255, 1)',
                    'backgroundColor' => 'rgba(0, 224, 255, 0.2)',
                    'fill' => true,
                ]
            ]
        ];

        $this->render('admin/dashboard/index', [
            'title' => 'Admin Dashboard',
            'stats' => $stats,
            'chartData' => json_encode($chartData),
        ]);
    }
}
