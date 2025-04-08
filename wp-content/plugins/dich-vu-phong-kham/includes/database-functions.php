<?php
global $wpdb;
$table_name = $wpdb->prefix . 'dich_vu_phong_kham';

// Thêm dịch vụ
function add_service($name, $phone, $price, $specialty) {
    global $wpdb;
    $wpdb->insert(
        $wpdb->prefix . 'dich_vu_phong_kham',
        array(
            'name'      => sanitize_text_field($name),
            'phone'     => sanitize_text_field($phone),
            'price'     => floatval($price),
            'specialty' => sanitize_text_field($specialty), // Thêm cột specialty
        ),
        array('%s', '%s', '%f', '%s') // Định dạng dữ liệu
    );
}

// Sửa dịch vụ
function update_service($id, $name, $phone, $price, $specialty) {
    global $wpdb;
    $wpdb->update(
        $wpdb->prefix . 'dich_vu_phong_kham',
        array(
            'name'      => sanitize_text_field($name),
            'phone'     => sanitize_text_field($phone),
            'price'     => floatval($price),
            'specialty' => sanitize_text_field($specialty), // Thêm cột specialty
        ),
        array('id' => intval($id)),
        array('%s', '%s', '%f', '%s'), // Định dạng dữ liệu
        array('%d') // Định dạng điều kiện
    );
}

// Xóa dịch vụ
function delete_service($id) {
    global $wpdb;
    $wpdb->delete(
        $wpdb->prefix . 'dich_vu_phong_kham',
        array('id' => intval($id)),
        array('%d') // Định dạng điều kiện
    );
}
