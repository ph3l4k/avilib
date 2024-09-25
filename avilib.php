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
define('AVILIB_PATH', plugin_dir_path(__FILE__));
define('AVILIB_URL', plugin_dir_url(__FILE__));

// Cargar archivos del plugin
require_once AVILIB_PATH . 'includes/class-avilib-loader.php';
require_once AVILIB_PATH . 'includes/class-avilib-i18n.php';
require_once AVILIB_PATH . 'includes/class-avilib-activator.php';
require_once AVILIB_PATH . 'includes/class-avilib-deactivator.php';
require_once AVILIB_PATH . 'includes/class-avilib.php';

// Iniciar el plugin
function run_avilib() {
    $plugin = new Avilib();
    $plugin->run();
}
run_avilib();