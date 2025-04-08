<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Service_List_Table extends WP_List_Table {

    // Định nghĩa các cột trong bảng
    public function get_columns() {
        return array(
            'cb'         => '<input type="checkbox" />',
            'name'       => esc_html__( 'Tên Dịch Vụ', 'dich-vu-phong-kham' ),
            'phone'      => esc_html__( 'Số Điện Thoại', 'dich-vu-phong-kham' ),
            'price'      => esc_html__( 'Giá', 'dich-vu-phong-kham' ),
            'specialty'  => esc_html__( 'Chuyên Khoa', 'dich-vu-phong-kham' ),
            'created_at' => esc_html__( 'Ngày Tạo', 'dich-vu-phong-kham' ),
            'actions'    => esc_html__( 'Hành Động', 'dich-vu-phong-kham' ),
        );
    }

    // Chuẩn bị dữ liệu cho bảng
    public function prepare_items() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'dich_vu_phong_kham';

        // Truy vấn dữ liệu từ cơ sở dữ liệu
        $query = "SELECT * FROM $table_name";
        $data  = $wpdb->get_results( $query );

        // Gán dữ liệu vào bảng
        $this->_column_headers = array( $this->get_columns(), array(), array() );
        $this->items           = $data;
    }

    // Hiển thị cột "Tên Dịch Vụ"
    public function column_name( $item ) {
        return esc_html( $item->name );
    }

    // Hiển thị cột "Số Điện Thoại"
    public function column_phone( $item ) {
        return esc_html( $item->phone );
    }

    // Hiển thị cột "Giá"
    public function column_price( $item ) {
        return esc_html( number_format( $item->price, 2 ) ) . ' VND';
    }

    // Hiển thị cột "Ngày Tạo"
    public function column_created_at( $item ) {
        return esc_html( date( 'Y-m-d H:i:s', strtotime( $item->created_at ) ) );
    }

    public function column_specialty( $item ) {
        return esc_html( $item->specialty );
    }

    public function column_actions( $item ) {
        $edit_url = admin_url( 'admin.php?page=dich_vu_phong_kham_edit&id=' . $item->id );
        $delete_url = admin_url( 'admin.php?page=dich_vu_phong_kham_delete&id=' . $item->id );

        return sprintf(
            '<a href="%s">%s</a> | <a href="%s" onclick="return confirm(\'%s\');">%s</a>',
            esc_url( $edit_url ),
            esc_html__( 'Sửa', 'dich-vu-phong-kham' ),
            esc_url( $delete_url ),
            esc_html__( 'Bạn có chắc chắn muốn xóa dịch vụ này?', 'dich-vu-phong-kham' ),
            esc_html__( 'Xóa', 'dich-vu-phong-kham' )
        );
    }
}

// Hiển thị bảng trong trang quản trị
function dich_vu_phong_kham_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Bạn không có quyền truy cập vào trang này.', 'dich-vu-phong-kham' ) );
    }

    // URL để thêm mới dịch vụ
    $add_new_url = admin_url( 'admin.php?page=dich_vu_phong_kham_add' );
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline"><?php esc_html_e( 'Danh Sách Dịch Vụ', 'dich-vu-phong-kham' ); ?></h1>
        <a href="<?php echo esc_url( $add_new_url ); ?>" class="page-title-action"><?php esc_html_e( 'Thêm Mới', 'dich-vu-phong-kham' ); ?></a>
        <hr class="wp-header-end">

        <form method="post">
            <?php
            $service_table = new Service_List_Table();
            $service_table->prepare_items();
            $service_table->display();
            ?>
        </form>
    </div>
    <?php
}

if ( ! function_exists( 'dich_vu_phong_kham_add_page' ) ) {
    function dich_vu_phong_kham_add_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'Bạn không có quyền truy cập vào trang này.', 'dich-vu-phong-kham' ) );
        }

        global $wpdb;

        // Xử lý thêm mới dịch vụ
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['dich_vu_phong_kham_add_nonce'] ) ) {
            if ( wp_verify_nonce( $_POST['dich_vu_phong_kham_add_nonce'], 'dich_vu_phong_kham_add_action' ) ) {
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

                // Chuyển hướng về trang danh sách dịch vụ
                wp_safe_redirect( admin_url( 'admin.php?page=dich_vu_phong_kham' ) );
                exit; // Dừng thực thi sau khi chuyển hướng
            }
        }

        // Hiển thị form thêm mới dịch vụ
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
                                <option value="Sản khoa"><?php esc_html_e( 'Sản khoa', 'dich-vu-phong-kham' ); ?></option>
                                <option value="Nhi khoa"><?php esc_html_e( 'Nhi khoa', 'dich-vu-phong-kham' ); ?></option>
                                <option value="Tim mạch"><?php esc_html_e( 'Tim mạch', 'dich-vu-phong-kham' ); ?></option>
                                <option value="Da liễu"><?php esc_html_e( 'Da liễu', 'dich-vu-phong-kham' ); ?></option>
                                <option value="Xét nghiệm"><?php esc_html_e( 'Xét nghiệm', 'dich-vu-phong-kham' ); ?></option>
                            </select>
                        </td>
                    </tr>
                </table>
                <?php submit_button( esc_html__( 'Thêm Mới', 'dich-vu-phong-kham' ) ); ?>
            </form>
        </div>
        <?php
    }
}

function dich_vu_phong_kham_edit_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Bạn không có quyền truy cập vào trang này.', 'dich-vu-phong-kham' ) );
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'dich_vu_phong_kham';

    // Lấy ID dịch vụ từ URL
    $id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

    // Lấy thông tin dịch vụ
    $service = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $id ) );

    if ( ! $service ) {
        echo '<div class="notice notice-error"><p>' . esc_html__( 'Dịch vụ không tồn tại.', 'dich-vu-phong-kham' ) . '</p></div>';
        return;
    }

    // Xử lý cập nhật dịch vụ
    if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['dich_vu_phong_kham_edit_nonce'] ) ) {
        if ( wp_verify_nonce( $_POST['dich_vu_phong_kham_edit_nonce'], 'dich_vu_phong_kham_edit_action' ) ) {
            $name      = sanitize_text_field( $_POST['name'] );
            $phone     = sanitize_text_field( $_POST['phone'] );
            $price     = floatval( $_POST['price'] );
            $specialty = sanitize_text_field( $_POST['specialty'] );

            $wpdb->update(
                $table_name,
                array(
                    'name'      => $name,
                    'phone'     => $phone,
                    'price'     => $price,
                    'specialty' => $specialty,
                ),
                array( 'id' => $id ),
                array( '%s', '%s', '%f', '%s' ),
                array( '%d' )
            );

            // Chuyển hướng về trang danh sách dịch vụ
            wp_safe_redirect( admin_url( 'admin.php?page=dich_vu_phong_kham' ) );
            exit;
        }
    }

    // Hiển thị form sửa dịch vụ
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Sửa Dịch Vụ', 'dich-vu-phong-kham' ); ?></h1>
        <form method="post">
            <?php wp_nonce_field( 'dich_vu_phong_kham_edit_action', 'dich_vu_phong_kham_edit_nonce' ); ?>
            <table class="form-table">
                <tr>
                    <th><label for="name"><?php esc_html_e( 'Tên Dịch Vụ', 'dich-vu-phong-kham' ); ?></label></th>
                    <td><input type="text" name="name" id="name" class="regular-text" value="<?php echo esc_attr( $service->name ); ?>" required></td>
                </tr>
                <tr>
                    <th><label for="phone"><?php esc_html_e( 'Số Điện Thoại', 'dich-vu-phong-kham' ); ?></label></th>
                    <td><input type="text" name="phone" id="phone" class="regular-text" value="<?php echo esc_attr( $service->phone ); ?>" required></td>
                </tr>
                <tr>
                    <th><label for="price"><?php esc_html_e( 'Giá', 'dich-vu-phong-kham' ); ?></label></th>
                    <td><input type="number" name="price" id="price" class="regular-text" step="0.01" value="<?php echo esc_attr( $service->price ); ?>" required></td>
                </tr>
                <tr>
                    <th><label for="specialty"><?php esc_html_e( 'Chuyên Khoa', 'dich-vu-phong-kham' ); ?></label></th>
                    <td>
                        <select name="specialty" id="specialty" class="regular-text" required>
                            <option value=""><?php esc_html_e( 'Chọn Chuyên Khoa', 'dich-vu-phong-kham' ); ?></option>
                            <option value="Sản khoa" <?php selected( $service->specialty, 'Sản khoa' ); ?>><?php esc_html_e( 'Sản khoa', 'dich-vu-phong-kham' ); ?></option>
                            <option value="Nhi khoa" <?php selected( $service->specialty, 'Nhi khoa' ); ?>><?php esc_html_e( 'Nhi khoa', 'dich-vu-phong-kham' ); ?></option>
                            <option value="Tim mạch" <?php selected( $service->specialty, 'Tim mạch' ); ?>><?php esc_html_e( 'Tim mạch', 'dich-vu-phong-kham' ); ?></option>
                            <option value="Da liễu" <?php selected( $service->specialty, 'Da liễu' ); ?>><?php esc_html_e( 'Da liễu', 'dich-vu-phong-kham' ); ?></option>
                            <option value="Xét nghiệm" <?php selected( $service->specialty, 'Xét nghiệm' ); ?>><?php esc_html_e( 'Xét nghiệm', 'dich-vu-phong-kham' ); ?></option>
                        </select>
                    </td>
                </tr>
            </table>
            <?php submit_button( esc_html__( 'Cập Nhật', 'dich-vu-phong-kham' ) ); ?>
        </form>
    </div>
    <?php
}

function dich_vu_phong_kham_delete_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Bạn không có quyền truy cập vào trang này.', 'dich-vu-phong-kham' ) );
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'dich_vu_phong_kham';

    // Lấy ID dịch vụ từ URL
    $id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

    // Xóa dịch vụ
    $wpdb->delete( $table_name, array( 'id' => $id ), array( '%d' ) );

    // Chuyển hướng về trang danh sách dịch vụ
    wp_safe_redirect( admin_url( 'admin.php?page=dich_vu_phong_kham' ) );
    exit;
}

add_action( 'admin_menu', function() {
    add_submenu_page(
        null,
        esc_html__( 'Sửa Dịch Vụ', 'dich-vu-phong-kham' ),
        esc_html__( 'Sửa', 'dich-vu-phong-kham' ),
        'manage_options',
        'dich_vu_phong_kham_edit',
        'dich_vu_phong_kham_edit_page'
    );

    add_submenu_page(
        null,
        esc_html__( 'Xóa Dịch Vụ', 'dich-vu-phong-kham' ),
        esc_html__( 'Xóa', 'dich-vu-phong-kham' ),
        'manage_options',
        'dich_vu_phong_kham_delete',
        'dich_vu_phong_kham_delete_page'
    );
});
