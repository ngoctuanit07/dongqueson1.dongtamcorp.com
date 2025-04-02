<?php
// Register REST API endpoint
add_action('rest_api_init', function () {
    register_rest_route('custom-data/v1', '/save', array(
        'methods' => 'POST',
        'callback' => 'custom_data_rest_save',
        'permission_callback' => function () {
            return current_user_can('edit_posts');
        }
    ));
    
    register_rest_route('custom-data/v1', '/update/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'custom_data_rest_update',
        'permission_callback' => function () {
            return current_user_can('edit_posts');
        }
    ));
    
    register_rest_route('custom-data/v1', '/delete/(?P<id>\d+)', array(
        'methods' => 'DELETE',
        'callback' => 'custom_data_rest_delete',
        'permission_callback' => function () {
            return current_user_can('edit_posts');
        }
    ));
});

function custom_data_rest_save($request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_data';
    
    $params = $request->get_params();
    
    $data = array(
        'so_hieu' => sanitize_text_field($params['so_hieu']),
        'trich_yeu_noi_dung' => sanitize_textarea_field($params['trich_yeu_noi_dung']),
        'co_quan' => sanitize_text_field($params['co_quan']),
        'ngay_ban' => date('Y-m-d', strtotime($params['ngay_ban'])),
        'link_van_ban' => esc_url_raw($params['link_van_ban'])
    );
    
    $result = $wpdb->insert($table_name, $data);
    
    if ($result) {
        return new WP_REST_Response(array('message' => 'Data saved successfully', 'id' => $wpdb->insert_id), 201);
    } else {
        return new WP_REST_Response(array('message' => 'Error saving data'), 500);
    }
}

function custom_data_rest_update($request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_data';
    $id = $request->get_param('id');
    
    $params = $request->get_params();
    
    $data = array(
        'so_hieu' => sanitize_text_field($params['so_hieu']),
        'trich_yeu_noi_dung' => sanitize_textarea_field($params['trich_yeu_noi_dung']),
        'co_quan' => sanitize_text_field($params['co_quan']),
        'ngay_ban' => date('Y-m-d', strtotime($params['ngay_ban'])),
        'link_van_ban' => esc_url_raw($params['link_van_ban'])
    );
    
    $result = $wpdb->update($table_name, $data, array('id' => $id));
    
    if ($result !== false) {
        return new WP_REST_Response(array('message' => 'Data updated successfully'), 200);
    } else {
        return new WP_REST_Response(array('message' => 'Error updating data'), 500);
    }
}

function custom_data_rest_delete($request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_data';
    $id = $request->get_param('id');
    
    $result = $wpdb->delete($table_name, array('id' => $id));
    
    if ($result) {
        return new WP_REST_Response(array('message' => 'Data deleted successfully'), 200);
    } else {
        return new WP_REST_Response(array('message' => 'Error deleting data'), 500);
    }
}