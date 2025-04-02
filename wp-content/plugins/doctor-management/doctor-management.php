<?php
/*
Plugin Name: Doctor Management
Description: Quản lý đội ngũ bác sĩ với custom table và REST API
Version: 1.0
Author: Grok
*/

// Ngăn truy cập trực tiếp vào file
if (!defined('ABSPATH')) {
    exit;
}

// Tạo table khi kích hoạt plugin
register_activation_hook(__FILE__, 'doctor_create_table');
function doctor_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'doctors';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        doctor_title varchar(50) NOT NULL,
        full_name varchar(100) NOT NULL,
        position varchar(100) NOT NULL,
        avatar_url varchar(255) DEFAULT '',
        specialty text NOT NULL,
        email varchar(100) NOT NULL,
        phone varchar(20) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Xóa table khi uninstall plugin
register_uninstall_hook(__FILE__, 'doctor_uninstall');
function doctor_uninstall() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'doctors';
    
    // Xóa table
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
    
    // Xóa các file ảnh đã upload (tùy chọn)
    $upload_dir = wp_upload_dir();
    $doctor_images = glob($upload_dir['basedir'] . '/doctors/*');
    foreach ($doctor_images as $image) {
        if (is_file($image)) {
            unlink($image);
        }
    }
}

// Tạo menu admin
add_action('admin_menu', 'doctor_admin_menu');
function doctor_admin_menu() {
    add_menu_page(
        'Quản lý bác sĩ',
        'Bác sĩ',
        'manage_options',
        'doctor-management',
        'doctor_admin_page',
        'dashicons-groups'
    );
}

// Trang quản lý admin
function doctor_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'doctors';

    // Xử lý thêm/sửa bác sĩ
    if (isset($_POST['doctor_submit'])) {
        $data = array(
            'doctor_title' => sanitize_text_field($_POST['doctor_title']),
            'full_name' => sanitize_text_field($_POST['full_name']),
            'position' => sanitize_text_field($_POST['position']),
            'specialty' => sanitize_textarea_field($_POST['specialty']),
            'email' => sanitize_email($_POST['email']),
            'phone' => sanitize_text_field($_POST['phone'])
        );

        if (!empty($_FILES['avatar']['name'])) {
            $upload = wp_upload_bits($_FILES['avatar']['name'], null, file_get_contents($_FILES['avatar']['tmp_name']));
            if (!$upload['error']) {
                $data['avatar_url'] = $upload['url'];
            }
        }

        if (isset($_POST['doctor_id']) && !empty($_POST['doctor_id'])) {
            $wpdb->update($table_name, $data, array('id' => intval($_POST['doctor_id'])));
        } else {
            $wpdb->insert($table_name, $data);
        }
    }

    // Xóa bác sĩ
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $wpdb->delete($table_name, array('id' => intval($_GET['id'])));
    }

    // Hiển thị form và danh sách
    ?>
    <div class="wrap">
        <h1>Quản lý bác sĩ</h1>
        
        <!-- Form thêm/sửa -->
        <form method="post" enctype="multipart/form-data">
            <?php
            $doctor = null;
            if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
                $doctor = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $_GET['id']));
                echo '<input type="hidden" name="doctor_id" value="' . $doctor->id . '">';
            }
            ?>
            <table class="form-table">
                <tr>
                    <th><label>Chức danh</label></th>
                    <td>
                        <select name="doctor_title">
                            <option value="BS CKI" <?php selected($doctor->doctor_title ?? '', 'BS CKI'); ?>>BS CKI</option>
                            <option value="BS CKII" <?php selected($doctor->doctor_title ?? '', 'BS CKII'); ?>>BS CKII</option>
                            <option value="ThS.BS" <?php selected($doctor->doctor_title ?? '', 'ThS.BS'); ?>>ThS.BS</option>
                            <option value="TS.BS" <?php selected($doctor->doctor_title ?? '', 'TS.BS'); ?>>TS.BS</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label>Họ và tên</label></th>
                    <td><input type="text" name="full_name" value="<?php echo esc_attr($doctor->full_name ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <th><label>Vị trí công tác</label></th>
                    <td><input type="text" name="position" value="<?php echo esc_attr($doctor->position ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <th><label>Hình ảnh đại diện</label></th>
                    <td><input type="file" name="avatar"></td>
                </tr>
                <tr>
                    <th><label>Chuyên môn</label></th>
                    <td><textarea name="specialty" required><?php echo esc_textarea($doctor->specialty ?? ''); ?></textarea></td>
                </tr>
                <tr>
                    <th><label>Email</label></th>
                    <td><input type="email" name="email" value="<?php echo esc_attr($doctor->email ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <th><label>Số điện thoại</label></th>
                    <td><input type="tel" name="phone" value="<?php echo esc_attr($doctor->phone ?? ''); ?>" required></td>
                </tr>
            </table>
            <input type="submit" name="doctor_submit" class="button button-primary" value="Lưu">
        </form>

        <!-- Danh sách bác sĩ -->
        <h2>Danh sách bác sĩ</h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Chức danh</th>
                    <th>Họ và tên</th>
                    <th>Vị trí</th>
                    <th>Hình ảnh</th>
                    <th>Chuyên môn</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $doctors = $wpdb->get_results("SELECT * FROM $table_name");
                foreach ($doctors as $doctor) {
                    echo '<tr>';
                    echo '<td>' . esc_html($doctor->doctor_title) . '</td>';
                    echo '<td>' . esc_html($doctor->full_name) . '</td>';
                    echo '<td>' . esc_html($doctor->position) . '</td>';
                    echo '<td><img src="' . esc_url($doctor->avatar_url) . '" width="50"></td>';
                    echo '<td>' . esc_html($doctor->specialty) . '</td>';
                    echo '<td>' . esc_html($doctor->email) . '</td>';
                    echo '<td>' . esc_html($doctor->phone) . '</td>';
                    echo '<td>
                        <a href="?page=doctor-management&action=edit&id=' . $doctor->id . '">Sửa</a> |
                        <a href="?page=doctor-management&action=delete&id=' . $doctor->id . '" onclick="return confirm(\'Bạn có chắc muốn xóa?\')">Xóa</a>
                    </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}

// Shortcode hiển thị danh sách bác sĩ
function doctor_list_shortcode() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'doctors';
    $doctors = $wpdb->get_results("SELECT * FROM $table_name");
    
    $output = '<div class="doctor-list">';
    foreach ($doctors as $doctor) {
        $output .= '<div class="doctor-item">';
        if ($doctor->avatar_url) {
            $output .= '<img src="' . esc_url($doctor->avatar_url) . '" alt="' . esc_attr($doctor->full_name) . '">';
        }
        $output .= '<h3>' . esc_html($doctor->doctor_title . ' ' . $doctor->full_name) . '</h3>';
        $output .= '<p>Vị trí: ' . esc_html($doctor->position) . '</p>';
        $output .= '<p>Chuyên môn: ' . esc_html($doctor->specialty) . '</p>';
        $output .= '<p>Email: ' . esc_html($doctor->email) . '</p>';
        $output .= '<p>Điện thoại: ' . esc_html($doctor->phone) . '</p>';
        $output .= '</div>';
    }
    $output .= '</div>';
    
    return $output;
}
add_shortcode('doctor_list', 'doctor_list_shortcode');

// Thêm CSS
function doctor_styles() {
    wp_enqueue_style('doctor-styles', plugin_dir_url(__FILE__) . 'style.css');
}
add_action('wp_enqueue_scripts', 'doctor_styles');

// Đăng ký REST API
add_action('rest_api_init', 'register_doctor_api');
function register_doctor_api() {
    register_rest_route('doctors/v1', '/list', array(
        'methods' => 'GET',
        'callback' => 'get_all_doctors',
        'permission_callback' => '__return_true'
    ));

    register_rest_route('doctors/v1', '/doctor/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_doctor',
        'permission_callback' => '__return_true'
    ));

    register_rest_route('doctors/v1', '/create', array(
        'methods' => 'POST',
        'callback' => 'create_doctor',
        'permission_callback' => function() {
            return current_user_can('manage_options');
        }
    ));

    register_rest_route('doctors/v1', '/update/(?P<id>\d+)', array(
        'methods' => 'PUT',
        'callback' => 'update_doctor',
        'permission_callback' => function() {
            return current_user_can('manage_options');
        }
    ));

    register_rest_route('doctors/v1', '/delete/(?P<id>\d+)', array(
        'methods' => 'DELETE',
        'callback' => 'delete_doctor',
        'permission_callback' => function() {
            return current_user_can('manage_options');
        }
    ));
}

// API Functions
function get_all_doctors($request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'doctors';
    $doctors = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
    
    return new WP_REST_Response($doctors, 200);
}

function get_doctor($request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'doctors';
    $id = $request['id'];
    
    $doctor = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id), ARRAY_A);
    
    if ($doctor) {
        return new WP_REST_Response($doctor, 200);
    }
    return new WP_Error('no_doctor', 'Không tìm thấy bác sĩ', array('status' => 404));
}

function create_doctor($request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'doctors';
    
    $data = array(
        'doctor_title' => sanitize_text_field($request['doctor_title']),
        'full_name' => sanitize_text_field($request['full_name']),
        'position' => sanitize_text_field($request['position']),
        'specialty' => sanitize_textarea_field($request['specialty']),
        'email' => sanitize_email($request['email']),
        'phone' => sanitize_text_field($request['phone']),
        'avatar_url' => sanitize_text_field($request['avatar_url'] ?? '')
    );

    $inserted = $wpdb->insert($table_name, $data);
    
    if ($inserted) {
        $data['id'] = $wpdb->insert_id;
        return new WP_REST_Response($data, 201);
    }
    return new WP_Error('create_failed', 'Không thể tạo bác sĩ', array('status' => 500));
}

function update_doctor($request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'doctors';
    $id = $request['id'];
    
    $data = array();
    if (isset($request['doctor_title'])) $data['doctor_title'] = sanitize_text_field($request['doctor_title']);
    if (isset($request['full_name'])) $data['full_name'] = sanitize_text_field($request['full_name']);
    if (isset($request['position'])) $data['position'] = sanitize_text_field($request['position']);
    if (isset($request['specialty'])) $data['specialty'] = sanitize_textarea_field($request['specialty']);
    if (isset($request['email'])) $data['email'] = sanitize_email($request['email']);
    if (isset($request['phone'])) $data['phone'] = sanitize_text_field($request['phone']);
    if (isset($request['avatar_url'])) $data['avatar_url'] = esc_url_raw($request['avatar_url']);

    $updated = $wpdb->update($table_name, $data, array('id' => $id));

    if ($updated !== false) {
        $doctor = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id), ARRAY_A);
        return new WP_REST_Response($doctor, 200);
    }
    return new WP_Error('update_failed', __('Unable to update doctor', 'doctor-management'), array('status' => 500));
}

function delete_doctor($request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'doctors';
    $id = absint($request['id']);

    if (!current_user_can('manage_options')) {
        return new WP_Error('permission_denied', __('You do not have permission to delete this doctor.', 'doctor-management'), array('status' => 403));
    }

    $deleted = $wpdb->delete($table_name, array('id' => $id));

    if ($deleted) {
        return new WP_REST_Response(array('message' => __('Doctor deleted successfully.', 'doctor-management')), 200);
    }
    return new WP_Error('delete_failed', __('Unable to delete doctor', 'doctor-management'), array('status' => 500));
}

// Hook khi plugin bị deactivate
register_deactivation_hook(__FILE__, 'doctor_deactivate');

function doctor_deactivate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'doctors';

    // Xóa dữ liệu nhưng giữ cấu trúc bảng
    $wpdb->query("DELETE FROM $table_name");

    // Nếu muốn xóa luôn ảnh đã upload
    $upload_dir = wp_upload_dir();
    $doctor_images = glob($upload_dir['basedir'] . '/doctors/*');
    foreach ($doctor_images as $image) {
        if (is_file($image)) {
            unlink($image);
        }
    }
}
