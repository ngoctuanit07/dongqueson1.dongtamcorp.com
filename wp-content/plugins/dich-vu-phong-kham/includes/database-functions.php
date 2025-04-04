<?php
global $wpdb;
$table_name = $wpdb->prefix . 'dich_vu_phong_kham';

// Thêm dịch vụ
function add_service($name, $phone, $price) {
    global $wpdb;
    $wpdb->insert(
        $table_name,
        array(
            'name' => sanitize_text_field($name),
            'phone' => sanitize_text_field($phone),
            'price' => floatval($price)
        )
    );
}

// Sửa dịch vụ
function update_service($id, $name, $phone, $price) {
    global $wpdb;
    $wpdb->update(
        $table_name,
        array(
            'name' => sanitize_text_field($name),
            'phone' => sanitize_text_field($phone),
            'price' => floatval($price)
        ),
        array('id' => intval($id))
    );
}

// Xóa dịch vụ
function delete_service($id) {
    global $wpdb;
    $wpdb->delete($table_name, array('id' => intval($id)));
}
