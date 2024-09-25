<?php
class Avilib_Public {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, AVILIB_URL . 'public/css/avilib-public.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, AVILIB_URL . 'public/js/avilib-public.js', array('jquery'), $this->version, false);
    }

    public function register_shortcodes() {
        add_shortcode('video_request_form', array($this, 'render_video_request_form'));
        add_shortcode('accepted_videos', array($this, 'render_accepted_videos'));
    }

    public function render_video_request_form() {
        ob_start();
        require_once AVILIB_PATH . 'public/partials/avilib-public-video-request-form.php';
        return ob_get_clean();
    }

    public function render_accepted_videos() {
        ob_start();
        require_once AVILIB_PATH . 'public/partials/avilib-public-accepted-videos.php';
        return ob_get_clean();
    }
}