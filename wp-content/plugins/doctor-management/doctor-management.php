<?php
/*
Plugin Name: Doctor Management
Description: Quản lý đội ngũ bác sĩ với custom table và REST API
Version: 1.1
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

    // Xóa các file ảnh đã upload
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
        __('Doctor Management', 'doctor-management'),
        __('Doctors', 'doctor-management'),
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
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['doctor_submit'])) {
        check_admin_referer('doctor_form_action', 'doctor_nonce');

        $data = array(
            'doctor_title' => sanitize_text_field($_POST['doctor_title']),
            'full_name' => sanitize_text_field($_POST['full_name']),
            'position' => sanitize_text_field($_POST['position']),
            'specialty' => sanitize_textarea_field($_POST['specialty']),
            'email' => sanitize_email($_POST['email']),
            'phone' => sanitize_text_field($_POST['phone']),
        );

        if (!empty($_FILES['avatar']['name'])) {
            $upload = wp_handle_upload($_FILES['avatar'], array('test_form' => false));
            if (isset($upload['url'])) {
                $data['avatar_url'] = esc_url_raw($upload['url']);
            }
        }

        if (!empty($_POST['doctor_id'])) {
            $wpdb->update($table_name, $data, array('id' => intval($_POST['doctor_id'])));
            add_settings_error('doctor_messages', 'doctor_updated', __('Doctor updated successfully.', 'doctor-management'), 'updated');
        } else {
            $wpdb->insert($table_name, $data);
            add_settings_error('doctor_messages', 'doctor_added', __('Doctor added successfully.', 'doctor-management'), 'updated');
        }
    }

    // Xóa bác sĩ
    if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'delete') {
        check_admin_referer('delete_doctor_action');
        $wpdb->delete($table_name, array('id' => intval($_GET['id'])));
        add_settings_error('doctor_messages', 'doctor_deleted', __('Doctor deleted successfully.', 'doctor-management'), 'updated');
    }

    settings_errors('doctor_messages');

    // Hiển thị form và danh sách
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Doctor Management', 'doctor-management'); ?></h1>

        <!-- Form thêm/sửa -->
        <form method="post" enctype="multipart/form-data">
            <?php
            $doctor = null;
            if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'edit') {
                $doctor = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", intval($_GET['id'])));
                echo '<input type="hidden" name="doctor_id" value="' . esc_attr($doctor->id) . '">';
            }
            wp_nonce_field('doctor_form_action', 'doctor_nonce');
            ?>
            <table class="form-table">
                <tr>
                    <th><label for="doctor_title"><?php esc_html_e('Title', 'doctor-management'); ?></label></th>
                    <td>
                        <select name="doctor_title" id="doctor_title">
                            <option value="BS CKI" <?php selected($doctor->doctor_title ?? '', 'BS CKI'); ?>>BS CKI</option>
                            <option value="BS CKII" <?php selected($doctor->doctor_title ?? '', 'BS CKII'); ?>>BS CKII</option>
                            <option value="ThS.BS" <?php selected($doctor->doctor_title ?? '', 'ThS.BS'); ?>>ThS.BS</option>
                            <option value="TS.BS" <?php selected($doctor->doctor_title ?? '', 'TS.BS'); ?>>TS.BS</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="full_name"><?php esc_html_e('Full Name', 'doctor-management'); ?></label></th>
                    <td><input type="text" name="full_name" id="full_name" value="<?php echo esc_attr($doctor->full_name ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <th><label for="position"><?php esc_html_e('Position', 'doctor-management'); ?></label></th>
                    <td><input type="text" name="position" id="position" value="<?php echo esc_attr($doctor->position ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <th><label for="avatar"><?php esc_html_e('Avatar', 'doctor-management'); ?></label></th>
                    <td><input type="file" name="avatar" id="avatar"></td>
                </tr>
                <tr>
                    <th><label for="specialty"><?php esc_html_e('Specialty', 'doctor-management'); ?></label></th>
                    <td><textarea name="specialty" id="specialty" required><?php echo esc_textarea($doctor->specialty ?? ''); ?></textarea></td>
                </tr>
                <tr>
                    <th><label for="email"><?php esc_html_e('Email', 'doctor-management'); ?></label></th>
                    <td><input type="email" name="email" id="email" value="<?php echo esc_attr($doctor->email ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <th><label for="phone"><?php esc_html_e('Phone', 'doctor-management'); ?></label></th>
                    <td><input type="tel" name="phone" id="phone" value="<?php echo esc_attr($doctor->phone ?? ''); ?>" required></td>
                </tr>
            </table>
            <input type="submit" name="doctor_submit" class="button button-primary" value="<?php esc_attr_e('Save', 'doctor-management'); ?>">
        </form>

        <!-- Danh sách bác sĩ -->
        <h2><?php esc_html_e('Doctor List', 'doctor-management'); ?></h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th><?php esc_html_e('Title', 'doctor-management'); ?></th>
                    <th><?php esc_html_e('Full Name', 'doctor-management'); ?></th>
                    <th><?php esc_html_e('Position', 'doctor-management'); ?></th>
                    <th><?php esc_html_e('Avatar', 'doctor-management'); ?></th>
                    <th><?php esc_html_e('Specialty', 'doctor-management'); ?></th>
                    <th><?php esc_html_e('Email', 'doctor-management'); ?></th>
                    <th><?php esc_html_e('Phone', 'doctor-management'); ?></th>
                    <th><?php esc_html_e('Actions', 'doctor-management'); ?></th>
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
                        <a href="' . esc_url(add_query_arg(array('page' => 'doctor-management', 'action' => 'edit', 'id' => $doctor->id), admin_url('admin.php'))) . '">' . esc_html__('Edit', 'doctor-management') . '</a> |
                        <a href="' . esc_url(wp_nonce_url(add_query_arg(array('page' => 'doctor-management', 'action' => 'delete', 'id' => $doctor->id), admin_url('admin.php')), 'delete_doctor_action')) . '" onclick="return confirm(\'' . esc_js(__('Are you sure you want to delete this doctor?', 'doctor-management')) . '\')">' . esc_html__('Delete', 'doctor-management') . '</a>
                    </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('bootstrap5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', [], null, true);
});

// Shortcode: [doctor_list]
add_shortcode('doctor_list', 'doctor_list_shortcode_display');

function doctor_list_shortcode_display() {
    global $wpdb;

    // Số lượng bác sĩ hiển thị trên mỗi trang
    $doctors_per_page = 35;

    // Lấy số trang hiện tại từ query string, mặc định là 1
    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;

    // Tính toán OFFSET
    $offset = ($current_page - 1) * $doctors_per_page;

    // Lấy tổng số bác sĩ
    $table_name = $wpdb->prefix . 'doctors';
    $total_doctors = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    $total_pages = ceil($total_doctors / $doctors_per_page);

    // Lấy danh sách bác sĩ với LIMIT và OFFSET
    $doctors = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table_name ORDER BY full_name ASC LIMIT %d OFFSET %d",
            $doctors_per_page,
            $offset
        )
    );

    if (empty($doctors)) {
        return '<p>Không có bác sĩ nào được tìm thấy.</p>';
    }

    ob_start();
    ?>
    <section class="container py-5">
        <h2 class="section-title text-center mb-4">Đội ngũ bác sĩ</h2>
        <div class="row g-4">
            <?php foreach ($doctors as $doctor): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm rounded-4 text-center border-0">
                        <img src="<?php echo esc_url($doctor->avatar_url ?: 'https://dongqueson1.dongtamcorp.com/wp-content/uploads/2025/04/avatar-default-png.webp'); ?>"
                             class="card-img-top rounded-top-4" alt="<?php echo esc_attr($doctor->full_name); ?>"
                             style="object-fit: cover; height: 320px;">
                        <div class="card-body">
                            <h5 class="fw-bold text-danger mb-1">
                                <?php echo esc_html($doctor->doctor_title); ?><br><?php echo esc_html($doctor->full_name); ?>
                            </h5>
                            <p class="mb-1 small"><?php echo esc_html($doctor->position); ?></p>
                            <p class="text-muted small">Chuyên khoa: <?php echo esc_html($doctor->specialty); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Phân trang -->
        <?php if ($total_pages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php if ($current_page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo esc_url(add_query_arg('paged', $current_page - 1)); ?>" aria-label="Trang trước">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i === $current_page) ? 'active' : ''; ?>">
                            <a class="page-link" href="<?php echo esc_url(add_query_arg('paged', $i)); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo esc_url(add_query_arg('paged', $current_page + 1)); ?>" aria-label="Trang sau">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </section>

    <style>
        .pagination .page-item.active .page-link {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }
        .pagination .page-link {
            color: #dc3545;
        }
        .pagination .page-link:hover {
            background-color: #f8d7da;
            color: #dc3545;
        }
    </style>
    <?php
    return ob_get_clean();
}
?>

