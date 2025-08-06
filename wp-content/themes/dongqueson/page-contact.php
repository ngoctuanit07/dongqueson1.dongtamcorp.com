<?php
/*
 * Template Name: Contact Page
 */
get_header(); ?>

<div class="container py-4 py-md-5">
    <div class="row justify-content-center align-items-stretch gy-4">
        <!-- Thông tin liên hệ -->
        <div class="col-12 col-lg-6 mb-3 mb-lg-0 d-flex flex-column justify-content-center">
            <div class="contact-info-box p-4 h-100 bg-white rounded shadow-sm">
                <h2 class="text-danger mb-3 mb-md-4 text-center text-lg-start">LIÊN HỆ</h2>
                <h3 class="text-dark mb-3 text-center text-lg-start">Phòng Khám Đồng Tâm Sài Gòn</h3>
                <p><strong>Địa chỉ:</strong> Thôn Hương Quế Đông, Quế Phú, Quế Sơn, Quảng Nam, Việt Nam</p>
                <p><strong>Điện thoại:</strong> 02353.655.666</p>
                <p><strong>Cấp cứu:</strong> 02353.655.666</p>
                <!-- Bản đồ Google Maps -->
                <div class="map-container mt-3 mt-md-4 rounded overflow-hidden">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3855.123456789!2d108.478123456789!3d15.567123456789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTXCsDM0JzAxLjYiTiAxMDjCsDI4JzQxLjIiRQ!5e0!3m2!1svi!2s!4v169876543210!5m2!1svi!2s" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
        <!-- Form liên hệ -->
        <div class="col-12 col-lg-5 d-flex align-items-center">
            <div class="card w-100 p-3 p-md-4 shadow-sm border-0">
                <p class="text-muted mb-3 text-center">Quý khách vui lòng điền thông tin vào mẫu bên dưới và gửi những góp ý, thắc mắc cho Phòng Khám Đồng Tâm Sài Gòn, chúng tôi sẽ phản hồi Quý khách trong thời gian sớm nhất.</p>
                <!-- Form liên hệ -->
                <?php echo do_shortcode('[contact-form-7 id="edc5b92" title="Contact form 1"]'); ?>
            </div>
        </div>
    </div>
</div>

<!-- CSS tùy chỉnh -->
<style>
    .contact-info-box {
        min-height: 100%;
    }
    .map-container iframe {
        border-radius: 10px;
        min-height: 200px;
        width: 100%;
        display: block;
    }
    .card {
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border: none;
        min-height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .btn-primary {
        background-color: #f28c38;
        border-color: #f28c38;
    }
    .btn-primary:hover {
        background-color: #e07b30;
        border-color: #e07b30;
    }
    @media (max-width: 991.98px) {
        .contact-info-box, .card {
            min-height: unset;
        }
    }
</style>

<?php get_footer(); ?>
