<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Request;
use App\Core\Response;

class AuthMiddleware extends Middleware
{
    public function handle(Request $request): void
    {
        // Check if user is logged in via session
        if (!isset($_SESSION['user_id'])) {
            // For API requests, we might want to return a JSON error instead
            // For now, we focus on the web flow
            (new Response())->redirect('/login');
            exit();
        }
    }
}
