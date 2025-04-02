<?php
// Admin grid and CRUD functionality
function custom_data_plugin_grid_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_data';
    
    // Handle CRUD operations
    if (isset($_POST['action']) && wp_verify_nonce($_POST['custom_data_nonce'], 'custom_data_action')) {
        $action = sanitize_text_field($_POST['action']);
        
        if ($action == 'create' || $action == 'update') {
            $data = array(
                'so_hieu' => sanitize_text_field($_POST['so_hieu']),
                'trich_yeu_noi_dung' => sanitize_textarea_field($_POST['trich_yeu_noi_dung']),
                'co_quan' => sanitize_text_field($_POST['co_quan']),
                'ngay_ban' => date('Y-m-d', strtotime($_POST['ngay_ban'])),
                'link_van_ban' => esc_url_raw($_POST['link_van_ban'])
            );
            
            if ($action == 'create') {
                $wpdb->insert($table_name, $data);
            } else if ($action == 'update' && isset($_POST['id'])) {
                $wpdb->update($table_name, $data, array('id' => intval($_POST['id'])));
            }
        } elseif ($action == 'delete' && isset($_GET['id'])) {
            $wpdb->delete($table_name, array('id' => intval($_GET['id'])));
        }
    }
    
    // Search and filter
    $search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
    $filter_co_quan = isset($_GET['co_quan']) ? sanitize_text_field($_GET['co_quan']) : '';
    
    $where = array();
    if ($search) {
        $where[] = "so_hieu LIKE '%$search%' OR trich_yeu_noi_dung LIKE '%$search%' OR co_quan LIKE '%$search%'";
    }
    if ($filter_co_quan) {
        $where[] = "co_quan = '$filter_co_quan'";
    }
    
    $where_clause = '';
    if (!empty($where)) {
        $where_clause = 'WHERE ' . implode(' AND ', $where);
    }
    
    $results = $wpdb->get_results("SELECT * FROM $table_name $where_clause ORDER BY ngay_ban DESC");
    
    // Get unique agencies for filter
    $agencies = $wpdb->get_col("SELECT DISTINCT co_quan FROM $table_name ORDER BY co_quan");
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        
        <!-- Search and Filter Form -->
        <form method="GET" action="">
            <input type="hidden" name="page" value="custom-data-plugin">
            <label for="search">Tìm kiếm:</label>
            <input type="text" name="search" id="search" value="<?php echo esc_attr($search); ?>">
            
            <label for="co_quan">Cơ quan:</label>
            <select name="co_quan" id="co_quan">
                <option value="">Tất cả</option>
                <?php foreach ($agencies as $agency): ?>
                    <option value="<?php echo esc_attr($agency); ?>" <?php selected($filter_co_quan, $agency); ?>>
                        <?php echo esc_html($agency); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Lọc">
        </form>
        
        <!-- Data Grid -->
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Số hiệu</th>
                    <th>Trích yếu nội dung</th>
                    <th>Cơ quan</th>
                    <th>Ngày ban hành</th>
                    <th>Link văn bản</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($results)): ?>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?php echo esc_html($row->so_hieu); ?></td>
                            <td><?php echo esc_html($row->trich_yeu_noi_dung); ?></td>
                            <td><?php echo esc_html($row->co_quan); ?></td>
                            <td><?php echo esc_html(date('d/m/Y', strtotime($row->ngay_ban))); ?></td>
                            <td><a href="<?php echo esc_url($row->link_van_ban); ?>" target="_blank">Xem link</a></td>
                            <td>
                                <a href="#" class="edit-row" data-id="<?php echo $row->id; ?>">Sửa</a> |
                                <a href="?page=custom-data-plugin&action=delete&id=<?php echo $row->id; ?>" 
                                   onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">Không có dữ liệu.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <!-- Add/Edit Form (Modal or Inline) -->
        <button id="add-new-btn">Thêm mới</button>
        
        <div id="data-form-modal" style="display:none;">
            <form method="post" action="">
                <?php wp_nonce_field('custom_data_action', 'custom_data_nonce'); ?>
                <input type="hidden" name="action" id="form-action" value="create">
                <input type="hidden" name="id" id="form-id">
                
                <label for="so_hieu">Số hiệu</label>
                <input type="text" name="so_hieu" id="so_hieu" required>
                
                <label for="trich_yeu_noi_dung">Trích yếu nội dung</label>
                <textarea name="trich_yeu_noi_dung" id="trich_yeu_noi_dung" rows="5" required></textarea>
                
                <label for="co_quan">Cơ quan</label>
                <input type="text" name="co_quan" id="co_quan" required>
                
                <label for="ngay_ban">Ngày ban hành</label>
                <input type="date" name="ngay_ban" id="ngay_ban" required>
                
                <label for="link_van_ban">Link văn bản</label>
                <input type="url" name="link_van_ban" id="link_van_ban">
                
                <input type="submit" value="Lưu">
                <button type="button" id="close-form">Đóng</button>
            </form>
        </div>
    </div>
    
    <script>
        jQuery(document).ready(function($) {
            // Open add/edit form
            $('#add-new-btn, .edit-row').click(function(e) {
                e.preventDefault();
                if ($(this).hasClass('edit-row')) {
                    var id = $(this).data('id');
                    $.get(ajaxurl, {action: 'get_custom_data', id: id}, function(response) {
                        var data = JSON.parse(response);
                        $('#form-id').val(data.id);
                        $('#form-action').val('update');
                        $('#so_hieu').val(data.so_hieu);
                        $('#trich_yeu_noi_dung').val(data.trich_yeu_noi_dung);
                        $('#co_quan').val(data.co_quan);
                        $('#ngay_ban').val(data.ngay_ban);
                        $('#link_van_ban').val(data.link_van_ban);
                    });
                } else {
                    $('#form-id').val('');
                    $('#form-action').val('create');
                    $('#so_hieu, #trich_yeu_noi_dung, #co_quan, #ngay_ban, #link_van_ban').val('');
                }
                $('#data-form-modal').show();
            });
            
            // Close form
            $('#close-form').click(function() {
                $('#data-form-modal').hide();
            });
        });
    </script>
    
    <?php
}

// AJAX to get data for editing
add_action('wp_ajax_get_custom_data', 'custom_data_ajax_get');

function custom_data_ajax_get() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_data';
    $id = intval($_GET['id']);
    $row = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id");
    echo json_encode($row);
    wp_die();
}