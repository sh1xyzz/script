# Scriptovation — local run instructions

Recommended: run via XAMPP (Apache + PHP bundled with XAMPP has `pdo_mysql` enabled).

Quick start (XAMPP):

1. Start Apache and MySQL via XAMPP Control Panel.
2. Run `deploy_to_xampp.bat` from the project root to copy files to `C:\xampp\htdocs\script` and open the admin page.
3. Open `http://localhost/script/admin.php` and, if needed, run `setup-db.php` in your browser to create the `scriptovation` database and import schema.

Quick start (local PHP):

1. If you want to use the built-in PHP server, prefer the one bundled with XAMPP to ensure `pdo_mysql` is available.
2. Run `run-local.bat`.
3. If database is missing, open `http://localhost:8000/setup-db.php` (but only works if PHP has `pdo_mysql`).

Notes:

- `config.php` is already configured to connect to `127.0.0.1:3307` for your local XAMPP MariaDB.
- If CLI PHP lacks `pdo_mysql` you will see `could not find driver`. Enable `extension=pdo_mysql` in the `php.ini` used by your CLI.

# Scriptovation

Modern PHP project for the Skriptovacie jazyky semester task.

## Что реализовано

- OOP-подход: `Database`, `Auth`, репозитории и модели
- CRUD-операции для `tracks` (курсовые предложения)
- Создание заявок на курс через форму
- Админ-панель с авторизацией, обновлением статуса и удалением заявок
- MySQL / MariaDB хранилище
- Минималистичный дизайн, адаптивный интерфейс

## Установка

1. Создайте базу данных и таблицы из `db-schema.sql`.
2. Обновите `config.php` с вашими настройками MySQL.
3. Разместите проект на PHP 8+ и доступной базе данных.
4. Откройте `index.php` в браузере.
5. Войдите в `admin.php` с логином:
   - Email: `admin@scriptovation.local`
   - Password: `Admin123!`

## База данных

По умолчанию используется база `scriptovation`.

## Примечание

Проект реализован на "чистом" PHP без фреймворков и CMS.
