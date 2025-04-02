# Clinic Services Manager

Plugin WordPress giúp quản lý hệ thống phòng khám và các dịch vụ y tế.

## Tính năng
- Tạo và hiển thị danh sách phòng khám
- Gắn các dịch vụ khám với từng phòng khám (một chiều từ phòng khám đến dịch vụ)
- Hiển thị frontend qua shortcode [clinic_list]
- Tạo bảng riêng lưu log nội bộ

## Cài đặt
1. Copy plugin vào wp-content/plugins
2. Kích hoạt plugin trong admin
3. Cài đặt ACF để plugin hoạt động đầy đủ

## Shortcode
- [clinic_list] - Hiển thị danh sách phòng khám

## Ghi chú
- Plugin tạo bảng wp_clinic_logs để lưu hoạt động nội bộ.
- Quan hệ dịch vụ được thiết lập từ phòng khám → dịch vụ (một chiều).
