<?php
/**
 * Simple CSRF token helper.
 * Usage in a form:
 *   <?php echo csrf_field(); ?>
 * Usage at the top of the handler that processes POST:
 *   require_csrf();
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!function_exists('csrf_token')) {
    function csrf_token() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field() {
        $token = htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8');
        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }
}

if (!function_exists('require_csrf')) {
    function require_csrf() {
        $submitted = $_POST['csrf_token'] ?? '';
        if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $submitted)) {
            http_response_code(403);
            die('Security check failed. Please refresh the page and try again.');
        }
    }
}
