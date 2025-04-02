<?php
/*
Template Name: Messages Page
*/
get_header(); ?>

<!-- Messages Section -->
<section class="messages-section py-5">
    <div class="container">
        <!-- Section Title -->
        <h2 class="section-title text-orange text-center mb-4">Thông điệp yêu thương</h2>
        <p class="text-center mb-5">Vội tìm yêu vào sự tận tâm, chung tôi biên mẫu khám sức khỏe chăm sóc trải thành niên vui, xóa tan mọi lo toan trên hành trình sức khỏe. Chúng tôi hạnh phúc vì cuộc sống bên trên niên từ hào lòng nhãn cuộc chung tôi. Bệnh viện Phụ Sản - Nhĩ Quảng Nam - Nơi nâng niu từng phút yêu thương cùng chung nhịp đập vui sức khỏe va hạnh phúc cuộc mỗi gia đình!</p>

        <!-- Messages Cards -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="message-card">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/message1.jpg" alt="Message 1" class="card-img-top">
                    <div class="card-body text-center">
                        <h5 class="card-title text-orange">Công hiến vào sự phát triển của trẻ Quảng Nam</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="message-card">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/message2.jpg" alt="Message 2" class="card-img-top">
                    <div class="card-body text-center">
                        <h5 class="card-title text-orange">Chăm sóc sức khỏe toàn diện trẻ em trong gia đình</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>