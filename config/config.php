<?php
/**
 * =============================================================================
 * CONSTANT Framework — Application configuration
 * =============================================================================
 *
 * SINGLE SOURCE OF TRUTH #1: the database CONNECTION.
 *
 * Every database credential (host, port, database name, user, password) lives
 * here and ONLY here. `core/Database.php` reads this file to open the one and
 * only PDO connection used by the whole app. If you move your database, change
 * its password, or rename it — you change it here, in one place, and nowhere
 * else.
 *
 * The table and column names are defined separately in `config/Schema.php`
 * (SINGLE SOURCE OF TRUTH #2), so the two concerns stay cleanly split.
 * -----------------------------------------------------------------------------
 */

return [
    // --- Database connection -------------------------------------------------
    'db' => [
        'host'    => '127.0.0.1',   // Use 127.0.0.1 (not "localhost") for a reliable TCP connection.
        'port'    => '3306',        // Default MySQL/MariaDB port.
        'name'    => 'framework',   // The database this app talks to.
        'user'    => 'root',        // Default XAMPP/MAMP user. Change for production!
        'pass'    => '',            // Default local password is empty. Change for production!
        'charset' => 'utf8mb4',     // Full Unicode (incl. emoji). Modern default.
    ],
];
