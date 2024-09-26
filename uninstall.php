<?php
// Si WordPress no llama a este archivo, salir.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Cargar la clase Avilib_Deactivator
require_once plugin_dir_path(__FILE__) . 'includes/class-avilib-deactivator.php';

// Llamar al método de desinstalación
Avilib_Deactivator::uninstall();