<?php
// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}

function vrp_video_request_form() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['vrp_submit'])) {
        global $wpdb;
        $video_requests_table = $wpdb->prefix . 'video_requests';
        $video_request_categories_table = $wpdb->prefix . 'video_request_categories';
        
        $wpdb->insert(
            $video_requests_table,
            array(
                'title' => sanitize_text_field($_POST['title']),
                'url' => esc_url($_POST['url']),
                'status' => 'pending'
            )
        );
            
        echo '<p>' . __('Request submitted successfully!', 'avilib') . '</p>';
    }

    global $wpdb;
    $categories = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}video_categories");

    ob_start();
    ?>
    <form method="post" class="custom-form">
        <div class="form-group">
            <label for="title"><?php _e('Title:', 'avilib'); ?></label>
            <input type="text" name="title" id="title" required>
        </div>
        <div class="form-group">
            <label for="url"><?php _e('URL:', 'avilib'); ?></label>
            <input type="url" name="url" id="url" required>
        </div>
        <div class="form-group">
            <input type="submit" name="vrp_submit" value="<?php _e('Submit', 'avilib'); ?>">
        </div>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('video_request_form', 'vrp_video_request_form');
