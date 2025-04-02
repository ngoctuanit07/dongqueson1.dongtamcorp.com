<?php
/*
 * Template Name: Contact Page
 */
get_header(); ?>

<div class="container my-5">
    <div class="row">
        <!-- Cột bên trái: Thông tin liên hệ -->
        <div class="col-md-4">
            <h2 class="text-danger">LIÊN HỆ</h2>
            <h3 class="text-dark">Phòng Khám Đồng Tâm Sài Gòn</h3>
            <p><strong>Địa chỉ:</strong> 46 Lý Thường Kiệt, Phường Tân Thạnh, Tam Kỳ, Quảng Nam</p>
            <p><strong>Điện thoại:</strong> 02353 845 717</p>
            <p><strong>Cấp cứu:</strong> 02353 845 900</p>
            <p><strong>Email:</strong> bvphusannhiquangnam@gmail.com</p>
            
            <!-- Bản đồ Google Maps -->
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3855.123456789!2d108.478123456789!3d15.567123456789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTXCsDM0JzAxLjYiTiAxMDjCsDI4JzQxLjIiRQ!5e0!3m2!1svi!2s!4v169876543210!5m2!1svi!2s" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>

        <!-- Cột bên phải: Form liên hệ -->
        <div class="col-md-8">
            <div class="card p-4">
                <p class="text-muted">Quý khách vui lòng điền thông tin vào mẫu bên dưới và gửi những góp ý, thắc mắc cho Phòng Khám Đồng Tâm Sài Gòn, chúng tôi sẽ phản hồi Quý khách trong thời gian sớm nhất.</p>
                
                <!-- Form liên hệ -->
                <?php echo do_shortcode('[contact-form-7 id="edc5b92" title="Contact form 1"]'); ?>
            </div>
        </div>
    </div>
</div>

<!-- CSS tùy chỉnh -->
<style>
    .map-container {
        margin-top: 20px;
    }
    .card {
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .btn-primary {
        background-color: #f28c38;
        border-color: #f28c38;
    }
    .btn-primary:hover {
        background-color: #e07b30;
        border-color: #e07b30;
    }
</style>

<?php get_footer(); ?>