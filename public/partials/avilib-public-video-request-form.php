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
        echo '<p class="avilib-error">' . __('Esta URL de vídeo ya existe en nuestro sistema.', 'avilib') . '</p>';
    } else {
        $wpdb->insert(
            "{$wpdb->prefix}avilib_video_requests",
            array('title' => $title, 'url' => $url, 'status' => 'pending')
        );

        echo '<p class="avilib-success">' . __('¡Solicitud de vídeo enviada correctamente!', 'avilib') . '</p>';
    }
}
?>

<form method="post" class="avilib-form" id="avilib-video-form">
    <div class="form-group">
        <label for="title"><?php _e('Título:', 'avilib'); ?></label>
        <input type="text" name="title" id="title" required>
    </div>
    <div class="form-group">
        <label for="url"><?php _e('URL:', 'avilib'); ?></label>
        <input type="url" name="url" id="url" required>
    </div>
    <div class="form-group">
        <input type="submit" name="avilib_submit" value="<?php _e('Enviar', 'avilib'); ?>">
    </div>
</form>