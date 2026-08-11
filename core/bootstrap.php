<?php
/**
 * =============================================================================
 * ConstantMVC — Bootstrap
 * =============================================================================
 *
 * The very first thing index.php loads. It wires the framework together by
 * pulling in the pieces every request needs, in dependency order. Think of it
 * as the "on switch": after this file runs, the app is ready to route a request.
 */

// Sessions power flash messages (success notices, validation errors after a
// redirect). Start it once here so controllers and views can rely on it.
session_start();

// --- The single sources of truth ------------------------------------------
require __DIR__ . '/../config/Schema.php';     // table + columns + rules (source of truth #2)
//    config/config.php (connection, source of truth #1) is read by Database.php on demand.

// --- The core building blocks ---------------------------------------------
require __DIR__ . '/helpers.php';    // e(), view(), redirect(), flash(), ...
require __DIR__ . '/Database.php';   // the one PDO connection
require __DIR__ . '/Validator.php';  // server-side validation from the Schema
require __DIR__ . '/Router.php';     // maps URLs to controllers

// --- The application models -----------------------------------------------
require __DIR__ . '/../app/Models/Person.php';  // the demo CRUD entity
