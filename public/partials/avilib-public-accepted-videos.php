<div class="avilib-video-list">
    <div class="avilib-search-bar">
        <input type="text" id="avilib-search" placeholder="<?php _e('Search videos...', 'avilib'); ?>">
    </div>
    <div class="avilib-category-filter">
        <?php
        global $wpdb;
        $categories = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}avilib_categories");
        foreach ($categories as $category) :
        ?>
            <label>
                <input type="checkbox" class="avilib-category-filter" value="<?php echo $category->id; ?>">
                <?php echo esc_html($category->name); ?>
            </label>
        <?php endforeach; ?>
    </div>
    <div class="avilib-video-grid">
        <?php
        $videos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}avilib_accepted_videos");
        foreach ($videos as $video) :
            $video_categories = $wpdb->get_col($wpdb->prepare(
                "SELECT c.name FROM {$wpdb->prefix}avilib_categories c
                 JOIN {$wpdb->prefix}avilib_accepted_video_categories vc ON c.id = vc.category_id
                 WHERE vc.accepted_video_id = %d",
                $video->id
            ));
        ?>
            <div class="avilib-video-item" data-title="<?php echo esc_attr($video->title); ?>" data-categories="<?php echo esc_attr(implode(',', $video_categories)); ?>">
                <h3><?php echo esc_html($video->title); ?></h3>
                <div class="avilib-video-wrapper">
                    <iframe src="<?php echo esc_url(Avilib_Public::convert_to_embed_url($video->url)); ?>" frameborder="0" allowfullscreen></iframe>
                </div>
                <p class="avilib-video-categories"><?php echo esc_html(implode(', ', $video_categories)); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>