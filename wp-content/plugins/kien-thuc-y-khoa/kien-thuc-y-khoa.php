<?php
/**
 * Plugin Name: Kiến Thức Y Khoa
 * Description: Plugin CPT + form nhập bảng riêng + shortcode + Swiper hiển thị bài viết y khoa.
 * Version: 1.0
 * Author: Tuan Nguyen
 */

if (!defined('ABSPATH')) exit;

global $wpdb;
define('YKHOA_TABLE', $wpdb->prefix . 'kien_thuc_y_khoa_info');

/**
 * Tạo bảng riêng khi kích hoạt plugin
 */
register_activation_hook(__FILE__, function () {
    global $wpdb;
    $charset = $wpdb->get_charset_collate();
    $table = YKHOA_TABLE;

    $sql = "CREATE TABLE $table (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        post_id BIGINT UNSIGNED NOT NULL,
        hospital_name VARCHAR(255),
        working_hours VARCHAR(255),
        address TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) $charset;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
    flush_rewrite_rules();
});

register_deactivation_hook(__FILE__, function () {
    flush_rewrite_rules();
});

/**
 * Đăng ký CPT và Taxonomy
 */
add_action('init', function () {
    register_post_type('kien_thuc_y_khoa', [
        'labels' => [
            'name' => 'Kiến Thức Y Khoa',
            'singular_name' => 'Bài viết Y Khoa'
        ],
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'kien-thuc-y-khoa'],
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail']
    ]);

    register_taxonomy('chuyen_muc_y_khoa', 'kien_thuc_y_khoa', [
        'label' => 'Chuyên mục Y Khoa',
        'hierarchical' => true,
        'rewrite' => ['slug' => 'chuyen-muc-y-khoa']
    ]);
});

/**
 * Meta Box nhập thông tin
 */
add_action('add_meta_boxes', function () {
    add_meta_box('meta_ykhoa', 'Thông tin Bệnh Viện', 'render_ykhoa_meta_box', 'kien_thuc_y_khoa', 'normal', 'high');
});

function render_ykhoa_meta_box($post) {
    global $wpdb;
    $info = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . YKHOA_TABLE . " WHERE post_id = %d", $post->ID));
    wp_nonce_field('save_ykhoa_meta', 'ykhoa_nonce');
    ?>
    <p><label>Tên bệnh viện:</label><br>
    <input type="text" name="hospital_name" class="widefat" value="<?= esc_attr($info->hospital_name ?? '') ?>"></p>
    <p><label>Giờ khám:</label><br>
    <input type="text" name="working_hours" class="widefat" value="<?= esc_attr($info->working_hours ?? '') ?>"></p>
    <p><label>Địa chỉ:</label><br>
    <input type="text" name="address" class="widefat" value="<?= esc_attr($info->address ?? '') ?>"></p>
    <?php
}

/**
 * Lưu dữ liệu meta box vào bảng riêng
 */
add_action('save_post_kien_thuc_y_khoa', function ($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['ykhoa_nonce']) || !wp_verify_nonce($_POST['ykhoa_nonce'], 'save_ykhoa_meta')) return;
    if (!current_user_can('edit_post', $post_id)) return;

    global $wpdb;
    $table = YKHOA_TABLE;

    $hospital = sanitize_text_field($_POST['hospital_name']);
    $hours = sanitize_text_field($_POST['working_hours']);
    $address = sanitize_text_field($_POST['address']);

    $exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM $table WHERE post_id = %d", $post_id));
    if ($exists) {
        $wpdb->update($table, [
            'hospital_name' => $hospital,
            'working_hours' => $hours,
            'address' => $address,
        ], ['post_id' => $post_id]);
    } else {
        $wpdb->insert($table, [
            'post_id' => $post_id,
            'hospital_name' => $hospital,
            'working_hours' => $hours,
            'address' => $address,
        ]);
    }
});

/**
 * Enqueue SwiperJS và style
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], null, true);

    wp_enqueue_script('ykhoa-slider', plugin_dir_url(__FILE__) . 'assets/ykhoa-slider.js', ['swiper-js'], null, true);
    wp_enqueue_style('ykhoa-style', plugin_dir_url(__FILE__) . 'assets/ykhoa-style.css');
});

/**
 * Shortcode hiển thị dạng carousel
 * Sử dụng: [kien_thuc_y_khoa category="slug"]
 */
add_shortcode('kien_thuc_y_khoa', function ($atts) {
    global $wpdb;

    $atts = shortcode_atts(['category' => ''], $atts);
    $tax_query = [];

    if (!empty($atts['category'])) {
        $tax_query[] = [
            'taxonomy' => 'chuyen_muc_y_khoa',
            'field' => 'slug',
            'terms' => $atts['category']
        ];
    }

    $query = new WP_Query([
        'post_type' => 'kien_thuc_y_khoa',
        'posts_per_page' => 10,
        'tax_query' => $tax_query
    ]);

    ob_start();
    if ($query->have_posts()) :
        echo '<h2 class="ykhoa-title">Thông điệp yêu thương</h2>'; // Thêm tiêu đề
        echo '<div class="swiper ykhoa-swiper"><div class="swiper-wrapper">';
        while ($query->have_posts()) : $query->the_post();
            $info = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . YKHOA_TABLE . " WHERE post_id = %d", get_the_ID()));
            $thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            ?>
            <div class="swiper-slide ykhoa-slide">
                <img src="<?= esc_url($thumb); ?>" alt="">
                <h3><?= esc_html(get_the_title()); ?></h3>
                <p><?= esc_html(get_the_excerpt()); ?></p>
                <?php if ($info): ?>
                <div class="ykhoa-hospital">
                    <strong><?= esc_html($info->hospital_name); ?></strong><br>
                    ⏰ <?= esc_html($info->working_hours); ?><br>
                    📍 <?= esc_html($info->address); ?>
                </div>
                <?php endif; ?>
            </div>
        <?php endwhile;
        echo '</div></div>'; // Loại bỏ các nút prev và next
    endif;
    wp_reset_postdata();
    return ob_get_clean();
});
