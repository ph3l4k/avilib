<?php
class Avilib_Public {
    public function enqueue_styles() {
        wp_enqueue_style('avilib-public', AVILIB_URL . 'public/css/avilib-public.css', array(), AVILIB_VERSION, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script('avilib-public', AVILIB_URL . 'public/js/avilib-public.js', array('jquery'), AVILIB_VERSION, false);
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

    public static function convert_to_embed_url($url) {
        if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
            return 'https://www.youtube.com/embed/' . $id[1] . '?autoplay=1&controls=0';
        } elseif (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id)) {
            return 'https://www.youtube.com/embed/' . $id[1] . '?autoplay=1&controls=0';
        } elseif (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id)) {
            return 'https://www.youtube.com/embed/' . $id[1] . '?autoplay=1&controls=0';
        } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
            return 'https://www.youtube.com/embed/' . $id[1] . '?autoplay=1&controls=0';
        } elseif (preg_match('/vimeo\.com\/([^\&\?\/]+)/', $url, $id)) {
            return 'https://player.vimeo.com/video/' . $id[1] . '?autoplay=1&controls=0';
        }
        return $url;
    }

    public static function get_video_thumbnail($url) {
        if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
            preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
            $id = $matches[1];
            return 'https://img.youtube.com/vi/' . $id . '/0.jpg';
        } elseif (strpos($url, 'vimeo.com') !== false) {
            $id = substr(parse_url($url, PHP_URL_PATH), 1);
            $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$id.php"));
            return $hash[0]['thumbnail_large'];
        }
        return ''; // Retorna una imagen por defecto si no se encuentra una miniatura
    }
}