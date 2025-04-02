<?php
// Register shortcode
add_shortcode('custom_data_table', 'custom_data_shortcode');

function custom_data_shortcode($atts) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_data';
    
    // Get search and filter from shortcode attributes or GET
    $atts = shortcode_atts(array(
        'search' => '',
        'co_quan' => ''
    ), $atts);
    
    $search = sanitize_text_field($atts['search'] ?: (isset($_GET['search']) ? $_GET['search'] : ''));
    $filter_co_quan = sanitize_text_field($atts['co_quan'] ?: (isset($_GET['co_quan']) ? $_GET['co_quan'] : ''));
    
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
    
    if (empty($results)) {
        return '<p>Không có dữ liệu để hiển thị.</p>';
    }
    
    // Bắt đầu tạo HTML theo cấu trúc yêu cầu
    $output = '<ul class="list-unstyled yte mb-0">';
    
    // Duyệt qua từng dòng dữ liệu và hiển thị trich_yeu_noi_dung bọc trong thẻ a nếu có link
    foreach ($results as $row) {
        $content = esc_html($row->trich_yeu_noi_dung); // Nội dung chính
        $link = esc_url($row->link_van_ban); // Link nếu có
        
        // Nếu có link, bọc toàn bộ trich_yeu_noi_dung trong thẻ <a>
        if (!empty($link)) {
            $output .= '<li><a href="' . $link . '" target="_blank">' . $content . '</a></li>';
        } else {
            $output .= '<li>' . $content . '</li>'; // Nếu không có link, hiển thị bình thường
        }
    }
    
    $output .= '</ul>';
    
    return $output;
}