<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th><?php _e('Title', 'avilib'); ?></th>
                <th><?php _e('URL', 'avilib'); ?></th>
                <th><?php _e('Categories', 'avilib'); ?></th>
                <th><?php _e('Actions', 'avilib'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            global $wpdb;
            $videos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}avilib_accepted_videos ORDER BY created_at DESC");
            foreach ($videos as $video) :
                $categories = $wpdb->get_col($wpdb->prepare(
                    "SELECT c.name FROM {$wpdb->prefix}avi
lib_categories c
                     JOIN {$wpdb->prefix}avilib_accepted_video_categories vc ON c.id = vc.category_id
                     WHERE vc.accepted_video_id = %d",
                    $video->id
                ));
            ?>
                <tr>
                    <td><?php echo esc_html($video->title); ?></td>
                    <td><?php echo esc_url($video->url); ?></td>
                    <td><?php echo esc_html(implode(', ', $categories)); ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo esc_attr($video->id); ?>">
                            <input type="submit" name="delete" value="<?php _e('Delete', 'avilib'); ?>" class="button button-secondary">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>