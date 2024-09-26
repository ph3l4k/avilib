<?php
class Avilib_Admin {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, AVILIB_URL . 'admin/css/avilib-admin.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts($hook) {
        wp_enqueue_script($this->plugin_name, AVILIB_URL . 'admin/js/avilib-admin.js', array('jquery'), $this->version, false);
    
        // Cargar el script solo en la página de plugins
        if ($hook === 'plugins.php') {
            wp_enqueue_script('avilib-uninstall', AVILIB_URL . 'admin/js/avilib-uninstall.js', array('jquery'), $this->version, true);
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