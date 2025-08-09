<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Base Model
 *
 * Provides all models with access to the database connection.
 */
abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
}
