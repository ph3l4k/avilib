<?php
// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}

function vrp_categories_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'video_categories';

    if (isset($_POST['add_category'])) {
        $category_name = sanitize_text_field($_POST['category_name']);
        $wpdb->insert($table_name, array('name' => $category_name));
    } elseif (isset($_POST['delete_category'])) {
        $category_id = intval($_POST['category_id']);
        vrp_delete_category($category_id);
    }

    $categories = $wpdb->get_results("SELECT * FROM $table_name");

    echo '<div class="wrap"><h1>' . __('Manage Categories', 'avilib') . '</h1>';
    echo '<form method="post">';
    echo '<input type="text" name="category_name" placeholder="' . __('New Category', 'avilib') . '" required>';
    echo '<input type="submit" name="add_category" value="' . __('Add Category', 'avilib') . '" class="button button-primary">';
    echo '</form>';
    echo '<br />';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>' . __('Category Name', 'avilib') . '</th><th>' . __('Actions', 'avilib') . '</th></tr></thead><tbody>';
    foreach ($categories as $category) {
        $video_count = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) 
            FROM {$wpdb->prefix}accepted_video_categories 
            WHERE category_id = %d", 
            $category->id
        ));
        echo '<tr>';
        echo '<td>' . esc_html($category->name) . ' (' . $video_count . ' ' . __('videos', 'avilib') . ')</td>';
        echo '<td>
            <form method="post" style="display:inline;">
                <input type="hidden" name="category_id" value="' . esc_attr($category->id) . '">
                <input type="submit" name="delete_category" value="' . __('Delete', 'avilib') . '" class="button button-secondary">
            </form>
        </td>';
        echo '</tr>';
    }
    echo '</tbody></table></div>';
}
?>
