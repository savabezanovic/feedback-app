$(document).ready(function () {

    // send notification to all users

    window.notifyUsers = function() {

        let message = $('#message').val();

        $.post(
            '/admin/notification/send',
            {
                message: message
            })
            .done(function (data) {
                console.log(data.request);
            });
    }

});