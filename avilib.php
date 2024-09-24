<?php
/*
Plugin Name: Avilib
Description: Video library management
Version: 1.0
Author: WLDAGENCY
Text Domain: avilib
Domain Path: /languages
*/

// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Cargar archivos de traducción
function vrp_load_textdomain() {
    load_plugin_textdomain('avilib', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'vrp_load_textdomain');

// Incluir archivos de CSS y JS
function vrp_register_styles_and_scripts() {
    $plugin_url = plugins_url('', __FILE__);

    // Registrar estilos
    wp_register_style('vrp-styles', $plugin_url . '/css/styles.css', array(), filemtime(plugin_dir_path(__FILE__) . 'css/styles.css'));

    // Registrar scripts
    wp_register_script('vrp-form-scripts', $plugin_url . '/js/form.js', array('jquery'), filemtime(plugin_dir_path(__FILE__) . 'js/form.js'), true);
    wp_register_script('vrp-video-list-scripts', $plugin_url . '/js/video-list.js', array('jquery'), filemtime(plugin_dir_path(__FILE__) . 'js/video-list.js'), true);
}
add_action('wp_enqueue_scripts', 'vrp_register_styles_and_scripts');

// Función para encolar estilos y scripts en el frontend
function vrp_enqueue_frontend_assets() {
    if (is_page('subir-video-medico')) {
        wp_enqueue_style('vrp-styles');
        wp_enqueue_script('vrp-form-scripts');
    } elseif (is_page('biblioteca-de-videos-medicos')) {
        wp_enqueue_style('vrp-styles');
        wp_enqueue_script('vrp-video-list-scripts');
    }
}
add_action('wp_enqueue_scripts', 'vrp_enqueue_frontend_assets');

// Incluir archivos necesarios
// Database
require_once plugin_dir_path(__FILE__) . 'includes/database/db.php';

// Backend
require_once plugin_dir_path(__FILE__) . 'includes/backend/admin.php';
require_once plugin_dir_path(__FILE__) . 'includes/backend/categories.php';
require_once plugin_dir_path(__FILE__) . 'includes/backend/manage.php';

// Frontend
require_once plugin_dir_path(__FILE__) . 'includes/frontend/form.php';
require_once plugin_dir_path(__FILE__) . 'includes/frontend/video-list.php';
require_once plugin_dir_path(__FILE__) . 'includes/frontend/load.php';

// Crear tablas en la activación del plugin
register_activation_hook(__FILE__, 'vrp_create_tables');
