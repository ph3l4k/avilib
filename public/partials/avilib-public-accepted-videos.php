<div class="avilib-video-list">
    <div class="avilib-search-bar">
        <div class="avilib-search-input-wrapper">
            <input type="text" id="avilib-search" placeholder="<?php _e('Search videos...', 'avilib'); ?>">
            <svg class="avilib-search-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </div>
    </div>
    <div class="avilib-video-grid">
        <?php
        global $wpdb;
        $videos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}avilib_accepted_videos ORDER BY created_at DESC");
        foreach ($videos as $video) :
            $thumbnail = Avilib_Public::get_video_thumbnail($video->url);
        ?>
            <div class="avilib-video-item" data-title="<?php echo esc_attr($video->title); ?>">
                <h3><?php echo esc_html($video->title); ?></h3>
                <div class="avilib-video-thumbnail" data-video-url="<?php echo esc_url(Avilib_Public::convert_to_embed_url($video->url)); ?>">
                    <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($video->title); ?>">
                    <div class="avilib-play-button"></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="avilib-video-modal" class="avilib-modal">
    <div class="avilib-modal-content">
        <span class="avilib-close">&times;</span>
        <div id="avilib-modal-video-container"></div>
    </div>
</div>