<?php
/**
 * =============================================================================
 * CONSTANT Framework — Data schema
 * =============================================================================
 *
 * SINGLE SOURCE OF TRUTH #2: the TABLE and its COLUMNS.
 *
 * This class describes the one demo entity that ships with the framework: a
 * "person". The table name, the editable fields, their labels, their input
 * types, and their validation rules are ALL defined here — once.
 *
 * Everything downstream reads from this file instead of repeating the names:
 *   • app/Models/Person.php   builds its SQL from Schema::TABLE + field names.
 *   • app/Views/*             build the form inputs by looping Schema::FIELDS.
 *   • core/Validator.php      validates input against these rules.
 *   • bin/setup.php           creates the real database table from this schema.
 *
 * ┌─────────────────────────────────────────────────────────────────────────┐
 * │  WANT TO RENAME A COLUMN OR ADD A FIELD?  Edit ONLY this file, then run   │
 * │  `php bin/setup.php` to apply it to the database. That is the whole job.  │
 * └─────────────────────────────────────────────────────────────────────────┘
 */

final class Schema
{
    /** The database table this entity maps to. Rename here → changes everywhere. */
    public const TABLE = 'people';

    /** The auto-increment primary key column. */
    public const PRIMARY_KEY = 'id';

    /**
     * The editable fields, in display order.
     *
     * Each field declares how it behaves across the whole stack:
     *   label    → shown next to the input in forms and as the table header
     *   input    → HTML input type ("text", "email", ...) used in the form
     *   required → must have a value (checked on both client and server)
     *   max      → maximum length; also the VARCHAR size the installer creates
     *   unique   → adds a UNIQUE constraint in the database
     */
    public const FIELDS = [
        'first_name' => ['label' => 'First name', 'input' => 'text',  'required' => true,  'max' => 255],
        'last_name'  => ['label' => 'Last name',  'input' => 'text',  'required' => true,  'max' => 255],
        'email'      => ['label' => 'Email',       'input' => 'email', 'required' => true,  'max' => 100, 'unique' => true],
    ];

    /** Convenience: just the column names, e.g. ['first_name', 'last_name', 'email']. */
    public static function fieldNames(): array
    {
        return array_keys(self::FIELDS);
    }
}
