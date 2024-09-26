<?php
class Avilib_Autoloader {
    public static function register() {
        spl_autoload_register(array(self::class, 'autoload'));
    }

    public static function autoload($class) {
        $prefix = 'Avilib_';
        $base_dir = AVILIB_PATH . 'includes/';

        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            return;
        }

        $relative_class = substr($class, $len);
        $file = $base_dir . 'class-' . str_replace('_', '-', strtolower($relative_class)) . '.php';

        if (file_exists($file)) {
            require $file;
        }
    }
}

Avilib_Autoloader::register();