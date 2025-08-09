<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Request;

/**
 * Base Middleware
 *
 * All middleware must implement the handle method.
 */
abstract class Middleware
{
    abstract public function handle(Request $request): void;
}
