</div><!-- /.container -->

<?php
$options = get_option( 'dongqueson_theme_options' );
$footer_logo = ! empty( $options['footer_logo']['url'] ) ? $options['footer_logo']['url'] : '';
$footer_bg_color = ! empty( $options['footer_bg_color'] ) ? $options['footer_bg_color'] : '#343a40';
$footer_text_color = ! empty( $options['footer_text_color'] ) ? $options['footer_text_color'] : '#ffffff';
$footer_copyright = ! empty( $options['footer_copyright'] ) ? $options['footer_copyright'] : 'Copyright 2025 © Phòng khám Đồng Tâm Sài Gòn';
$social_links = ! empty( $options['social_links'] ) ? $options['social_links'] : array();
$google_maps_url = ! empty( $options['google_maps_url'] ) ? $options['google_maps_url'] : 'https://www.google.com/maps';
?>
<footer class="footer-section text-white" style="background-color: <?php echo esc_attr( $footer_bg_color ); ?>;">
    <div class="container py-4 py-md-5">
        <div class="row gy-4 align-items-stretch">
            <!-- Logo Footer -->
            <div class="col-12 col-md-4 footer-logo d-flex flex-column justify-content-center align-items-center align-items-md-start text-center text-md-start h-100">
                <h1 class="text-uppercase fw-bold fs-5 fs-md-4 mb-3">PHÒNG KHÁM ĐỒNG TÂM SÀI GÒN</h1>
                <p class="small mb-0" style="color: <?php echo esc_attr($footer_text_color); ?>; max-width: 320px;">
                    <?php esc_html_e( 'Chúng tôi luôn sẵn sàng phục vụ bạn với đội ngũ chuyên môn tận tâm và chuyên nghiệp.', 'dongqueson' ); ?>
                </p>
            </div>

            <!-- Hoạt động -->
            <div class="col-12 col-md-3 footer-activity h-100 d-flex flex-column justify-content-center">
                <h5 class="fw-bold text-uppercase mb-3">Hoạt động</h5>
                <ul class="list-unstyled mb-0">
                    <li><a href="#" class="text-decoration-none text-white-50"><i class="bi bi-chevron-right me-2"></i>Thông tin Phòng Khám</a></li>
                    <li><a href="#" class="text-decoration-none text-white-50"><i class="bi bi-chevron-right me-2"></i>Đội ngũ chuyên môn</a></li>
                    <li><a href="#" class="text-decoration-none text-white-50"><i class="bi bi-chevron-right me-2"></i>Lịch khám bệnh</a></li>
                    <li><a href="#" class="text-decoration-none text-white-50"><i class="bi bi-chevron-right me-2"></i>Hỏi đáp sức khỏe</a></li>
                    <li><a href="#" class="text-decoration-none text-white-50"><i class="bi bi-chevron-right me-2"></i>Thu viện phí</a></li>
                </ul>
            </div>

            <!-- Mạng xã hội và Google Maps -->
            <div class="col-12 col-md-4 footer-social text-center text-md-start h-100 d-flex flex-column justify-content-center">
                <h5 class="fw-bold text-uppercase mb-3">Xem bản đồ</h5>
                <iframe 
                    src="<?php echo esc_url( $google_maps_url ); ?>" 
                    width="100%" 
                    height="180" 
                    style="border:0; border-radius: 8px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                <!--
                <div class="social-icons mt-4">
                    <?php foreach ( $social_links as $social ) : ?>
                        <a href="<?php echo esc_url( $social['social_url'] ); ?>" class="text-white me-3" target="_blank" rel="noopener">
                            <i class="<?php echo esc_attr( $social['social_icon'] ); ?> fs-4"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
                -->
            </div>
        </div>

        <div class="footer-bottom text-center mt-4 pt-3 border-top border-light-subtle">
            <p class="mb-0 small" style="color: <?php echo esc_attr($footer_text_color); ?>;">
                <?php echo wp_kses_post( $footer_copyright ); ?>
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
