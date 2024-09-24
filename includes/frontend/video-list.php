<?php
// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}

function vrp_accepted_videos() {
    global $wpdb;
    $videos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}accepted_videos");

    ob_start();
    ?>
    <div id="video-list" class="video-grid">
        <?php if ($videos): ?>
            <?php foreach ($videos as $video): ?>
                <?php 
                $video_categories = $wpdb->get_results($wpdb->prepare(
                    "SELECT vc.name 
                     FROM {$wpdb->prefix}accepted_video_categories avc 
                     JOIN {$wpdb->prefix}video_categories vc ON avc.category_id = vc.id 
                     WHERE avc.accepted_video_id = %d",
                    $video->id
                ));
                $category_names = wp_list_pluck($video_categories, 'name');
                ?>
                <div class="video-item" data-title="<?php echo esc_attr($video->title); ?>" data-categories="<?php echo esc_attr(implode(',', $category_names)); ?>">
                    <h3><?php echo esc_html($video->title); ?></h3>
                    <iframe src="<?php echo esc_url(convert_to_embed_url($video->url)); ?>" frameborder="0" allowfullscreen></iframe>
                    <p><?php echo esc_html(implode(', ', $category_names)); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p><?php _e('No videos found.', 'avilib'); ?></p>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}
?>
