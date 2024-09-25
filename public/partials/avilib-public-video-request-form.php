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
        <label><?php _e('Categories:', 'avilib'); ?></label>
        <div class="categories-container">
            <?php
            global $wpdb;
            $categories = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}avilib_categories");
            foreach ($categories as $category) :
            ?>
                <div class="category-item">
                    <input type="checkbox" name="categories[]" id="category-<?php echo $category->id; ?>" value="<?php echo $category->id; ?>">
                    <label for="category-<?php echo $category->id; ?>"><?php echo esc_html($category->name); ?></label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="form-group">
        <input type="submit" name="avilib_submit" value="<?php _e('Submit', 'avilib'); ?>">
    </div>
</form>