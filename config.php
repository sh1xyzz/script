<?php
declare(strict_types=1);

// Database settings. Update these values for your local MySQL/MariaDB installation.
const DB_HOST = '127.0.0.1';
const DB_PORT = 3307;
const DB_NAME = 'scriptovation';
const DB_USER = 'root';
const DB_PASS = ''; // Set your database password

const ADMIN_EMAIL = 'admin@scriptovation.local';
const ADMIN_PASSWORD_HASH = '$2y$12$PI6jWH3eNi2o9lVuRMNGfO1Z5dLkWb1TGWu7hsEi7hxTZ5Vq6and.'; // default: Admin123!
const ADMIN_SESSION_KEY = 'scriptovation_admin';
const CSRF_SESSION_KEY = 'scriptovation_csrf';
const APP_TITLE = 'Scriptovation';
