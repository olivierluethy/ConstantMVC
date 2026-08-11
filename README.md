<p align="center">
  <img src="assets/logo.svg" alt="ConstantMVC" width="72" height="72">
</p>

<h1 align="center">ConstantMVC</h1>

<p align="center">
  A tiny PHP MVC framework with Add / Edit / Delete built in — so you can start a
  database-backed website in minutes, and learn how MVC fits together while you do.
</p>

---

## Table of Contents

1. [About the project](#about-the-project)
2. [Core idea: one single source of truth](#core-idea-one-single-source-of-truth)
3. [How a request flows (the MVC tour)](#how-a-request-flows-the-mvc-tour)
4. [Installation](#installation)
5. [Using the app](#using-the-app)
6. [How to extend it for your own project](#how-to-extend-it-for-your-own-project)
7. [Project structure](#project-structure)

---

## About the project

This framework was born out of a PHP & MVC course. Every new project started the
same way: rebuilding the same scaffolding from scratch — routing, a database
connection, a table with add/edit/delete — before any real work could begin. That
was slow and repetitive.

ConstantMVC is the answer: **copy it, point it at a database, and start
building.** The add/edit/delete system is already wired up. It doubles as a
teaching scaffold — the code is written to be read, so a newcomer can open it and
see exactly how the Model, View and Controller pieces connect.

## Core idea: one single source of truth

The framework has one rule above all others: **every piece of information is
defined in exactly one place.**

| What | Defined once in | Used everywhere via |
| --- | --- | --- |
| Database connection (host, name, user, password) | `config/config.php` | `core/Database.php` |
| Table name, columns, validation rules | `config/Schema.php` | model, views, validator, installer |

So renaming a column is a **one-line change** in `config/Schema.php`. Run
`php bin/setup.php` to apply it to the database, and the model's SQL, the table
headers, the form inputs and the validation all update themselves — because they
all read the same definition. Nothing to hunt down, nothing left out of sync.

## How a request flows (the MVC tour)

```
Browser
   │  every URL is rewritten by .htaccess to →
index.php ............. the single entry point; boots the app, defines routes
   │
core/Router.php ....... matches the URL to a "Controller@method"
   │
app/Controllers/ ...... the Controller: reads input, validates, calls the model
   │
app/Models/Person.php . the Model: the only place that talks to the database,
   │                     building its SQL from config/Schema.php
core/Database.php ..... the single shared PDO connection
   │
app/Views/ ............ the View: renders HTML (Tailwind), never touches the DB
```

Every file on that path carries comments explaining its job — follow the flow in
order and you have read the whole framework.

## Installation

You need **PHP 8.1+** and **MySQL or MariaDB**. The easiest way to get both on any
operating system is [XAMPP](https://www.apachefriends.org/) (or MAMP / a native
install). The steps below are identical on macOS, Windows and Ubuntu.

### 1. Get the code

```sh
git clone <your-repository-url> constantmvc
cd constantmvc
```

### 2. Configure your database

Open `config/config.php` and set your database credentials. The defaults match a
fresh XAMPP install (user `root`, empty password), so you often don't need to
change anything to get started.

### 3. Create the database and table

From the project folder, run the installer once. It reads `config/Schema.php` and
creates the database and table for you:

```sh
php bin/setup.php
```

> Prefer to run the SQL yourself (e.g. in phpMyAdmin)? Print it instead:
> `php bin/setup.php --sql`

### 4. Run the app

Use PHP's built-in web server — no Apache configuration required, and it works the
same on every OS:

```sh
php -S localhost:8000
```

Then open **http://localhost:8000** in your browser.

<details>
<summary>Alternative: running under Apache / XAMPP</summary>

Place the project in your web root (`htdocs`) and open
`http://localhost/constantmvc/`. The framework detects the sub-folder
automatically — there are no hardcoded paths or IP addresses anywhere.
</details>

## Using the app

The home page lists all people and is your full CRUD console:

- **Add person** opens a modal form.
- **Edit** and **Delete** on each row open their own modals.

There are no separate pages or redirects to fill in a form — everything happens in
place. Input is validated in the browser (instant feedback) and again on the
server (the authoritative check) before it reaches the database.

## How to extend it for your own project

Want to store *products* instead of *people*? You mostly edit one file.

1. **Change the schema** — edit `config/Schema.php`: set `TABLE`, and list your
   fields (label, input type, `required`, `max`, `unique`) in `FIELDS`.
2. **Apply it** — run `php bin/setup.php` to (re)create the table.
3. **Add another entity** — copy `app/Models/Person.php` and
   `app/Controllers/PersonController.php`, register the new routes in `index.php`,
   and add a view under `app/Views/`.

The model, forms, table and validation all follow the schema automatically, so
step 1 usually covers a rename or a field change end to end.

## Project structure

```
constantmvc/
├── index.php               Front controller + route table
├── .htaccess               Sends every request to index.php
├── config/
│   ├── config.php          ▸ SINGLE SOURCE OF TRUTH: database connection
│   └── Schema.php          ▸ SINGLE SOURCE OF TRUTH: table, columns, rules
├── core/
│   ├── bootstrap.php       Loads everything in order
│   ├── Router.php          URL → Controller@method
│   ├── Database.php        The one shared PDO connection
│   ├── Validator.php       Server-side validation from the Schema
│   └── helpers.php         e(), view(), redirect(), flash(), base_url() …
├── app/
│   ├── Controllers/        Coordinates a request (no SQL, no HTML)
│   ├── Models/             Talks to the database (no HTML)
│   └── Views/              Renders HTML with Tailwind (no SQL)
├── public/js/app.js        Modal behaviour (no build step)
├── assets/logo.svg         Original ConstantMVC logo
└── bin/setup.php           Creates the database from the Schema
```

## Styling

All styling is **Tailwind CSS** via the Play CDN — there is no build step, nothing
to `npm install`, and it works identically on every OS. The framework is
**dark-mode only**. This keeps the scaffold beginner-friendly: open a view and the
styles are right there in the markup, with no separate stylesheet to trace. (For a
production app with heavy traffic you may later swap the CDN for the Tailwind CLI
build; the markup stays the same.)
