<?php
class Avilib_Admin {
    public function enqueue_styles($hook) {
        wp_enqueue_style('avilib-admin', AVILIB_URL . 'admin/css/avilib-admin.css', array(), AVILIB_VERSION, 'all');
    }

    public function enqueue_scripts($hook) {
        wp_enqueue_script('avilib-admin', AVILIB_URL . 'admin/js/avilib-admin.js', array('jquery'), AVILIB_VERSION, false);

        if ($hook === 'plugins.php') {
            wp_enqueue_script('avilib-uninstall', AVILIB_URL . 'admin/js/avilib-uninstall.js', array('jquery'), AVILIB_VERSION, true);
        }
    }

    public function add_admin_menu() {
        add_menu_page(
            __('Avilib Video Library', 'avilib'),
            __('Avilib', 'avilib'),
            'manage_options',
            'avilib',
            array($this, 'display_video_requests_page'),
            'dashicons-video-alt3'
        );
        add_submenu_page(
            'avilib',
            __('Video Requests', 'avilib'),
            __('Video Requests', 'avilib'),
            'manage_options',
            'avilib',
            array($this, 'display_video_requests_page')
        );
        add_submenu_page(
            'avilib',
            __('Accepted Videos', 'avilib'),
            __('Accepted Videos', 'avilib'),
            'manage_options',
            'avilib-accepted',
            array($this, 'display_accepted_videos_page')
        );
    }

    public function display_video_requests_page() {
        require_once AVILIB_PATH . 'admin/partials/avilib-admin-video-requests.php';
    }

    public function display_accepted_videos_page() {
        require_once AVILIB_PATH . 'admin/partials/avilib-admin-accepted-videos.php';
    }
}