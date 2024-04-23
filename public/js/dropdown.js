document.addEventListener('DOMContentLoaded', function () {
    $('#province').on('change', function () {
        var provinceCode = this.value;
        $("#district").html('');
        $("#commune").html('');
        $.ajax({
            url: "/api/fetch-districts",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                province_code: provinceCode,
            },
            dataType: 'json',
            success: function (result) {
                $.each(result, function (key, value) {
                    $("#district").append('<option value="' + value.code + '">' + value.name_with_type + '</option>');
                });
            }
        });
    });

    $('#district').on('change', function () {
        var districtCode = this.value;
        $("#commune").html('');
        $.ajax({
            url: "/api/fetch-communes",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                district_code: districtCode,
            },
            dataType: 'json',
            success: function (result) {
                $.each(result, function (key, value) {
                    $("#commune").append('<option value="' + value.code + '">' + value.name_with_type + '</option>');
                });
            }
        });
    });






})