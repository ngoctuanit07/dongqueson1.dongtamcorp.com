<?php
/*
 * Template Name: FAQ Page
 */
get_header(); ?>

<div class="container my-5">
    <h2 class="text-danger mb-4">Hỏi đáp bác sĩ</h2>
    <div class="row">
        <!-- Cột bên trái: Accordion với các câu hỏi -->
        <div class="col-md-8">
            <div class="accordion" id="faqAccordion">
                <!-- Câu hỏi 1 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Chăm sóc trước khi sinh là gì?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Chăm sóc trước khi sinh là thăm khám trước khi mang thai nhằm kiểm tra sức khỏe tổng quát của hai vợ chồng. Từ đó, bác sĩ sẽ tư vấn về thời điểm mang thai, hướng dẫn chăm sóc sức khỏe sinh sản nhằm giúp mẹ bầu có thai kỳ khỏe mạnh. Bạn càng được chăm sóc trước khi sinh có hội mang thai càng cao và em bé cũng khỏe mạnh.
                        </div>
                    </div>
                </div>

                <!-- Câu hỏi 2 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Những điều bạn cần lưu ý để đảm bảo một thai kỳ khỏe mạnh?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            [Nội dung câu trả lời cho câu hỏi này. Bạn có thể thêm nội dung phù hợp.]
                        </div>
                    </div>
                </div>

                <!-- Câu hỏi 3 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Lợi ích phẩm não mà tơi nên tránh?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            [Nội dung câu trả lời cho câu hỏi này. Bạn có thể thêm nội dung phù hợp.]
                        </div>
                    </div>
                </div>

                <!-- Câu hỏi 4 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Làm thế nào tơi có thể chuẩn bị cho lần đầu làm mẹ?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            [Nội dung câu trả lời cho câu hỏi này. Bạn có thể thêm nội dung phù hợp.]
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cột bên phải: Danh sách liên kết -->
        <div class="col-md-4">
            <div class="card p-4">
                <h5 class="faq-help-title mb-3">Chúng tôi có thể giúp gì cho bạn?</h5>
                <ul class="list-unstyled faq-help-list">
                    <li><a href="#" class="faq-help-link">Tư vấn ngay</a></li>
                    <li><a href="#" class="faq-help-link">Tìm bác sĩ</a></li>
                    <li><a href="#" class="faq-help-link">Tìm chuyên khoa</a></li>
                    <li><a href="#" class="faq-help-link">Gửi câu hỏi của bạn</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- CSS tùy chỉnh -->
<style>
    .accordion-item {
        border: 1px solid #dee2e6;
        border-radius: 5px;
        margin-bottom: 10px;
    }
    .accordion-button {
        font-weight: 500;
        color: #333;
    }
    .accordion-button:not(.collapsed) {
        background-color: #f8f9fa;
        color: #f28c38;
    }
    .card {
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border: none;
    }
    .faq-help-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #333;
    }
    .faq-help-list {
        margin: 0;
        padding: 0;
    }
    .faq-help-list li {
        margin-bottom: 10px;
    }
    .faq-help-link {
        color: #007bff;
        text-decoration: none;
        font-size: 1rem;
        font-weight: 400;
        transition: text-decoration 0.2s ease;
    }
    .faq-help-link:hover {
        text-decoration: underline;
    }
    .faq-help-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #333;
    }
    .faq-help-list {
        margin: 0;
        padding: 0;
    }
    .faq-help-list li {
        margin-bottom: 10px;
        position: relative;
        padding-left: 20px; /* Tạo khoảng cách cho biểu tượng mũi tên */
    }
    .faq-help-list li::before {
        content: ">";
        position: absolute;
        left: 0;
        color: #f28c38; /* Màu cam giống trong hình */
        font-size: 1rem;
        font-weight: 700;
        line-height: 1.5;
    }
    .faq-help-link {
        color: #007bff;
        text-decoration: none;
        font-size: 1rem;
        font-weight: 400;
        transition: text-decoration 0.2s ease;
    }
    .faq-help-link:hover {
        text-decoration: underline;
    }
    .card {
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border: none;
    }
</style>
<?php get_footer(); ?>