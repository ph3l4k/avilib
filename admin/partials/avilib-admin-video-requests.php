<?php
global $wpdb;

if (isset($_POST['accept'])) {
    $id = intval($_POST['id']);
    $request = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}avilib_video_requests WHERE id = %d", $id));
    if ($request) {
        $wpdb->insert(
            $wpdb->prefix . 'avilib_accepted_videos',
            array('title' => $request->title, 'url' => $request->url)
        );
        $accepted_id = $wpdb->insert_id;

        $wpdb->query($wpdb->prepare(
            "INSERT INTO {$wpdb->prefix}avilib_accepted_video_categories (accepted_video_id, category_id)
             SELECT %d, category_id FROM {$wpdb->prefix}avilib_video_request_categories WHERE video_request_id = %d",
            $accepted_id, $id
        ));

        $wpdb->delete($wpdb->prefix . 'avilib_video_requests', array('id' => $id));
        $wpdb->delete($wpdb->prefix . 'avilib_video_request_categories', array('video_request_id' => $id));
    }
} elseif (isset($_POST['delete'])) {
    $id = intval($_POST['id']);
    $wpdb->delete($wpdb->prefix . 'avilib_video_requests', array('id' => $id));
    $wpdb->delete($wpdb->prefix . 'avilib_video_request_categories', array('video_request_id' => $id));
}

$requests = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}avilib_video_requests ORDER BY created_at DESC");
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <?php if (empty($requests)) : ?>
        <p><?php _e('No video requests at the moment.', 'avilib'); ?></p>
    <?php else : ?>
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
                <?php foreach ($requests as $request) :
                    $categories = $wpdb->get_col($wpdb->prepare(
                        "SELECT c.name FROM {$wpdb->prefix}avilib_categories c
                         JOIN {$wpdb->prefix}avilib_video_request_categories vc ON c.id = vc.category_id
                         WHERE vc.video_request_id = %d",
                        $request->id
                    ));
                ?>
                    <tr>
                        <td><?php echo esc_html($request->title); ?></td>
                        <td><?php echo esc_url($request->url); ?></td>
                        <td><?php echo esc_html(implode(', ', $categories)); ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo esc_attr($request->id); ?>">
                                <input type="submit" name="accept" value="<?php _e('Accept', 'avilib'); ?>" class="button button-primary">
                                <input type="submit" name="delete" value="<?php _e('Delete', 'avilib'); ?>" class="button button-secondary">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>