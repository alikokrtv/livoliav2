<?php
/**
 * Vercel Entry Point / Router
 * This script routes Vercel serverless requests to the root PHP files.
 */

// Change working directory to project root so includes work correctly
chdir(__DIR__ . '/..');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove leading slash for local file matching
$path = ltrim($uri, '/');

// Handle root
if ($uri === '/' || $uri === '') {
    require 'index.php';
    exit;
}

// Handle Admin
if (strpos($uri, '/admin') === 0) {
    // If it's just /admin or /admin/, load admin/index.php
    if ($uri === '/admin' || $uri === '/admin/') {
        require 'admin/index.php';
    } else {
        // Otherwise, the admin/index.php handles its own routing
        require 'admin/index.php';
    }
    exit;
}

// Handle other .php files (e.g., blog.php, contact.php)
if (file_exists($path) && is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'php') {
    require $path;
    exit;
}

// Handle pretty URLs (e.g., /blog -> blog.php)
if (file_exists($path . '.php')) {
    require $path . '.php';
    exit;
}

// Fallback to index.php
require 'index.php';
