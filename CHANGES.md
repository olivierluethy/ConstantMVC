# CONSTANT Framework — Refactor & Modernization Report

This document summarizes the overhaul of the CONSTANT Framework in plain language:
**what changed, why it was changed, and why it matters** for the framework's two
goals — letting a developer start a database-backed app fast, and letting a
newcomer learn PHP MVC just by reading the code.

---

## 1. Redundancy removed — one single source of truth

**The problem.** The most important flaw. Database details were scattered across
the project. The connection existed in **four** different files, and even
disagreed with itself (one file pointed at a database called `framework`, another
at `colley`). Table and column names were hardcoded in the model, the controller
and the views. Renaming one thing meant editing many files and hoping none were
missed.

**What changed.**
- The database **connection** is now defined in exactly one file: `config/config.php`.
- The **table, columns and validation rules** are now defined in exactly one file:
  `config/Schema.php`.
- The model builds its SQL, the views build their forms and table, the validator
  builds its checks, and the installer builds the real database table — all by
  reading those two files. No name is ever typed twice.

**Why it matters.** Renaming a column is now a **one-line edit** followed by
`php bin/setup.php`. Everything downstream updates itself. This is the core promise
of the framework — change one thing in one place — and it is now actually true and
easy to demonstrate.

## 2. Performance

**What changed.**
- **One database connection per request instead of several.** The old code opened
  a new connection in the controller *and* another in the model, on every action —
  and had a third, broken connection helper. There is now a single shared
  connection (`core/Database.php`).
- Removed duplicated work such as counting rows with a manual loop and re-reading
  form data multiple times.

**Why it matters.** Fewer connections and less repeated work mean faster page
loads, and a cleaner example for learners of how a connection should be managed.

## 3. Validation — modernized and consistent

**The problem.** Validation was minimal and mixed into the model. The email check
only tested whether the text contained an `@` sign, which lets clearly invalid
addresses through.

**What changed.**
- Validation moved into a dedicated `core/Validator.php`, driven by the rules in
  `config/Schema.php` (required, maximum length, valid email).
- Email is now checked with PHP's built-in validator instead of a naive `@` test.
- The browser does a fast first check (using standard HTML5 rules generated from
  the schema); the **server always has the final say** before saving.

**Why it matters.** Data going into the database is trustworthy, the rules live in
one place, and the code models current best practice for someone learning from it.

## 4. Styling — SASS/CSS replaced with Tailwind CSS

**What changed.**
- Removed all SASS and CSS files (`style.scss`, `style.css`, the source map).
- Re-implemented the entire look with **Tailwind CSS utility classes** written
  directly in the markup, loaded via the Tailwind **Play CDN** (no build step,
  nothing to install, identical on macOS/Windows/Ubuntu).
- Applied the house style: **dark mode only**, and **modal dialogs** for Add, Edit
  and Delete instead of separate pages and redirects.

**Why it matters.** A beginner opens a view and sees exactly how it is styled,
with no separate stylesheet to trace. The zero-install setup keeps the framework
fast to start, and the in-place modals make the CRUD flow feel modern and quick.

## 5. New original logo

**What changed.** The old logo was a downloaded image (`framework.png` / a generic
favicon). It has been replaced with an **original, self-contained SVG**
(`assets/logo.svg`): an open "C" crossed by a horizontal "constant line" — a nod
to the framework's single-source-of-truth idea. It is sharp at any size and doubles
as the browser tab icon.

**Why it matters.** The framework now has its own identity, and a scalable vector
asset with no external dependency.

## 6. README & installation guide

**What changed.**
- Rewrote the README to explain what the framework is, its origin story, and how a
  request flows through the MVC layers.
- Added a **cross-platform installation guide** that works the same on macOS,
  Windows and Ubuntu, using PHP's built-in web server.
- **Removed every hardcoded IP address** (the old README and code pointed at a
  specific machine like `192.168.100.57` and `http://localhost/Constant_Framework/`).
  The app now detects where it is installed automatically.
- Added a "how to extend it" section for adapting the scaffold to a new project.

**Why it matters.** Anyone can clone and run the framework on any OS without
editing paths, and can see how to make it their own.

## 7. Bugs fixed

Each of these was found during the refactor and corrected:

- **Broken connection helper.** The `db()` helper referenced a variable that
  wasn't in scope and never returned the connection — it could not work at all.
- **Conflicting/dead database config.** A leftover file connected to a different,
  non-existent database (`colley`) using a different database library.
- **SQL in the wrong layer.** The controller ran a raw database query directly,
  breaking the MVC separation. All database access now lives in the model.
- **Unsafe output (XSS risk).** Data was printed to the page without escaping.
  All output is now escaped.
- **Fragile data handling.** The edit form referenced columns by numeric position,
  which breaks the moment columns are reordered. It now uses names.
- **Broken form attribute.** Inputs used `require` instead of the correct
  `required`, so required-field validation never triggered in the browser.
- **Hardcoded redirect address.** After saving, the app redirected to a fixed
  `http://localhost/Constant_Framework/` URL that only worked on one setup.
- **Incomplete, dead pages removed.** Half-finished login/register/logout pages
  referenced routes, a database table and a stylesheet that don't exist. They were
  removed to keep the scaffold clean and working. (Authentication can be added
  later as a proper, separate feature.)
- **External icon dependency removed.** A broken third-party icon script was
  dropped.

**Why it matters.** The scaffold now runs correctly out of the box and doesn't
teach bad habits by example.

---

## Summary

The framework is now what it was always meant to be: **change one thing in one
place, and start fast.** It is safer, faster, consistently styled, honestly
documented, and written to be read. A colleague can learn PHP MVC from it in an
afternoon, and reuse it for a real project the same day.
