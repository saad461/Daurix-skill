<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Request;
use App\Core\Response;

class AdminMiddleware extends Middleware
{
    public function handle(Request $request): void
    {
        // This middleware should run after AuthMiddleware,
        // so we can assume $_SESSION['user_id'] exists.

        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            // User is not an admin, redirect them to their dashboard
            (new Response())->redirect('/dashboard');
            exit();
        }
    }
}
