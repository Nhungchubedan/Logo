document.addEventListener("DOMContentLoaded", function() {
    const ACCOUNT_NO = "0327237302"
    const BANK_ID = "MB"
    const total = document.getElementById('total').value;
    const qr = document.getElementById('qr');
    const order_id = document.getElementById('order-id').value;
    const countDown = document.querySelector('.count-down');
    qr.src = `https://img.vietqr.io/image/${BANK_ID}-${ACCOUNT_NO}-qr_only.png?amount=${total}&addInfo=${order_id}`;

    let count = 60;
    let isPaid = false;

    const interval = setInterval(() => {
        countDown.textContent = `${count--}s`;

        if (isPaid) {
            clearInterval(interval);
        } else {
            checkPaid(total, order_id);
        }
        if (count == 0 && !isPaid) {
            cancelOrder(order_id);
            clearInterval(interval);
        }
    }, 1000)


    // thanh toán online
    async function checkPaid(total, id) {
        if (isPaid) {
            return;
        } else {
            const response = await fetch("https://script.googleusercontent.com/macros/echo?user_content_key=8UgsptNMXATTuNhAhuaoRAyMhL07oNfEEdsChf-FGOWF10BsoUTDeF0GL9xgqRwBEhrVoKMJGFujVKNNdfCGUW0xNEtyHH8Vm5_BxDlH2jW0nuo2oDemN9CCS2h10ox_1xSncGQajx_ryfhECjZEnGQnJCL-jPZHxOrxWeUMyr-8uOfhuJR8flMDkSUiN6a_LYXWUKK3tP4lIZzKXmiBkWHVV6yjZHQsqbxm0CNgCw5MhZNQp9XoOQ&lib=MHMFzaUY1Op9Q69msimJInrxOyBjr5lls");
            const data = await response.json();
            const transaction = data.data;
            transaction.forEach((item) => {
                if (total == item["Giá trị"] && item["Mô tả"].includes(id)) {
                    confirmPayment(id);
                    isPaid = true;
                }
            })
        }
    }

    function confirmPayment(id) {
        $.ajax({
            url: "confirmPay",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                orderId: id,
            },
            dataType: 'json',
            success: function (result) {
                $("#status").html(`<span class="text-success">${result.message}</span>`);
                $("#end").html(`<span class="text-success">Cám ơn bạn đã tin chọn LOGO</span>`);
            }
        });
    }

    function cancelOrder(id) {
        $.ajax({
            url: "cancelOrder",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                orderId: id,
            },
            dataType: 'json',
            success: function (result) {
                $("#status").html(`<span class="text-danger">${result.message}</span>`);
            }
        });
    }

})