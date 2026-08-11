<?php
/**
 * Form fields — generated from the Schema, so the Add and Edit modals share one
 * definition and neither repeats the field names.
 *
 * Expects two variables from the caller:
 *   $values      — current value per field (for re-filling after an error)
 *   $fieldErrors — validation message per field (may be empty)
 *
 * The HTML5 attributes (required, maxlength, type=email) come straight from the
 * Schema rules, giving instant in-browser validation that mirrors the server.
 */
$values      = $values      ?? [];
$fieldErrors = $fieldErrors ?? [];

foreach (Schema::FIELDS as $name => $field):
    $value = $values[$name] ?? '';
    $error = $fieldErrors[$name] ?? '';
?>
    <label class="block">
        <span class="mb-1 block font-mono text-xs uppercase tracking-widest text-slate-400"><?= e($field['label']) ?></span>
        <input
            type="<?= e($field['input']) ?>"
            name="<?= e($name) ?>"
            value="<?= e($value) ?>"
            <?= !empty($field['required']) ? 'required' : '' ?>
            <?= isset($field['max']) ? 'maxlength="' . (int) $field['max'] . '"' : '' ?>
            autocomplete="off"
            class="w-full rounded-lg border border-edge bg-ink px-3 py-2 text-slate-100 placeholder-slate-600 outline-none transition focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
        <span class="mt-1 block text-xs text-rose-400" data-error-for="<?= e($name) ?>"><?= e($error) ?></span>
    </label>
<?php endforeach; ?>
