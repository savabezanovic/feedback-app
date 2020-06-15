jQuery(document).ready(function () {
    jQuery('#sub-btn').click(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: '/test',
            method: 'post',
            data: {
                name: jQuery('#name').val(),
                email: jQuery('#email').val(),
                password: jQuery('#password').val()
            },
            success: function (result) {
                jQuery('.alert').show();
                jQuery('.alert').html(result.success);
                console.log('Uspesno!');
            }
        });
    });
});
console.log('Custom JS File!');