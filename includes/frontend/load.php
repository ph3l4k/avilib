<?php
// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Registrar shortcodes
add_action('init', 'vrp_register_shortcodes');
function vrp_register_shortcodes() {
    add_shortcode('video_request_form', 'vrp_video_request_form');
    add_shortcode('accepted_videos', 'vrp_accepted_videos');
}
?>