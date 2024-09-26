<?php
/*
Plugin Name: Avilib - Video Library Manager
Description: A comprehensive video library management system for WordPress
Version: 2.0
Author: WLDAGENCY
Text Domain: avilib
Domain Path: /languages
*/

// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Definir constantes
define('AVILIB_VERSION', '2.0');
define('AVILIB_PATH', plugin_dir_path(__FILE__));
define('AVILIB_URL', plugin_dir_url(__FILE__));

// Cargar el autoloader
require_once AVILIB_PATH . 'includes/class-avilib-autoloader.php';

/**
 * Código que se ejecuta durante la activación del plugin.
 */
function activate_avilib() {
    Avilib_Activator::activate();
}

/**
 * Código que se ejecuta durante la desactivación del plugin.
 */
function deactivate_avilib() {
    Avilib_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_avilib');
register_deactivation_hook(__FILE__, 'deactivate_avilib');

/**
 * Inicializa el plugin.
 */
function run_avilib() {
    $plugin = new Avilib();
    $plugin->run();
}

/**
 * Función para verificar y actualizar la base de datos si es necesario.
 */
function avilib_update_db_check() {
    if (get_site_option('avilib_db_version') != AVILIB_VERSION) {
        Avilib_Activator::activate();
        update_site_option('avilib_db_version', AVILIB_VERSION);
    }
}

// Hooks
add_action('plugins_loaded', 'avilib_update_db_check');
add_action('plugins_loaded', 'run_avilib');