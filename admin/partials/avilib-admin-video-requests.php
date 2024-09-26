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

        $wpdb->delete($wpdb->prefix . 'avilib_video_requests', array('id' => $id));
    }
} elseif (isset($_POST['delete'])) {
    $id = intval($_POST['id']);
    $wpdb->delete($wpdb->prefix . 'avilib_video_requests', array('id' => $id));
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
                    <th><?php _e('Actions', 'avilib'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $request) : ?>
                    <tr>
                        <td><?php echo esc_html($request->title); ?></td>
                        <td><?php echo esc_url($request->url); ?></td>
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