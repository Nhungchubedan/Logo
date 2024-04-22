document.addEventListener('DOMContentLoaded', function () {
    const check = document.querySelectorAll('input.check');
    const checkAll = document.querySelector('#check-all');
    check.forEach((item) => {
        item.addEventListener("change", handleCartChecked);
    })
    checkAll.addEventListener("change", handleCartChecked);
    
    
    function handleCartChecked() {
        var checked = document.querySelectorAll('.cart-product:has(input:checked)');

        var cart = [];
        var totalQuantity = 0;
        var totalPayment = 0;

        checked.forEach((item, index) => {
            cart[index] = {
                'price': parseInt(item.querySelector('input.price').value),
                'quantity': parseInt(item.querySelector('input.quantity').value)
            }
        })
        cart.forEach((item) => {
            totalQuantity += item.quantity;
            totalPayment += item.price * item.quantity;
        })
        document.querySelector('input[name="total-quantity"]').value 
        =  totalQuantity;
    
        document.querySelector('input[name="total-payment"]').value 
        = totalPayment.toLocaleString('en-US', { style: 'decimal', minimumFractionDigits: 0, maximumFractionDigits: 0 }) + ' đ';
    
        
    }


    



});
