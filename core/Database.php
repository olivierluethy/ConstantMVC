<?php
/**
 * =============================================================================
 * CONSTANT Framework — Database connector
 * =============================================================================
 *
 * This is the ONLY place in the whole framework that opens a PDO connection.
 * It reads its credentials from `config/config.php` (the single source of
 * truth for the connection) — no credentials are written here.
 *
 * It is a "singleton": the first call opens the connection, and every later
 * call reuses that same connection. This matters for performance — the old
 * code opened a brand-new connection several times per request. Now every
 * model shares one.
 *
 * MVC flow: Controller → Model → Database::connection() → your MySQL server.
 */

final class Database
{
    /** Holds the one shared PDO connection once it has been opened. */
    private static ?PDO $connection = null;

    /**
     * Returns the shared PDO connection, opening it on first use.
     */
    public static function connection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;   // Already connected — reuse it.
        }

        // Pull the connection settings from the single source of truth.
        $db = require __DIR__ . '/../config/config.php';
        $db = $db['db'];

        // Data Source Name: tells PDO which driver, host, database and charset.
        $dsn = "mysql:host={$db['host']};port={$db['port']};dbname={$db['name']};charset={$db['charset']}";

        try {
            self::$connection = new PDO($dsn, $db['user'], $db['pass'], [
                // Throw exceptions on error instead of failing silently.
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                // Return rows as associative arrays (['email' => ...]) by default.
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                // Use real prepared statements on the server (safer, faster).
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            // A clear, actionable message beats a raw stack trace for beginners.
            http_response_code(500);
            exit(
                "Could not connect to the database.\n\n" .
                "Check the settings in config/config.php and make sure your MySQL\n" .
                "server is running and the database has been created " .
                "(run: php bin/setup.php).\n\n" .
                "Original error: " . $e->getMessage()
            );
        }

        return self::$connection;
    }
}
