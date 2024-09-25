<?php
class Avilib_Activator {
    public static function activate() {
        self::create_tables();
    }

    private static function create_tables() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = array();

        $sql[] = "CREATE TABLE {$wpdb->prefix}avilib_categories (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name text NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        $sql[] = "CREATE TABLE {$wpdb->prefix}avilib_video_requests (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            title text NOT NULL,
            url text NOT NULL,
            status varchar(10) DEFAULT 'pending' NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        $sql[] = "CREATE TABLE {$wpdb->prefix}avilib_video_request_categories (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            video_request_id mediumint(9) NOT NULL,
            category_id mediumint(9) NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY video_category (video_request_id, category_id)
        ) $charset_collate;";

        $sql[] = "CREATE TABLE {$wpdb->prefix}avilib_accepted_videos (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            title text NOT NULL,
            url text NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        $sql[] = "CREATE TABLE {$wpdb->prefix}avilib_accepted_video_categories (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            accepted_video_id mediumint(9) NOT NULL,
            category_id mediumint(9) NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY accepted_video_category (accepted_video_id, category_id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        foreach ($sql as $query) {
            dbDelta($query);
        }
    }
}