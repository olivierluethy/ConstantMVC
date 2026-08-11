<?php
/**
 * =============================================================================
 * ConstantMVC — Person model (the "M" in MVC)
 * =============================================================================
 *
 * The model is the ONLY layer that talks to the database. Controllers ask the
 * model for data; they never write SQL themselves.
 *
 * Every query below is built from `Schema` — the table name and column names
 * are never typed out as strings here. That is the whole point of the
 * framework: rename a column in config/Schema.php and this model follows
 * automatically, no edits needed.
 *
 * All queries use prepared statements, so user input can never be injected
 * into SQL.
 */

final class Person
{
    private PDO $db;

    public function __construct()
    {
        // Reuse the one shared connection (see core/Database.php).
        $this->db = Database::connection();
    }

    /**
     * Return every person, newest first.
     */
    public function all(): array
    {
        // e.g. SELECT * FROM `people` ORDER BY `id` DESC
        $sql = 'SELECT * FROM `' . Schema::TABLE . '` ORDER BY `' . Schema::PRIMARY_KEY . '` DESC';
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Find a single person by primary key, or null if not found.
     */
    public function find(int $id): ?array
    {
        $sql = 'SELECT * FROM `' . Schema::TABLE . '` WHERE `' . Schema::PRIMARY_KEY . '` = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    /**
     * Insert a new person. $data is already validated by the controller.
     * The column list and placeholders are generated from the Schema fields.
     */
    public function create(array $data): void
    {
        $fields       = Schema::fieldNames();                       // ['first_name', 'last_name', 'email']
        $columns      = '`' . implode('`, `', $fields) . '`';        // `first_name`, `last_name`, `email`
        $placeholders = ':' . implode(', :', $fields);              // :first_name, :last_name, :email

        $sql = 'INSERT INTO `' . Schema::TABLE . "` ($columns) VALUES ($placeholders)";
        $this->db->prepare($sql)->execute($this->only($data));
    }

    /**
     * Update an existing person by primary key.
     */
    public function update(int $id, array $data): void
    {
        // Build "`first_name` = :first_name, `last_name` = :last_name, ..."
        $assignments = implode(', ', array_map(
            fn ($field) => "`$field` = :$field",
            Schema::fieldNames()
        ));

        $sql = 'UPDATE `' . Schema::TABLE . "` SET $assignments WHERE `" . Schema::PRIMARY_KEY . '` = :id';
        $this->db->prepare($sql)->execute($this->only($data) + ['id' => $id]);
    }

    /**
     * Delete a person by primary key.
     */
    public function delete(int $id): void
    {
        $sql = 'DELETE FROM `' . Schema::TABLE . '` WHERE `' . Schema::PRIMARY_KEY . '` = :id';
        $this->db->prepare($sql)->execute(['id' => $id]);
    }

    /**
     * Keep only the columns that belong to the Schema — a safety net so stray
     * form fields can never be written to the database.
     */
    private function only(array $data): array
    {
        return array_intersect_key($data, array_flip(Schema::fieldNames()));
    }
}
