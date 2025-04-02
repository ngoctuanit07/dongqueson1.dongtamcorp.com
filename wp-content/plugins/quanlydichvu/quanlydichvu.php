<?php
/*
Plugin Name: Quản Lý Dịch Vụ
Description: Plugin giúp lưu trữ và hiển thị các dịch vụ chăm sóc mẹ và bé sau sinh.
Version: 1.0
Author: Tuan Nguyen
*/

if (!defined('ABSPATH')) exit;

define('QLDV_DIR', plugin_dir_path(__FILE__));
define('QLDV_URL', plugin_dir_url(__FILE__));

// Load CSS
function qldv_enqueue_assets() {
    wp_enqueue_style('qldv-style', QLDV_URL . 'css/style.css');
}
add_action('wp_enqueue_scripts', 'qldv_enqueue_assets');

// Register custom post type "dich_vu"
function qldv_register_post_type() {
    register_post_type('dich_vu', array(
        'labels' => array(
            'name' => 'Dịch vụ',
            'singular_name' => 'Dịch vụ',
            'add_new' => 'Thêm dịch vụ',
            'add_new_item' => 'Thêm dịch vụ mới',
            'edit_item' => 'Chỉnh sửa dịch vụ',
            'new_item' => 'Dịch vụ mới',
            'all_items' => 'Tất cả dịch vụ',
            'menu_name' => 'Dịch vụ'
        ),
        'public' => true,
        'menu_icon' => 'dashicons-heart',
        'supports' => array('title', 'editor', 'thumbnail'),
        'has_archive' => false,
    ));
}
add_action('init', 'qldv_register_post_type');

// Add metabox for additional fields
function qldv_add_metabox() {
    add_meta_box('qldv_metabox', 'Thông tin dịch vụ', 'qldv_render_metabox', 'dich_vu', 'normal', 'default');
}
add_action('add_meta_boxes', 'qldv_add_metabox');

function qldv_render_metabox($post) {
    $gia = get_post_meta($post->ID, '_gia', true);
    $lien_he = get_post_meta($post->ID, '_lien_he', true);
    ?>
    <label for="gia">Giá:</label><br>
    <input type="text" name="gia" value="<?php echo esc_attr($gia); ?>" style="width:100%;"><br><br>

    <label for="lien_he">Số điện thoại liên hệ:</label><br>
    <input type="text" name="lien_he" value="<?php echo esc_attr($lien_he); ?>" style="width:100%;">
    <?php
}

// Save metabox data
function qldv_save_metabox($post_id) {
    if (isset($_POST['gia'])) {
        update_post_meta($post_id, '_gia', sanitize_text_field($_POST['gia']));
    }
    if (isset($_POST['lien_he'])) {
        update_post_meta($post_id, '_lien_he', sanitize_text_field($_POST['lien_he']));
    }
}
add_action('save_post', 'qldv_save_metabox');

// Shortcode: [dichvu_list]
// Shortcode: [dichvu_list]
function qldv_service_shortcode($atts) {
    ob_start();
    $query = new WP_Query(array(
        'post_type' => 'dich_vu',
        'posts_per_page' => -1
    ));

    echo '<div class="qldv-wrapper">';

    if ($query->have_posts()) {
        while ($query->have_posts()) : $query->the_post();
            include QLDV_DIR . 'templates/service-card.php';
        endwhile;
    } else {
        echo '<p>Dữ liệu đang được cập nhật...</p>';
    }

    echo '</div>';
    wp_reset_postdata();
    return ob_get_clean();
}

add_shortcode('dichvu_list', 'qldv_service_shortcode');
