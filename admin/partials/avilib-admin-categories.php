<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form method="post" action="">
        <table class="form-table">
            <tr>
                <th scope="row"><label for="category_name"><?php _e('New Category', 'avilib'); ?></label></th>
                <td>
                    <input type="text" name="category_name" id="category_name" class="regular-text" required>
                </td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="add_category" class="button button-primary" value="<?php _e('Add Category', 'avilib'); ?>">
        </p>
    </form>

    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th><?php _e('Category Name', 'avilib'); ?></th>
                <th><?php _e('Actions', 'avilib'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            global $wpdb;
            $categories = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}avilib_categories");
            foreach ($categories as $category) :
                $video_count = $wpdb->get_var($wpdb->prepare(
                    "SELECT COUNT(*) FROM {$wpdb->prefix}avilib_accepted_video_categories WHERE category_id = %d",
                    $category->id
                ));
            ?>
                <tr>
                    <td><?php echo esc_html($category->name); ?> (<?php echo $video_count; ?> <?php _e('videos', 'avilib'); ?>)</td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="category_id" value="<?php echo esc_attr($category->id); ?>">
                            <input type="submit" name="delete_category" value="<?php _e('Delete', 'avilib'); ?>" class="button button-secondary">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>