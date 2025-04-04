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
