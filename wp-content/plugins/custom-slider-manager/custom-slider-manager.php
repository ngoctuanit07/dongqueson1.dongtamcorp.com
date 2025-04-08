<?php
/*
Plugin Name: Custom Slider Manager
Description: Quản lý slider với carousel và shortcode
Version: 1.0
Author: Tuan Nguyen
*/

// Ngăn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

// Tạo bảng database khi kích hoạt plugin
function csm_install() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_sliders';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    $table_images = $wpdb->prefix . 'custom_slider_images';
    $sql2 = "CREATE TABLE $table_images (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        slider_id mediumint(9) NOT NULL,
        image_url varchar(255) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    dbDelta($sql2);
}
register_activation_hook(__FILE__, 'csm_install');

// Thêm menu admin
function csm_admin_menu() {
    add_menu_page(
        'Slider Manager',
        'Slider Manager',
        'manage_options',
        'custom-slider-manager',
        'csm_admin_page',
        'dashicons-images-alt2'
    );
}
add_action('admin_menu', 'csm_admin_menu');

// Trang quản lý admin
function csm_admin_page() {
    global $wpdb;
    
    // Xử lý thêm/sửa slider
    if (isset($_POST['csm_save_slider'])) {
        $slider_name = sanitize_text_field($_POST['slider_name']);
        $slider_id = isset($_POST['slider_id']) ? intval($_POST['slider_id']) : 0;
        
        if ($slider_id > 0) {
            $wpdb->update(
                $wpdb->prefix . 'custom_sliders',
                array('name' => $slider_name),
                array('id' => $slider_id)
            );
        } else {
            $wpdb->insert(
                $wpdb->prefix . 'custom_sliders',
                array('name' => $slider_name)
            );
            $slider_id = $wpdb->insert_id;
        }
        
        // Xử lý upload ảnh
        if (!empty($_FILES['slider_images']['name'][0])) {
            $files = $_FILES['slider_images'];
            foreach ($files['name'] as $key => $value) {
                if ($files['name'][$key]) {
                    $file = array(
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );
                    
                    $upload = wp_handle_upload($file, array('test_form' => false));
                    if (!isset($upload['error'])) {
                        $wpdb->insert(
                            $wpdb->prefix . 'custom_slider_images',
                            array(
                                'slider_id' => $slider_id,
                                'image_url' => $upload['url']
                            )
                        );
                    }
                }
            }
        }
        // Quay lại màn hình danh sách sau khi lưu
        echo '<script>window.location.href = "' . admin_url('admin.php?page=custom-slider-manager') . '";</script>';
    }

    // Xử lý xóa slider
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['slider_id'])) {
        $slider_id = intval($_GET['slider_id']);
        $wpdb->delete($wpdb->prefix . 'custom_sliders', array('id' => $slider_id));
        $wpdb->delete($wpdb->prefix . 'custom_slider_images', array('slider_id' => $slider_id));
    }

    // Xử lý xóa ảnh
    if (isset($_GET['action']) && $_GET['action'] == 'delete_image' && isset($_GET['image_id'])) {
        $image_id = intval($_GET['image_id']);
        $wpdb->delete($wpdb->prefix . 'custom_slider_images', array('id' => $image_id));
    }

    ?>
    <div class="wrap">
        <h1>Slider Manager</h1>

        <?php 
        // Hiển thị form thêm mới hoặc chỉnh sửa
        if (isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')) { 
            $slider_id = isset($_GET['slider_id']) ? intval($_GET['slider_id']) : 0;
            $slider = $slider_id ? $wpdb->get_row("SELECT * FROM {$wpdb->prefix}custom_sliders WHERE id = $slider_id") : null;
        ?>
            <form method="post" enctype="multipart/form-data">
                <h2><?php echo $slider ? 'Chỉnh sửa Slider' : 'Thêm Slider Mới'; ?></h2>
                <input type="hidden" name="slider_id" value="<?php echo $slider_id; ?>">
                <p>
                    <label>Tên Slider:</label><br>
                    <input type="text" name="slider_name" value="<?php echo $slider ? esc_attr($slider->name) : ''; ?>" required>
                </p>
                <?php if ($slider_id) { ?>
                    <p>
                        <label>Thêm ảnh mới:</label><br>
                        <input type="file" name="slider_images[]" multiple>
                    </p>
                    <!-- Grid quản lý ảnh -->
                    <h3>Danh sách ảnh</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px;">
                    <?php
                    $images = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}custom_slider_images WHERE slider_id = $slider_id");
                    foreach ($images as $image) {
                        echo '<div style="text-align: center;">';
                        echo '<img src="' . esc_url($image->image_url) . '" style="max-width: 100%; height: auto;">';
                        echo '<br><a href="?page=custom-slider-manager&action=edit&slider_id=' . $slider_id . '&action=delete_image&image_id=' . $image->id . '" onclick="return confirm(\'Bạn chắc chắn muốn xóa ảnh này?\')" style="color: red;">Xóa</a>';
                        echo '</div>';
                    }
                    ?>
                    </div>
                <?php } ?>
                <p>
                    <input type="submit" name="csm_save_slider" class="button button-primary" value="Lưu Slider">
                    <a href="?page=custom-slider-manager" class="button">Quay lại</a>
                </p>
            </form>
        <?php } else { ?>
            <!-- Grid danh sách slider -->
            <p><a href="?page=custom-slider-manager&action=add" class="button button-primary">Thêm Slider Mới</a></p>
            <table class="wp-list-table widefat">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Shortcode</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sliders = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}custom_sliders");
                foreach ($sliders as $slider) {
                    echo "<tr>";
                    echo "<td>{$slider->id}</td>";
                    echo "<td>{$slider->name}</td>";
                    echo "<td>[custom_slider id='{$slider->id}']</td>";
                    echo "<td>
                        <a href='?page=custom-slider-manager&action=edit&slider_id={$slider->id}'>Chỉnh sửa</a> |
                        <a href='?page=custom-slider-manager&action=delete&slider_id={$slider->id}' onclick='return confirm(\"Bạn chắc chắn muốn xóa?\")'>Xóa</a>
                    </td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
    <?php
}
// Load CSS và JS
function csm_enqueue_scripts() {
    wp_enqueue_style('carousel-css', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css');
    wp_enqueue_style('carousel-theme', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css');
    wp_enqueue_script('jquery');
    wp_enqueue_script('carousel-js', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'csm_enqueue_scripts');

// Shortcode hiển thị slider
// Shortcode hiển thị slider
function csm_slider_shortcode($atts) {
    global $wpdb;
    
    $atts = shortcode_atts(array(
        'id' => 0
    ), $atts);
    
    $slider_id = intval($atts['id']);
    if (!$slider_id) return '';
    
    $images = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT image_url FROM {$wpdb->prefix}custom_slider_images WHERE slider_id = %d",
            $slider_id
        )
    );
    
    if (empty($images)) return '';
    
    $output = '<div class="owl-carousel owl-theme">';
    foreach ($images as $image) {
        $output .= '<div class="item"><img src="' . esc_url($image->image_url) . '" alt="Slider Image" class="slider-image"></div>';
    }
    $output .= '</div>';
    
    $output .= '<script>
        jQuery(document).ready(function($) {
            $(".owl-carousel").owlCarousel({
                items: 1,
                loop: true,
                margin: 10,
                nav: true,
                autoplay: true,
                autoplayTimeout: 3000
            });
        });
    </script>';
    
    return $output;
}
add_shortcode('custom_slider', 'csm_slider_shortcode');

// CSS bổ sung
// CSS bổ sung
function csm_custom_styles() {
    echo '<style>
        .owl-carousel .item {
            position: relative;
            width: 100%; /* Giữ nguyên như bạn đã đặt */
            height: 400px; /* Chiều cao cố định, bạn có thể điều chỉnh */
            overflow: hidden;
            display: flex; /* Sử dụng flexbox để căn giữa */
            justify-content: center; /* Căn giữa theo chiều ngang */
            align-items: center; /* Căn giữa theo chiều dọc */
        }
        .owl-carousel .item img.slider-image {
            width: 100%; /* Giữ nguyên như bạn đã đặt */
            height: 100%; /* Chiều cao bằng container */
            object-fit: cover; /* Đảm bảo ảnh được cắt để lấp đầy khung */
            display: block;
        }
    </style>';
}
add_action('wp_head', 'csm_custom_styles');