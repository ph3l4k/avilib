<?php
/**
 * Autoloader para las clases del plugin Avilib.
 */
class Avilib_Autoloader {
    /**
     * Registra el autoloader.
     */
    public static function register() {
        spl_autoload_register(array(self::class, 'autoload'));
    }

    /**
     * Autoloader.
     *
     * @param string $class El nombre completo de la clase.
     */
    public static function autoload($class) {
        // Prefijo de las clases del plugin
        $prefix = 'Avilib_';

        // ¿La clase usa el prefijo?
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            return;
        }

        // Obtener el nombre relativo de la clase
        $relative_class = substr($class, $len);

        // Reemplazar el prefijo de la clase con el directorio base, reemplazar guiones bajos con guiones,
        // y añadir .php
        $file = AVILIB_PATH . str_replace('_', '-', strtolower($relative_class)) . '.php';

        // Si el archivo existe, requerirlo
        if (file_exists($file)) {
            require $file;
        }
    }
}

Avilib_Autoloader::register();