<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['avilib_submit'])) {
    global $wpdb;
    $title = sanitize_text_field($_POST['title']);
    $url = esc_url_raw($_POST['url']);

    // Verificar si la URL ya existe
    $existing_video = $wpdb->get_var($wpdb->prepare(
        "SELECT id FROM {$wpdb->prefix}avilib_video_requests WHERE url = %s
         UNION
         SELECT id FROM {$wpdb->prefix}avilib_accepted_videos WHERE url = %s",
        $url, $url
    ));

    if ($existing_video) {
        echo '<p class="avilib-error">' . __('This video URL already exists in our system.', 'avilib') . '</p>';
    } else {
        $wpdb->insert(
            "{$wpdb->prefix}avilib_video_requests",
            array('title' => $title, 'url' => $url, 'status' => 'pending')
        );

        echo '<p class="avilib-success">' . __('Video request submitted successfully!', 'avilib') . '</p>';
    }
}
?>

<form method="post" class="avilib-form">
    <div class="form-group">
        <label for="title"><?php _e('Title:', 'avilib'); ?></label>
        <input type="text" name="title" id="title" required>
    </div>
    <div class="form-group">
        <label for="url"><?php _e('Video URL:', 'avilib'); ?></label>
        <input type="url" name="url" id="url" required>
    </div>
    <div class="form-group">
        <input type="submit" name="avilib_submit" value="<?php _e('Submit', 'avilib'); ?>">
    </div>
</form>