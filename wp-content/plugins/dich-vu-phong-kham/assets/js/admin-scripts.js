jQuery(document).ready(function($){
    $('form#dich_vu_form').submit(function(e){
        e.preventDefault();

        var name = $('#name').val();
        var phone = $('#phone').val();
        var price = $('#price').val();

        $.ajax({
            url: dich_vu_phong_kham_ajax.ajax_url,
            method: 'POST',
            data: {
                action: 'add_service',
                name: name,
                phone: phone,
                price: price,
                _ajax_nonce: dich_vu_phong_kham_ajax.nonce
            },
            success: function(response) {
                alert('Dịch vụ đã được thêm thành công!');
            }
        });
    });
});
