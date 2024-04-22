document.addEventListener('DOMContentLoaded', function () {
    $('#otp').on('click', function () {
        var email = $("#email").val();
        $("#otp-info").html('');
        $.ajax({
            url: "/ajax/sendotp",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                email: email,
            },
            dataType: 'json',
            success: function (result) {
                $("#otp-info").append(result.message);
            }
        });
    });
})