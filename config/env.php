<?php
/**
 * Minimal .env loader — no Composer dependency required.
 * Loads KEY=VALUE pairs from a .env file in the project root into getenv()/$_ENV.
 * Safe to include multiple times.
 */

if (!function_exists('load_env')) {
    function load_env($path) {
        static $loaded = false;
        if ($loaded) return;

        if (!file_exists($path)) {
            // Fail loudly in a controlled way — don't silently run with blank creds.
            die("Configuration error: .env file not found at $path. Copy .env.example to .env and fill in your values.");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '#') === 0) continue;
            if (strpos($line, '=') === false) continue;

            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            // Strip surrounding quotes if present
            if (strlen($value) >= 2 && (
                ($value[0] === '"' && $value[strlen($value)-1] === '"') ||
                ($value[0] === "'" && $value[strlen($value)-1] === "'")
            )) {
                $value = substr($value, 1, -1);
            }

            putenv("$key=$value");
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
        $loaded = true;
    }
}

if (!function_exists('env')) {
    function env($key, $default = null) {
        $value = getenv($key);
        if ($value === false) return $default;
        return $value;
    }
}
