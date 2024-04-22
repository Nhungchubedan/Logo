document.addEventListener('DOMContentLoaded', function () {
    window.addEventListener('click', function() {
        if (cartBox) {
            if (!cartBox.classList.contains('hidden')) {
                cartBox.classList.add('hidden')
                
            }
        }
    })


    // Xử lý đóng mở khung gợi ý tìm kiếm
    const searchInput = document.querySelector('#search-input')
    const searchBox = document.querySelector('#search-box')
    if (searchInput) {
        searchInput.oninput = function() {
            searchBox.classList.remove('hidden')
            if (searchInput.value === '') {
                searchBox.classList.add('hidden')
            }
        }
        
    }

    // Xử lý đóng mở giỏ hàng
    const cartBtn = document.querySelector('#cart-btn')
    const cartBox = document.querySelector('#cart-box')
    if (cartBtn) {
        cartBtn.onclick = function(e) {
            cartBox.classList.remove('hidden')
            e.stopPropagation()
        }
    }


    // Xử lý chuyển slide trang Home
    const slides = document.querySelectorAll('.slides li img');
    const dots = document.querySelectorAll('.dots li div');
    if (slides.length > 0) {
            let currentIndex = 0;
            slideInterval = setInterval(() => {
                slides[currentIndex].classList.add('opacity-0');
                dots[currentIndex].classList.remove('bg-secondary-subtle');
                dots[currentIndex].classList.add('bg-dark-subtle');
                currentIndex = (currentIndex + 1) % slides.length;
                slides[currentIndex].classList.remove('opacity-0');
                dots[currentIndex].classList.remove('bg-dark-subtle');
                dots[currentIndex].classList.add('bg-secondary-subtle');
                
            }, 3000); 
    } 


    // Xử lý trượt danh sách
    const sliderContent = document.querySelectorAll('.slide-item');
    const sliderList = document.querySelector('.slide-list');
    const leftArrow = document.querySelector('.left-arrow');
    const rightArrow = document.querySelector('.right-arrow');
    
    
    if (sliderList) {
        let scrollAmount = 0;
        if (scrollAmount == sliderList.scrollWidth - sliderList.offsetWidth) {
            rightArrow.classList.add('hidden')
        }
        leftArrow.addEventListener('click', function() {
            scrollAmount -= sliderContent[0].offsetWidth; 
            sliderList.style.transform = `translateX(-${scrollAmount}px)`;
            if (rightArrow.classList.contains('hidden')) {
                rightArrow.classList.remove('hidden')
            }
            if (scrollAmount == 0) {
                leftArrow.classList.add('hidden')
            }
        });
        rightArrow.addEventListener('click', function() {
            scrollAmount += sliderContent[0].offsetWidth;
            sliderList.style.transform = `translateX(-${scrollAmount}px)`;
            if (leftArrow.classList.contains('hidden')) {
                leftArrow.classList.remove('hidden')
            }
            if (scrollAmount >= sliderList.scrollWidth - sliderList.offsetWidth) {
                rightArrow.classList.add('hidden')
            }
        });
    }
    

    // Xử lý cuộn màn hình lên đầu trang
    const arrowUp = document.getElementById("scroll-to-top");
    if (arrowUp) {
        window.onscroll = function() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                arrowUp.style.display = "block";
            } else {
            arrowUp.style.display = "none";
            }
        };
        arrowUp.onclick = function scrollToTop() {
            document.body.scrollTop = 0; 
            document.documentElement.scrollTop = 0; 
        }

    }

    // Xử lý ẩn hiện passwword
    const password = document.querySelector("#password");
    const toggleBtn = document.querySelector(".toggle-password");
    if (toggleBtn) {
        toggleBtn.onclick = function() {
            if (password.type === "password") {
              password.type = "text";
              toggleBtn.classList.add("show-password");
            } else {
              password.type = "password";
              toggleBtn.classList.remove("show-password");
            }
        }
    }


    // Xử lý chuyển trang
    const nextBtn = document.querySelector('#next-arrow')
    const backBtn = document.querySelector('#back-arrow')
    const pageNumber = document.querySelectorAll('.page')
    const totalPages = pageNumber.length; 
    const visiblePages = 5; 
    let currentPage;
    if (nextBtn) {
        for (var i = 0; i < pageNumber.length; i++) {
            if (pageNumber[i].classList.contains('active')) {
                currentPage = i + 1; 
            }
        }
        function hiddenNumber() {
            for (let i = 0; i < pageNumber.length; i++) {
                if (!pageNumber[i].classList.contains('hidden')) {
                    pageNumber[i].classList.add('hidden')
                }
            }
        }
        function visibleNumber() {
            let start = Math.max(1, currentPage - 2);
            let end = Math.min(totalPages, start + visiblePages - 1);

            if (currentPage == 1) {
                backBtn.classList.add('hidden')
            } else if (backBtn.classList.contains('hidden')) {
                backBtn.classList.remove('hidden')
            }

            if (currentPage == totalPages) {
                nextBtn.classList.add('hidden')
            } else if (nextBtn.classList.contains('hidden')) {
                nextBtn.classList.remove('hidden')
            }
            
            for (let i = start; i <= end; i++) {
                pageNumber[i-1].classList.remove('hidden')
            }
        }
        hiddenNumber()
        visibleNumber()
    }


    // Xử lý khoảng giá

    const range = document.getElementById('range');
    
    if (range) {
        const minInput = document.querySelector('#minprice');
        const maxInput = document.querySelector('#maxprice');
        const minSlide = document.querySelector('#minslide span')
        const maxSlide = document.querySelector('#maxslide span')
        const min = 10000;
        const max = 2000000;
        const openFilter = document.querySelectorAll('.open-filter')
        const closeFilter = document.querySelectorAll('.close-filter')

        let format = function (value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        };
        let unformat = function (value) {
            return value.replace(/,/g, "");
        }
    
        noUiSlider.create(range, {
            start: [min, max],
            connect: true,
            range: { min: min, max: max },
            step: 1,
            tooltips: false,
            format: {
                from: Number,
                to: format
            },
            
        });

    
        range.noUiSlider.on('set', function () {
            var tooltipValues = range.noUiSlider.get();

            minInput.value = unformat(tooltipValues[0]);
            maxInput.value = unformat(tooltipValues[1]);
        
            minSlide.innerHTML = tooltipValues[0]
            maxSlide.innerHTML = tooltipValues[1]
        });

        range.noUiSlider.set([parseInt(minInput.value), parseInt(maxInput.value)])

        minInput.onchange = function() {
            if (!(this.value <= maxInput.value 
                && this.value <= 2000000 
                && this.value >= 10000 )) 
            {
                this.value = 10000;
            }
            range.noUiSlider.set([parseInt(this.value), null])
        }
        maxInput.onchange = function(e) {
            if (this.value >= minInput.value 
                && this.value <= 2000000 
                && this.value >= 10000) 
            {
                this.value = 2000000;
            } 
            range.noUiSlider.set([null, parseInt(this.value)])
        }

        for (let i = 0; i < openFilter.length; i++) {
            openFilter[i].onclick = function() {
                let filter = openFilter[i].parentNode.parentNode;
                let options = filter.querySelector('ul');
                options.classList.remove('hidden')
                openFilter[i].classList.add('hidden')
                closeFilter[i].classList.remove('hidden')
            }
            closeFilter[i].onclick = function() {
                let filter = openFilter[i].parentNode.parentNode;
                let options = filter.querySelector('ul');
                options.classList.add('hidden')
                openFilter[i].classList.remove('hidden')
                closeFilter[i].classList.add('hidden')
            }
        }
    }

    // Xử lý check chọn sản phẩm
    const checkProduct = document.querySelectorAll('.check')
    const checkAllProduct = document.querySelector('#check-all')

    if (checkProduct[0]) {
        checkAllProduct.onclick = function() {
            let status = checkAllProduct.checked
            for (let i = 0; i < checkProduct.length; i++) {
                checkProduct[i].checked = status
            }
            handleChecked();
        }
        for (let i = 0; i < checkProduct.length; i++) {
            checkProduct[i].onclick = function() {
                let all = true;
                for(let j = 0; j < checkProduct.length; j++) {
                    if (!checkProduct[j].checked) {
                        all = false
                    }
                }
                checkAllProduct.checked = all;
                handleChecked();
            }
        }
    }

    // Xử lý form đặt hàng
    function handleChecked() {
        var checkedCart = document.querySelectorAll('.check:checked')
        var btnOrder = document.querySelector('form#order button')
        if (checkedCart.length !== 0) {
            btnOrder.classList.remove('unactive');
            btnOrder.type = 'submit';
        } else {
            btnOrder.classList.add('unactive');
            btnOrder.type = 'button';
        }

    }


    // Xử lý đóng mở khung dialog
    const quitBtns = document.querySelectorAll('.quit');
    const boxes = document.querySelectorAll('.box')
    const btns = document.querySelectorAll('.btn')
    
    if (btns[0]) {
        btns.forEach((btn, index) => {
            btn.onclick = function() {
                boxes[index].style.display = 'block';
            }
            let formPost = boxes[index].querySelector('input[name="form-post"]');
            let formGet = boxes[index].querySelector('input[name="form-get"]');
            if (formPost) {
                formPost.value = index;

                if (formGet.value == formPost.value) {
                    boxes[index].style.display = 'block';

                    let errors = boxes[index].querySelectorAll('.error');
                    errors.forEach((err) => {
                        err.classList.remove('hidden');
                    })
                }
            }


            quitBtns[index].onclick = function(e) {
                boxes[index].style.display = 'none';
                let errors = boxes[index].querySelectorAll('.error');
                    errors.forEach((err) => {
                        err.classList.add('hidden');
                    })
                e.stopPropagation();
            }
        })
        
        
    }


    // Xử lý detail product
    const option = document.querySelectorAll('.option li');
    const optionContent = document.querySelectorAll('.option > li + div');
    if (option[0]) {
        option.forEach((item, index) => {
            item.onclick = function() {
                let active = document.querySelector('.option .active');
                let activeContent = document.querySelector('.option > .active + div');
                active.classList.remove('active');
                activeContent.classList.add('hidden');

                item.classList.add('active');
                optionContent[index].classList.remove('hidden');
            }
        });
        
    }
    
    // Xử lý tăng giảm số lượng
    const quantityBox = document.querySelectorAll('.quantity-box');
    if (quantityBox[0]) {
        quantityBox.forEach((item) => {
            
            item.onclick = function(e) {
                if(e.target.parentElement === item) {
                    let minus = e.target.parentElement.querySelector('.minus')
                    let plus = e.target.parentElement.querySelector('.plus')
                    let quantity = e.target.parentElement.querySelector('input.quantity')
                    
                    if(e.target === plus) {
                        quantity.value = parseInt(quantity.value) + 1;
                    }
                    if(e.target === minus) {
                        if (quantity.value > 1) {
                            quantity.value = parseInt(quantity.value) - 1;
                        }
                    }
                }
            }

        })

    }

    // Xử lý chọn phương thức thanh toán
    const paymethod = document.querySelectorAll(".paymethod");

    if (paymethod) {
        paymethod.forEach((item) => {
            item.onclick = function() {
                paymethod.forEach((i) => {
                    i.classList.remove('active')
                })
                let input = item.querySelector('input');
                input.checked = true;
                item.classList.add('active');
            }
        })

    }

    // Xử lý nhập ảnh đại diện
    const avatarImg = document.getElementById("avatar-img")
    const avatarInput = document.getElementById("avatar-input")
    if (avatarImg) {
        
        avatarInput.onchange = function() {
            avatarImg.src = URL.createObjectURL(avatarInput.files[0])
        }
    }
    
    
    // Xử lý confirm dialog
    const btnConfirm = document.querySelectorAll('.btn-confirm');
    const dialog = document.querySelectorAll('.confirm-dialog');
    
    if (btnConfirm[0]) {
        btnConfirm.forEach((item, index) => {
            item.onclick = function() {
                dialog[index].style.display = 'block';
                
                let quit = dialog[index].querySelector('.quit-dialog');
                quit.onclick = function() {
                    dialog[index].style.display = 'none';
                }
            }
        })
    }
    
    // Xử lý nhập ảnh đánh giá sản phẩm
    const imageList = document.querySelectorAll('.image-list')

    imageList.forEach((list) => {
        const imageItem = list.querySelectorAll('.image-container')
        imageItem.forEach((item, index) => {
            const input = item.querySelector('input')
            const image = item.querySelector('img')
            const remove = item.querySelector('i')
            input.onchange = function() {
                image.parentElement.classList.remove('hidden');
                image.src = URL.createObjectURL(input.files[0]);
            };
            remove.onclick = function() {
                image.parentElement.classList.add('hidden');
                input.value = '';
                image.src = '';
            };
        })
    })

    
   
    
});
