<div class="avilib-video-list">
    <div class="avilib-search-bar">
        <input type="text" id="avilib-search" placeholder="<?php _e('Search videos...', 'avilib'); ?>">
    </div>
    <div class="avilib-video-grid">
        <?php
        global $wpdb;
        $videos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}avilib_accepted_videos");
        foreach ($videos as $video) :
        ?>
            <div class="avilib-video-item" data-title="<?php echo esc_attr($video->title); ?>">
                <h3><?php echo esc_html($video->title); ?></h3>
                <div class="avilib-video-wrapper">
                    <iframe src="<?php echo esc_url(Avilib_Public::convert_to_embed_url($video->url)); ?>" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>