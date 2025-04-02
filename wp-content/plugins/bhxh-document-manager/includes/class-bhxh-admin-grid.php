<?php
class BHXH_Admin_Grid {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    public function add_admin_menu() {
        add_menu_page(
            'BHXH Documents',
            'BHXH Documents',
            'manage_options',
            'bhxh-documents',
            array($this, 'render_admin_page')
        );
    }

    public function enqueue_scripts() {
        wp_enqueue_style('bhxh-admin-css', plugins_url('/css/admin.css', __FILE__));
        wp_enqueue_script('bhxh-admin-js', plugins_url('/js/admin.js', __FILE__), array('jquery'), null, true);
    }

    public function render_admin_page() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'bhxh_documents';

        // Xử lý CRUD
        if (isset($_POST['action']) && check_admin_referer('bhxh_crud')) {
            if ($_POST['action'] == 'add') {
                $wpdb->insert($table_name, array(
                    'so_hieu' => sanitize_text_field($_POST['so_hieu']),
                    'link_van_ban' => esc_url_raw($_POST['link_van_ban']),
                    'noi_dung' => sanitize_textarea_field($_POST['noi_dung'])
                ));
            }
            // Thêm xử lý update, delete tương tự
        }

        $documents = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
        ?>
        <div class="wrap">
            <h1>Quản lý văn bản BHXH</h1>
            <!-- Form thêm mới -->
            <form method="post">
                <?php wp_nonce_field('bhxh_crud'); ?>
                <input type="hidden" name="action" value="add">
                <table class="form-table">
                    <tr>
                        <th>Số hiệu</th>
                        <td><input type="text" name="so_hieu" required></td>
                    </tr>
                    <tr>
                        <th>Link văn bản</th>
                        <td><input type="url" name="link_van_ban" required></td>
                    </tr>
                    <tr>
                        <th>Nội dung</th>
                        <td><textarea name="noi_dung" required></textarea></td>
                    </tr>
                </table>
                <p class="submit"><input type="submit" class="button-primary" value="Thêm mới"></p>
            </form>

            <!-- Grid hiển thị -->
            <table class="wp-list-table widefat">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Số hiệu</th>
                        <th>Link văn bản</th>
                        <th>Nội dung</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($documents as $doc): ?>
                        <tr>
                            <td><?php echo $doc['id']; ?></td>
                            <td><?php echo esc_html($doc['so_hieu']); ?></td>
                            <td><a href="<?php echo esc_url($doc['link_van_ban']); ?>" target="_blank">Xem</a></td>
                            <td><?php echo esc_html($doc['noi_dung']); ?></td>
                            <td>
                                <a href="#">Sửa</a> | 
                                <a href="#">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}