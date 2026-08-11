<?php
/**
 * =============================================================================
 * ConstantMVC — Server-side validator
 * =============================================================================
 *
 * Client-side validation (in the browser) is a convenience — it can be bypassed.
 * This validator is the AUTHORITATIVE check that runs on the server before
 * anything touches the database.
 *
 * It is driven entirely by the rules declared in `config/Schema.php`, so it
 * never repeats field names. Add a field to the Schema and it is validated
 * automatically — nothing to wire up here.
 */

final class Validator
{
    /**
     * Validate raw form input against the Schema.
     *
     * @param  array $input  Usually $_POST.
     * @return array{data: array<string,string>, errors: array<string,string>}
     *                       `data`   = trimmed, ready-to-store values.
     *                       `errors` = one message per field that failed (empty = valid).
     */
    public static function validate(array $input): array
    {
        $data   = [];
        $errors = [];

        foreach (Schema::FIELDS as $name => $rules) {
            // Normalise: always work with a trimmed string.
            $value = trim((string) ($input[$name] ?? ''));
            $data[$name] = $value;

            $label = $rules['label'] ?? $name;

            // Rule: required.
            if (!empty($rules['required']) && $value === '') {
                $errors[$name] = "{$label} is required.";
                continue; // No point checking further rules on an empty value.
            }

            // Rule: maximum length.
            if (isset($rules['max']) && mb_strlen($value) > $rules['max']) {
                $errors[$name] = "{$label} must be at most {$rules['max']} characters.";
                continue;
            }

            // Rule: email format — modern, built-in, far stronger than "contains @".
            if (($rules['input'] ?? '') === 'email' && $value !== ''
                && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$name] = "Please enter a valid {$label}.";
                continue;
            }
        }

        return ['data' => $data, 'errors' => $errors];
    }
}
