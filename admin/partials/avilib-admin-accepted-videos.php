<?php
global $wpdb;

if (isset($_POST['delete'])) {
    $id = intval($_POST['id']);
    $wpdb->delete($wpdb->prefix . 'avilib_accepted_videos', array('id' => $id));
}

$videos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}avilib_accepted_videos ORDER BY created_at DESC");
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <?php if (empty($videos)) : ?>
        <p><?php _e('No accepted videos at the moment.', 'avilib'); ?></p>
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
                <?php foreach ($videos as $video) : ?>
                    <tr>
                        <td><?php echo esc_html($video->title); ?></td>
                        <td><?php echo '<a href="'.esc_url($video->url).'" target="_blank">Ver video</a>'; ?></td>
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
    <?php endif; ?>
</div>