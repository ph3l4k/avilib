<?php
class Avilib_Deactivator {
    public static function deactivate() {
        // No es necesario realizar acciones aquí, ya que el aviso se mostrará antes de la desinstalación
    }

    public static function uninstall() {
        global $wpdb;

        // Eliminar las tablas de la base de datos
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}avilib_video_requests");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}avilib_accepted_videos");

        // Eliminar las opciones del plugin
        delete_option('avilib_version');
        
        // Eliminar cualquier transient que el plugin pueda haber creado
        delete_transient('avilib_transient');
    }
}