<?php
class BHXH_REST_API {
    public function __construct() {
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    public function register_routes() {
        register_rest_route('bhxh/v1', '/documents', array(
            'methods' => 'POST',
            'callback' => array($this, 'create_document'),
            'permission_callback' => function() {
                return current_user_can('manage_options'); // Yêu cầu quyền admin
            }
        ));

        register_rest_route('bhxh/v1', '/documents', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_documents'),
            'permission_callback' => '__return_true'
        ));
    }

    public function create_document($request) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'bhxh_documents';

        $data = array(
            'so_hieu' => sanitize_text_field($request['so_hieu']),
            'link_van_ban' => esc_url_raw($request['link_van_ban']),
            'noi_dung' => sanitize_textarea_field($request['noi_dung'])
        );

        $wpdb->insert($table_name, $data);
        return new WP_REST_Response('Document created', 201);
    }

    public function get_documents($request) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'bhxh_documents';
        $results = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
        return new WP_REST_Response($results, 200);
    }
}