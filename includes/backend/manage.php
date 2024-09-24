<?php

// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}

function vrp_manage_videos_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'accepted_videos';

    if (isset($_POST['delete_video'])) {
        $id = intval($_POST['id']);
        vrp_delete_video($id);
    }

    $accepted_videos = $wpdb->get_results("SELECT * FROM $table_name");

    echo '<div class="wrap"><h1>' . __('Accepted Videos', 'avilib') . '</h1>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>' . __('Title', 'avilib') . '</th><th>' . __('URL', 'avilib') . '</th><th>' . __('Categories', 'avilib') . '</th><th>' . __('Actions', 'avilib') . '</th></tr></thead><tbody>';
    foreach ($accepted_videos as $video) {
        $categories = $wpdb->get_results($wpdb->prepare(
            "SELECT vc.name 
            FROM {$wpdb->prefix}accepted_video_categories avc 
            JOIN {$wpdb->prefix}video_categories vc ON avc.category_id = vc.id 
            WHERE avc.accepted_video_id = %d", 
            $video->id
        ));
        $category_names = wp_list_pluck($categories, 'name');
        $category_list = implode(', ', $category_names);

        echo '<tr>';
        echo '<td>' . esc_html($video->title) . '</td>';
        echo '<td>' . esc_html($video->url) . '</td>';
        echo '<td>' . esc_html($category_list) . '</td>';
        echo '<td>
            <form method="post" style="display:inline;">
                <input type="hidden" name="id" value="' . esc_attr($video->id) . '">
                <input type="submit" name="delete_video" value="' . __('Delete', 'avilib') . '" class="button button-secondary">
            </form>
        </td>';
        echo '</tr>';
    }
    echo '</tbody></table></div>';
}   
?>