<?php
// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}

function vrp_requests_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'video_requests';

    if (isset($_POST['accept'])) {
        $id = intval($_POST['id']);
        $request = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id");
        if ($request) {
            // Insertar en la tabla accepted_videos
            $wpdb->insert(
                $wpdb->prefix . 'accepted_videos',
                array(
                    'title' => $request->title,
                    'url' => $request->url
                )
            );
            $accepted_video_id = $wpdb->insert_id;

            // Recuperar las categorías asociadas al video_request
            $categories = $wpdb->get_results($wpdb->prepare(
                "SELECT category_id 
                 FROM {$wpdb->prefix}video_request_categories 
                 WHERE video_request_id = %d", 
                 $id
            ));

            // Insertar las categorías en la tabla accepted_video_categories
            foreach ($categories as $category) {
                $wpdb->insert(
                    $wpdb->prefix . 'accepted_video_categories',
                    array(
                        'accepted_video_id' => $accepted_video_id,
                        'category_id' => $category->category_id
                    )
                );
            }

            // Eliminar el video_request original y sus categorías
            $wpdb->delete($table_name, array('id' => $id));
            $wpdb->delete("{$wpdb->prefix}video_request_categories", array('video_request_id' => $id));
        }
    } elseif (isset($_POST['delete'])) {
        $id = intval($_POST['id']);
        // Eliminar el video_request original y sus categorías
        $wpdb->delete($table_name, array('id' => $id));
        $wpdb->delete("{$wpdb->prefix}video_request_categories", array('video_request_id' => $id));
    }

    $requests = $wpdb->get_results("SELECT * FROM $table_name");

    echo '<div class="wrap"><h1>' . __('Video Requests', 'avilib') . '</h1>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>' . __('Title', 'avilib') . '</th><th>' . __('URL', 'avilib') . '</th><th>' . __('Categories', 'avilib') . '</th><th>' . __('Actions', 'avilib') . '</th></tr></thead><tbody>';
    foreach ($requests as $request) {
        // Recuperar las categorías asociadas al video_request
        $categories = $wpdb->get_results($wpdb->prepare(
            "SELECT vc.name 
             FROM {$wpdb->prefix}video_request_categories vrc 
             JOIN {$wpdb->prefix}video_categories vc ON vrc.category_id = vc.id 
             WHERE vrc.video_request_id = %d", 
             $request->id
        ));
        $category_names = wp_list_pluck($categories, 'name');
        $category_list = implode(', ', $category_names);

        echo '<tr>';
        echo '<td>' . esc_html($request->title) . '</td>';
        echo '<td>' . esc_html($request->url) . '</td>';
        echo '<td>' . esc_html($category_list) . '</td>';
        echo '<td>
            <form method="post" style="display:inline;">
                <input type="hidden" name="id" value="' . esc_attr($request->id) . '">
                <input type="submit" name="accept" value="' . __('Accept', 'avilib') . '" class="button button-primary">
            </form>
            <form method="post" style="display:inline;">
                <input type="hidden" name="id" value="' . esc_attr($request->id) . '">
                <input type="submit" name="delete" value="' . __('Delete', 'avilib') . '" class="button button-secondary">
            </form>
        </td>';
        echo '</tr>';
    }
    echo '</tbody></table></div>';
}

// Registrar el menú de administración
add_action('admin_menu', 'vrp_admin_menu');
function vrp_admin_menu() {
    add_menu_page(__('Video Requests', 'avilib'), __('Video Requests', 'avilib'), 'manage_options', 'video-requests', 'vrp_requests_page');
    add_submenu_page('video-requests', __('Categories', 'avilib'), __('Categories', 'avilib'), 'manage_options', 'video-categories', 'vrp_categories_page');
    add_submenu_page('video-requests', __('Manage Videos', 'avilib'), __('Manage Videos', 'avilib'), 'manage_options', 'manage-videos', 'vrp_manage_videos_page');
}
?>
