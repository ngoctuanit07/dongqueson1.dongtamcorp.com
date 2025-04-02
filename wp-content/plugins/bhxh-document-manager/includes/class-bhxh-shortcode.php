<?php
class BHXH_Shortcode {
    public function __construct() {
        add_shortcode('bhxh_documents', array($this, 'render_documents'));
    }

    public function render_documents($atts) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'bhxh_documents';
        $documents = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

        $output = '<ul class="list-unstyled yte mb-0">';
        foreach ($documents as $doc) {
            $output .= sprintf(
                '<li><a href="%s">%s - %s</a></li>',
                esc_url($doc['link_van_ban']),
                esc_html($doc['so_hieu']),
                esc_html($doc['noi_dung'])
            );
        }
        $output .= '</ul>';

        return $output;
    }
}