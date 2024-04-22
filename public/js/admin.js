document.addEventListener("DOMContentLoaded", function() {
    var table = $('#data-table').DataTable({
        "lengthMenu": false,
        "stateSave": true,
        "process": true,
    });

    initializeSummernote();
    confirmOrder();

    $('#search').on("keyup change", function() {
        var searchTerm = this.value.toLowerCase();
        table.search(searchTerm).draw();
    });

    table.on('draw', function() {
        initializeSummernote();
        confirmOrder();
        
    });

    $('#data-table').on('dblclick', 'td.editable', function () {
        var selectHtml = '<select class="fs-xs border p-2 rounded-3">' +
                            '<option value="11105">User</option>' +
                            '<option value="11101">Admin</option>' +
                            '<option value="11102">Manager</option>' +
                            '<option value="11103">Staff</option>' +
                            '<option value="11104">Editor</option>' +
                        '</select>';
        $(this).html(selectHtml);
        var selectElement = $(this).find('select');
        selectElement.val(selectElement.find('option:first').val());
    });

    $('#data-table').on('blur', 'td.editable select', function () {
        var newValue = $(this).val();
        var newText = $(this).find('option:selected').text();
        var userId = $(this).closest('tr').find('td.user').text().trim();
        $(this).closest('td.editable').html(newText);

        $.ajax({
            url: window.location.href ,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id_user: userId,
                action: 'update',
                role: newValue
            },
            success: function (response) {
                $('#success').append(response.success);
                location.reload();
            },
            
        });
    });

    function confirmOrder() {
        const confirms = document.querySelectorAll('.crud .confirm');
        const reasons = document.querySelectorAll('.crud .reason');
        confirms.forEach((confirm, index) => {
            var reasonSelect = reasons[index].querySelector('select');
            var reasonOther = reasons[index].querySelector('.reason-other');
            var reasonOtherError = reasons[index].querySelector('.reason-other .error');

            if (!(reasonOtherError.classList.contains('hidden'))) {
                reasons[index].classList.remove('hidden');
                reasonOther.classList.remove('hidden');
                confirm.options[1].selected = true;
                reasonSelect.options[4].selected = true;
            } 
            confirm.onchange = function() {
                if (this.value == 0) {
                    reasons[index].classList.remove('hidden');
                    reasonSelect.onchange = function() {
                        if (this.value == 5) {
                            reasonOther.classList.remove('hidden');
                        } else {
                            reasonOther.classList.add('hidden');
                        }
                    }
                } else {
                    reasons[index].classList.add('hidden');
                }
            } 
        })
    }
    
    function initializeSummernote() {
        $('.summernote').each(function() {
            $(this).summernote({
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['view', ['fullscreen']],
                    ['height', ['height']]
                ],
                height: 160
            });
        });
    }

    const monthSelect = document.getElementById('monthSelect');
    const yearSelect = document.getElementById('yearSelect');

    if (monthSelect) {
        monthSelect.onchange = function() {
            this.parentNode.submit();
        }
        yearSelect.onchange = function() {
            this.parentNode.submit();
        }
    }
    
});