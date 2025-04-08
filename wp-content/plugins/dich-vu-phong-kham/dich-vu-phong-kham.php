<?php
/*
Plugin Name: Dịch Vụ Phòng Khám
Plugin URI: 
Description: Plugin quản lý dịch vụ phòng khám, hỗ trợ CRUD và nhập/xuất Excel.
Version: 1.1
Author: Tuan Nguyen
Author URI: 
*/

// Đảm bảo không truy cập trực tiếp vào file
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Kết nối các tệp phụ trợ
require_once plugin_dir_path( __FILE__ ) . 'includes/admin-functions.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/database-functions.php';

// Hook vào khi plugin được kích hoạt
register_activation_hook( __FILE__, 'dich_vu_phong_kham_activate' );

// Kích hoạt plugin và tạo bảng cơ sở dữ liệu
function dich_vu_phong_kham_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'dich_vu_phong_kham';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        phone varchar(100) NOT NULL,
        price decimal(10,2) NOT NULL,
        specialty varchar(100) NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

// Xóa bảng khi plugin bị deactivate
register_deactivation_hook( __FILE__, 'dich_vu_phong_kham_deactivate' );

function dich_vu_phong_kham_deactivate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'dich_vu_phong_kham';

    // Xóa bảng
    $wpdb->query( "DROP TABLE IF EXISTS $table_name" );
}

// Xóa bảng khi plugin bị uninstall
register_uninstall_hook( __FILE__, 'dich_vu_phong_kham_uninstall' );

function dich_vu_phong_kham_uninstall() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'dich_vu_phong_kham';

    // Xóa bảng
    $wpdb->query( "DROP TABLE IF EXISTS $table_name" );
}

// Hook vào admin_menu để thêm menu quản trị
add_action( 'admin_menu', 'dich_vu_phong_kham_admin_menu' );

// Thêm menu trong quản trị
function dich_vu_phong_kham_admin_menu() {
    add_menu_page(
        esc_html__( 'Dịch Vụ Phòng Khám', 'dich-vu-phong-kham' ),
        esc_html__( 'Dịch Vụ Phòng Khám', 'dich-vu-phong-kham' ),
        'manage_options',
        'dich_vu_phong_kham',
        'dich_vu_phong_kham_page',
        'dashicons-admin-tools',
        20
    );
}



// Hook để đăng ký settings API
add_action( 'admin_init', 'dich_vu_phong_kham_settings' );

function dich_vu_phong_kham_settings() {
    register_setting( 'dich_vu_phong_kham_settings_group', 'dich_vu_phong_kham_settings', 'dich_vu_phong_kham_sanitize_settings' );

    add_settings_section(
        'dich_vu_phong_kham_section',
        esc_html__( 'Cài Đặt Dịch Vụ Phòng Khám', 'dich-vu-phong-kham' ),
        null,
        'dich_vu_phong_kham'
    );

    add_settings_field(
        'phone_field',
        esc_html__( 'Số Điện Thoại Liên Hệ', 'dich-vu-phong-kham' ),
        'dich_vu_phong_kham_phone_field',
        'dich_vu_phong_kham',
        'dich_vu_phong_kham_section'
    );
}

// Hàm hiển thị trường nhập số điện thoại
function dich_vu_phong_kham_phone_field() {
    $options = get_option( 'dich_vu_phong_kham_settings' );
    $phone = isset( $options['phone'] ) ? esc_attr( $options['phone'] ) : '';
    echo "<input type='text' name='dich_vu_phong_kham_settings[phone]' value='$phone' />";
}

// Hàm sanitize dữ liệu settings
function dich_vu_phong_kham_sanitize_settings( $input ) {
    $output = array();
    if ( isset( $input['phone'] ) ) {
        $output['phone'] = sanitize_text_field( $input['phone'] );
    }
    return $output;
}

// Thêm JS và CSS vào trang quản trị
function dich_vu_phong_kham_admin_scripts( $hook ) {
    if ( 'toplevel_page_dich_vu_phong_kham' !== $hook ) {
        return;
    }
    wp_enqueue_style( 'dich-vu-phong-kham-admin-style', plugin_dir_url( __FILE__ ) . 'assets/css/admin-style.css' );
    wp_enqueue_script( 'dich-vu-phong-kham-admin-script', plugin_dir_url( __FILE__ ) . 'assets/js/admin-scripts.js', array( 'jquery' ), null, true );
}
add_action( 'admin_enqueue_scripts', 'dich_vu_phong_kham_admin_scripts' );

// Hook để đăng ký REST API endpoint
add_action( 'rest_api_init', function () {
    register_rest_route( 'dich-vu-phong-kham/v1', '/services', array(
        'methods'             => 'GET',
        'callback'            => 'dich_vu_phong_kham_get_services',
        'permission_callback' => 'dich_vu_phong_kham_permission_check',
    ));

    register_rest_route( 'dich-vu-phong-kham/v1', '/services', array(
        'methods'             => 'POST',
        'callback'            => 'dich_vu_phong_kham_create_service',
        'permission_callback' => 'dich_vu_phong_kham_permission_check',
        'args'                => array(
            'name'      => array(
                'required'          => true,
                'sanitize_callback' => 'sanitize_text_field',
            ),
            'phone'     => array(
                'required'          => true,
                'sanitize_callback' => 'sanitize_text_field',
            ),
            'price'     => array(
                'required'          => true,
                'sanitize_callback' => 'floatval',
            ),
            'specialty' => array(
                'required'          => true,
                'sanitize_callback' => 'sanitize_text_field',
            ),
        ),
    ));

    register_rest_route( 'dich-vu-phong-kham/v1', '/services/(?P<id>\d+)', array(
        'methods'             => 'PUT',
        'callback'            => 'dich_vu_phong_kham_update_service',
        'permission_callback' => 'dich_vu_phong_kham_permission_check',
        'args'                => array(
            'name'  => array(
                'required'          => true,
                'sanitize_callback' => 'sanitize_text_field',
            ),
            'phone' => array(
                'required'          => true,
                'sanitize_callback' => 'sanitize_text_field',
            ),
            'price' => array(
                'required'          => true,
                'sanitize_callback' => 'floatval',
            ),
        ),
    ));

    register_rest_route( 'dich-vu-phong-kham/v1', '/services/(?P<id>\d+)', array(
        'methods'             => 'DELETE',
        'callback'            => 'dich_vu_phong_kham_delete_service',
        'permission_callback' => 'dich_vu_phong_kham_permission_check',
    ));
});

// Kiểm tra quyền truy cập REST API
function dich_vu_phong_kham_permission_check() {
    return current_user_can( 'manage_options' );
}

// Lấy danh sách dịch vụ
function dich_vu_phong_kham_get_services( WP_REST_Request $request ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'dich_vu_phong_kham';

    $services = $wpdb->get_results( "SELECT * FROM $table_name", ARRAY_A );

    if ( empty( $services ) ) {
        return new WP_REST_Response( array( 'message' => __( 'No services found.', 'dich-vu-phong-kham' ) ), 404 );
    }

    return new WP_REST_Response( $services, 200 );
}

// Tạo dịch vụ mới
function dich_vu_phong_kham_create_service( WP_REST_Request $request ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'dich_vu_phong_kham';

    $data = array(
        'name'  => sanitize_text_field( $request->get_param( 'name' ) ),
        'phone' => sanitize_text_field( $request->get_param( 'phone' ) ),
        'price' => floatval( $request->get_param( 'price' ) ),
    );

    $result = $wpdb->insert( $table_name, $data, array( '%s', '%s', '%f' ) );

    if ( false === $result ) {
        return new WP_REST_Response( array( 'message' => __( 'Failed to create service.', 'dich-vu-phong-kham' ) ), 500 );
    }

    return new WP_REST_Response( array( 'message' => __( 'Service created successfully.', 'dich-vu-phong-kham' ) ), 201 );
}

// Cập nhật dịch vụ
function dich_vu_phong_kham_update_service( WP_REST_Request $request ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'dich_vu_phong_kham';

    $id = intval( $request->get_param( 'id' ) );
    $data = array(
        'name'  => sanitize_text_field( $request->get_param( 'name' ) ),
        'phone' => sanitize_text_field( $request->get_param( 'phone' ) ),
        'price' => floatval( $request->get_param( 'price' ) ),
    );

    $result = $wpdb->update( $table_name, $data, array( 'id' => $id ), array( '%s', '%s', '%f' ), array( '%d' ) );

    if ( false === $result ) {
        return new WP_REST_Response( array( 'message' => __( 'Failed to update service.', 'dich-vu-phong-kham' ) ), 500 );
    }

    return new WP_REST_Response( array( 'message' => __( 'Service updated successfully.', 'dich-vu-phong-kham' ) ), 200 );
}

// Xóa dịch vụ
function dich_vu_phong_kham_delete_service( WP_REST_Request $request ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'dich_vu_phong_kham';

    $id = intval( $request->get_param( 'id' ) );

    $result = $wpdb->delete( $table_name, array( 'id' => $id ), array( '%d' ) );

    if ( false === $result ) {
        return new WP_REST_Response( array( 'message' => __( 'Failed to delete service.', 'dich-vu-phong-kham' ) ), 500 );
    }

    return new WP_REST_Response( array( 'message' => __( 'Service deleted successfully.', 'dich-vu-phong-kham' ) ), 200 );
}

// Thêm menu con để xử lý thêm mới dịch vụ
add_action( 'admin_menu', function() {
    add_submenu_page(
        null, // Không hiển thị trong menu
        esc_html__( 'Thêm Mới Dịch Vụ', 'dich-vu-phong-kham' ),
        esc_html__( 'Thêm Mới', 'dich-vu-phong-kham' ),
        'manage_options',
        'dich_vu_phong_kham_add',
        'dich_vu_phong_kham_add_page'
    );
});

// Trang thêm mới dịch vụ
function dich_vu_phong_kham_add_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Bạn không có quyền truy cập vào trang này.', 'dich-vu-phong-kham' ) );
    }

    // Xử lý thêm mới dịch vụ
    if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['dich_vu_phong_kham_add_nonce'] ) ) {
        if ( wp_verify_nonce( $_POST['dich_vu_phong_kham_add_nonce'], 'dich_vu_phong_kham_add_action' ) ) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'dich_vu_phong_kham';

            $name      = sanitize_text_field( $_POST['name'] );
            $phone     = sanitize_text_field( $_POST['phone'] );
            $price     = floatval( $_POST['price'] );
            $specialty = sanitize_text_field( $_POST['specialty'] );

            $wpdb->insert(
                $table_name,
                array(
                    'name'      => $name,
                    'phone'     => $phone,
                    'price'     => $price,
                    'specialty' => $specialty,
                ),
                array( '%s', '%s', '%f', '%s' )
            );

            // Chuyển hướng về trang danh sách dịch vụ (grid)
            wp_safe_redirect( admin_url( 'admin.php?page=dich_vu_phong_kham' ) );
            exit; // Dừng thực thi sau khi chuyển hướng
        }
    }

    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Thêm Mới Dịch Vụ', 'dich-vu-phong-kham' ); ?></h1>
        <form method="post">
            <?php wp_nonce_field( 'dich_vu_phong_kham_add_action', 'dich_vu_phong_kham_add_nonce' ); ?>
            <table class="form-table">
                <tr>
                    <th><label for="name"><?php esc_html_e( 'Tên Dịch Vụ', 'dich-vu-phong-kham' ); ?></label></th>
                    <td><input type="text" name="name" id="name" class="regular-text" required></td>
                </tr>
                <tr>
                    <th><label for="phone"><?php esc_html_e( 'Số Điện Thoại', 'dich-vu-phong-kham' ); ?></label></th>
                    <td><input type="text" name="phone" id="phone" class="regular-text" required></td>
                </tr>
                <tr>
                    <th><label for="price"><?php esc_html_e( 'Giá', 'dich-vu-phong-kham' ); ?></label></th>
                    <td><input type="number" name="price" id="price" class="regular-text" step="0.01" required></td>
                </tr>
                <tr>
                    <th><label for="specialty"><?php esc_html_e( 'Chuyên Khoa', 'dich-vu-phong-kham' ); ?></label></th>
                    <td>
                        <select name="specialty" id="specialty" class="regular-text" required>
                            <option value=""><?php esc_html_e( 'Chọn Chuyên Khoa', 'dich-vu-phong-kham' ); ?></option>
                            <option value="Xét nghiệm"><?php esc_html_e( 'Xét nghiệm', 'dich-vu-phong-kham' ); ?></option>
                            <option value="Y học cổ truyền"><?php esc_html_e( 'Y học cổ truyền', 'dich-vu-phong-kham' ); ?></option>
                            <option value="Khám tổng quát"><?php esc_html_e( 'Khám tổng quát', 'dich-vu-phong-kham' ); ?></option>

                        </select>
                    </td>
                </tr>
            </table>
            <?php submit_button( esc_html__( 'Thêm Mới', 'dich-vu-phong-kham' ) ); ?>
        </form>
    </div>
    <?php
}

// Thêm menu con để xử lý import dịch vụ
add_action( 'admin_menu', function() {
    add_submenu_page(
        null, // Không hiển thị trong menu
        esc_html__( 'Import Dịch Vụ', 'dich-vu-phong-kham' ),
        esc_html__( 'Import', 'dich-vu-phong-kham' ),
        'manage_options',
        'dich_vu_phong_kham_import',
        'dich_vu_phong_kham_import_page'
    );
});

add_action( 'admin_menu', function() {
    add_submenu_page(
        'dich_vu_phong_kham', // Menu cha
        esc_html__( 'Import Dịch Vụ', 'dich-vu-phong-kham' ),
        esc_html__( 'Import', 'dich-vu-phong-kham' ),
        'manage_options',
        'dich_vu_phong_kham_import',
        'dich_vu_phong_kham_import_page'
    );
});

// Trang import dịch vụ
use PhpOffice\PhpSpreadsheet\IOFactory;

function dich_vu_phong_kham_import_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Bạn không có quyền truy cập vào trang này.', 'dich-vu-phong-kham' ) );
    }

    // Xử lý import file Excel
    if ( isset( $_POST['submit'] ) && isset( $_FILES['excel_file'] ) ) {
        if ( ! wp_verify_nonce( $_POST['dich_vu_phong_kham_import_nonce'], 'dich_vu_phong_kham_import_action' ) ) {
            wp_die( esc_html__( 'Nonce không hợp lệ.', 'dich-vu-phong-kham' ) );
        }

        $file = $_FILES['excel_file'];

        // Kiểm tra định dạng file
        $allowed_types = array(
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
            'application/vnd.ms-excel', // .xls
        );

        if ( ! in_array( $file['type'], $allowed_types ) ) {
            echo '<div class="notice notice-error"><p>' . esc_html__( 'Vui lòng tải lên file Excel hợp lệ (.xlsx hoặc .xls).', 'dich-vu-phong-kham' ) . '</p></div>';
        } else {
            global $wpdb;
            $table_name = $wpdb->prefix . 'dich_vu_phong_kham';

            // Đọc file Excel
            require_once ABSPATH . 'vendor/autoload.php'; // Đảm bảo PhpSpreadsheet được tải

            try {
                $spreadsheet = IOFactory::load( $file['tmp_name'] );
                $sheet       = $spreadsheet->getActiveSheet();
                $rows        = $sheet->toArray();

                $row_count = 0;

                foreach ( $rows as $index => $row ) {
                    // Bỏ qua dòng tiêu đề
                    if ( $index === 0 ) {
                        continue;
                    }

                    // Lấy dữ liệu từ các cột
                    $name      = sanitize_text_field( $row[0] );
                    $phone     = sanitize_text_field( $row[1] );
                    $price     = floatval( $row[2] );
                    $specialty = sanitize_text_field( $row[3] );

                    // Thêm vào cơ sở dữ liệu
                    $wpdb->insert(
                        $table_name,
                        array(
                            'name'      => $name,
                            'phone'     => $phone,
                            'price'     => $price,
                            'specialty' => $specialty,
                        ),
                        array( '%s', '%s', '%f', '%s' )
                    );

                    $row_count++;
                }

                echo '<div class="notice notice-success"><p>' . sprintf( esc_html__( 'Import thành công %d dịch vụ.', 'dich-vu-phong-kham' ), $row_count ) . '</p></div>';
            } catch ( Exception $e ) {
                echo '<div class="notice notice-error"><p>' . esc_html__( 'Đã xảy ra lỗi khi đọc file Excel.', 'dich-vu-phong-kham' ) . '</p></div>';
            }
        }
    }

    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Import Dịch Vụ', 'dich-vu-phong-kham' ); ?></h1>
        <form method="post" enctype="multipart/form-data">
            <?php wp_nonce_field( 'dich_vu_phong_kham_import_action', 'dich_vu_phong_kham_import_nonce' ); ?>
            <table class="form-table">
                <tr>
                    <th><label for="excel_file"><?php esc_html_e( 'Tải lên file Excel', 'dich-vu-phong-kham' ); ?></label></th>
                    <td><input type="file" name="excel_file" id="excel_file" accept=".xlsx, .xls" required></td>
                </tr>
            </table>
            <?php submit_button( esc_html__( 'Import', 'dich-vu-phong-kham' ) ); ?>
        </form>
    </div>
    <?php
}

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('bootstrap5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', [], null, true);
});

// Shortcode: [dich_vu_phong_kham]
add_shortcode('dich_vu_phong_kham', 'dich_vu_phong_kham_shortcode_display');

function dich_vu_phong_kham_shortcode_display() {
    global $wpdb;

    // Số lượng dịch vụ hiển thị trên mỗi trang
    $services_per_page = 8;

    // Lấy danh sách chuyên khoa (các tab)
    $table_name = $wpdb->prefix . 'dich_vu_phong_kham';
    $specialties = $wpdb->get_col("SELECT DISTINCT specialty FROM $table_name");

    if (empty($specialties)) {
        return '<p>Không có dịch vụ nào được tìm thấy.</p>';
    }

    // Lấy chuyên khoa hiện tại từ query string, mặc định là chuyên khoa đầu tiên
    $current_specialty = isset($_GET['specialty']) ? sanitize_text_field($_GET['specialty']) : $specialties[0];

    // Lấy số trang hiện tại từ query string, mặc định là 1
    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;

    // Tính toán OFFSET
    $offset = ($current_page - 1) * $services_per_page;

    // Lấy tổng số dịch vụ cho chuyên khoa hiện tại
    $total_services = $wpdb->get_var(
        $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE specialty = %s", $current_specialty)
    );
    $total_pages = ceil($total_services / $services_per_page);

    // Lấy danh sách dịch vụ cho chuyên khoa hiện tại
    $services = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table_name WHERE specialty = %s ORDER BY created_at DESC LIMIT %d OFFSET %d",
            $current_specialty,
            $services_per_page,
            $offset
        ),
        ARRAY_A
    );

    ob_start();
    ?>

    <div class="container my-5">
        <h2 class="section-title text-start mb-4">Gói dịch vụ</h2>

        <!-- Tabs -->
        <ul class="nav nav-tabs" id="serviceTabs" role="tablist">
            <?php foreach ($specialties as $index => $specialty): ?>
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?php echo $specialty === $current_specialty ? 'active' : ''; ?>" id="tab-<?php echo esc_attr($specialty); ?>" href="?specialty=<?php echo urlencode($specialty); ?>" role="tab">
                        <?php echo esc_html($specialty); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="serviceTabsContent">
            <div class="tab-pane fade show active" id="content-<?php echo esc_attr($current_specialty); ?>" role="tabpanel">
                <div class="row g-4 mt-4">
                    <?php if (!empty($services)): ?>
                        <?php foreach ($services as $sv): ?>
                            <div class="col-md-6 col-lg-3">
                                <div class="card h-100 shadow-sm">
                                    <img src="https://demo.dongtamcorp.com/wp-content/uploads/2024/12/logo-dong-tam-corp-2024-02-800x800.png" class="card-img-top" alt="<?php echo esc_attr($sv['name']); ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo esc_html($sv['name']); ?></h5>
                                        <p class="text-danger fw-bold">Liên hệ báo giá</p>
                                        <p class="small">Chuyên khoa: <?php echo esc_html($sv['specialty']); ?></p>
                                    </div>
                                    <div class="card-footer border-0 bg-transparent">
                                        <a href="tel:<?php echo esc_attr($sv['phone']); ?>" class="btn btn-danger w-100">📞 Gọi <?php echo esc_html($sv['phone']); ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Không có dịch vụ nào trong chuyên khoa này.</p>
                    <?php endif; ?>
                </div>

                <!-- Phân trang -->
                <?php if ($total_pages > 1): ?>
                    <nav class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php if ($current_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?specialty=<?php echo urlencode($current_specialty); ?>&paged=<?php echo $current_page - 1; ?>" aria-label="Trang trước">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php echo ($i === $current_page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?specialty=<?php echo urlencode($current_specialty); ?>&paged=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($current_page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?specialty=<?php echo urlencode($current_specialty); ?>&paged=<?php echo $current_page + 1; ?>" aria-label="Trang sau">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>

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
