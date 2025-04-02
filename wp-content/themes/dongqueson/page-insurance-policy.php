<?php
/*
 * Template Name: Insurance Policy Page
 */
get_header(); ?>

<div class="container my-5">
    <div class="row">
        <!-- Cột bên trái: Thông tin chính sách bảo hiểm y tế -->
        <div class="col-md-8">
            <h2 class="text-danger mb-4">Chính sách bảo hiểm y tế</h2>
            <h3 class="text-dark mb-3">Thông tin về chính sách khám chữa bệnh BHYT</h3>
            <p>
                Bệnh viện Phụ sản - Nhi Quảng Nam không ngừng cải tiến để đáp ứng nhu cầu khám chữa bệnh của các đối tượng có bảo hiểm y tế và bảo lãnh viện phí trực tiếp với nhiều loại hình bảo hiểm khác nhau trong và ngoài nước.
            </p>
            <p>
                Nếu công ty cung cấp dịch vụ bảo hiểm của Quý khách hàng nằm trong danh sách các công ty hợp tác với Bệnh viện Phụ sản - Nhi Quảng Nam, chúng tôi sẽ liên hệ, chụp nhận thanh toán trực tiếp với công ty bảo hiểm để Quý khách hàng yên tâm hơn khi đến khám chữa bệnh tại Bệnh viện.
            </p>
            <p>
                <strong>Chứng từ hướng tới:</strong> Tư tức nguồn gốc, thường xuyên - Thông tin minh bạch, chính xác - Giải đáp nhanh chóng, tư vấn quyen lợi bảo hiểm.
            </p>
        </div>

        <!-- Cột bên phải: Form gửi câu hỏi -->
        <div class="col-md-4">
            <div class="card p-4">
                <h5 class="text-danger mb-3">Gửi câu hỏi của bạn cho chúng tôi</h5>
                <p class="text-muted mb-4">Quý khách cần được thông tin hoặc sự trợ giúp, hãy gửi nội dung đến Bệnh viện Phụ sản - Nhi Quảng Nam</p>
                
                <!-- Form liên hệ -->
                <?php echo do_shortcode('[contact-form-7 id="edc5b92" title="Contact form 1"]'); ?>
            </div>
        </div>
    </div>
</div>

<!-- CSS tùy chỉnh -->
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border: none;
    }
    .btn-primary {
        background-color: #f28c38;
        border-color: #f28c38;
        border-radius: 50px;
        padding: 10px 20px;
    }
    .btn-primary:hover {
        background-color: #e07b30;
        border-color: #e07b30;
    }
    .form-control {
        border-radius: 20px;
        border: 1px solid #ced4da;
        margin-bottom: 15px;
    }
    textarea.form-control {
        border-radius: 10px;
    }
</style>
<?php get_footer(); ?>