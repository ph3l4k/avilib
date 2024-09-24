<?php
// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Verificar y crear tablas si no existen
// Tabla de las categorias para los videos
function vrp_create_video_categories_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'video_categories';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name text NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Tabla de los videos solicitados
function vrp_create_video_requests_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'video_requests';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title text NOT NULL,
        url text NOT NULL,
        status varchar(10) DEFAULT 'pending' NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function vrp_create_video_request_categories_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'video_request_categories';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        video_request_id mediumint(9) NOT NULL,
        category_id mediumint(9) NOT NULL,
        PRIMARY KEY (id),
        UNIQUE KEY video_category (video_request_id, category_id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function vrp_create_accepted_videos_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'accepted_videos';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title text NOT NULL,
        url text NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function vrp_create_accepted_video_categories_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'accepted_video_categories';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        accepted_video_id mediumint(9) NOT NULL,
        category_id mediumint(9) NOT NULL,
        PRIMARY KEY (id),
        UNIQUE KEY accepted_video_category (accepted_video_id, category_id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function vrp_delete_category($category_id) {
    global $wpdb;
    // Eliminar la categoría de la tabla de categorías
    $wpdb->delete("{$wpdb->prefix}video_categories", array('id' => $category_id));
    // Eliminar las relaciones de la categoría en las tablas intermedias
    $wpdb->delete("{$wpdb->prefix}video_request_categories", array('category_id' => $category_id));
    $wpdb->delete("{$wpdb->prefix}accepted_video_categories", array('category_id' => $category_id));
}

function vrp_delete_video($video_id) {
    global $wpdb;
    // Eliminar el video de la tabla de videos aceptados
    $wpdb->delete("{$wpdb->prefix}accepted_videos", array('id' => $video_id));
    // Eliminar las relaciones del video en la tabla intermedia
    $wpdb->delete("{$wpdb->prefix}accepted_video_categories", array('accepted_video_id' => $video_id));
}

// Crear tablas en la activación del plugin
function vrp_create_tables() {
    vrp_create_video_categories_table();
    vrp_create_video_requests_table();
    vrp_create_video_request_categories_table();
    vrp_create_accepted_videos_table();
    vrp_create_accepted_video_categories_table();
}

register_activation_hook(__FILE__, 'vrp_create_tables');
?>
