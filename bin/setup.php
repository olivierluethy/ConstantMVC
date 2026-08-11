<?php
/**
 * =============================================================================
 * ConstantMVC — Database installer
 * =============================================================================
 *
 * Run this once from the project root to create the database and its table:
 *
 *     php bin/setup.php
 *
 * Or preview the SQL without touching the database:
 *
 *     php bin/setup.php --sql
 *
 * WHY THIS EXISTS: the table and columns are described only in config/Schema.php.
 * This script turns that description into a real table, so the Schema stays the
 * SINGLE SOURCE OF TRUTH — you never hand-write CREATE TABLE, and you never keep
 * a separate .sql file in sync. Change a field in the Schema, re-run this, done.
 *
 * This is a command-line script, not a web page.
 */

if (PHP_SAPI !== 'cli') {
    exit('Run this from the command line: php bin/setup.php');
}

require __DIR__ . '/../config/Schema.php';
$config = require __DIR__ . '/../config/config.php';
$db     = $config['db'];

// --- Build the SQL from the Schema (single source of truth) -----------------
$columns = ["  `" . Schema::PRIMARY_KEY . "` INT NOT NULL AUTO_INCREMENT PRIMARY KEY"];
foreach (Schema::FIELDS as $name => $field) {
    $size   = (int) ($field['max'] ?? 255);
    $unique = !empty($field['unique']) ? ' UNIQUE' : '';
    $columns[] = "  `{$name}` VARCHAR({$size}) NOT NULL{$unique}";
}
$columns[] = "  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP";

$createDatabase = "CREATE DATABASE IF NOT EXISTS `{$db['name']}` CHARACTER SET {$db['charset']};";
$createTable    = "CREATE TABLE IF NOT EXISTS `" . Schema::TABLE . "` (\n"
                . implode(",\n", $columns) . "\n);";

// --- --sql: just print the SQL and exit -------------------------------------
if (in_array('--sql', $argv, true)) {
    echo $createDatabase . "\n\n" . "USE `{$db['name']}`;\n\n" . $createTable . "\n";
    exit;
}

// --- Otherwise, connect and apply it ----------------------------------------
try {
    // Connect to the server first (no database selected yet) so we can create it.
    $dsn = "mysql:host={$db['host']};port={$db['port']};charset={$db['charset']}";
    $pdo = new PDO($dsn, $db['user'], $db['pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $pdo->exec($createDatabase);
    $pdo->exec("USE `{$db['name']}`");
    $pdo->exec($createTable);

    echo "✓ Database '{$db['name']}' is ready.\n";
    echo "✓ Table '" . Schema::TABLE . "' is ready (" . implode(', ', Schema::fieldNames()) . ").\n";
    echo "\nStart your server and open the app in a browser.\n";
} catch (PDOException $e) {
    fwrite(STDERR, "✗ Setup failed: " . $e->getMessage() . "\n");
    fwrite(STDERR, "  Check the credentials in config/config.php and that MySQL is running.\n");
    exit(1);
}
