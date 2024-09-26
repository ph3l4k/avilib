<?php
class Avilib_Activator {
    public static function activate() {
        self::create_tables();
    }

    private static function create_tables() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = array();

        $sql[] = "CREATE TABLE {$wpdb->prefix}avilib_video_requests (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            title text NOT NULL,
            url text NOT NULL,
            status varchar(10) DEFAULT 'pending' NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        $sql[] = "CREATE TABLE {$wpdb->prefix}avilib_accepted_videos (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            title text NOT NULL,
            url text NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        foreach ($sql as $query) {
            dbDelta($query);
        }
    }
}