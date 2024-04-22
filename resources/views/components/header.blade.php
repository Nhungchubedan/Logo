<div style="height:70px" class="bg-success d-flex flex-nowrap justify-content-center align-items-center position-fixed fixed-top z-3">

    <!-- Nav & Logo -->
    <div class="w-25 text-center d-flex align-items-center justify-content-around">
        
        <a href="{{route('welcome')}}" class="text-reset text-decoration-none">
            <h1 class="mb-0 text-white me-10">L O G O</h1>
        </a>

    </div>


    
    <!-- Search -->
    <form class="w-50 position-relative" method="get" action="{{ route('search') }}">
        <input 
            type="text" 
            class="w-100 rounded-4 p-2 px-12 fs-sm focus-ring shadow-none" 
            name="q" 
            autocomplete="off"
            id="search-input" 
            placeholder="Voucher Ngập Tràn & FREESHIP Toàn Quốc"
            onkeypress="if (event.keyCode === 13) { this.form.submit(); }"
        >
        <i class="fa-solid fa-magnifying-glass position-absolute start-0 mt-3 mx-3"></i>
        <div id="search-box" class="position-absolute w-100 bg-white mt-2 hidden shadow rounded-3">
            <p class="fs-sm fw-bold p-4">SẢN PHẨM GỢI Ý</p>
            <ul class="list-unstyled d-flex flex-wrap px-4"></ul>
        </div>
    </form>

    <div class="w-25 text-white d-flex justify-content-between ps-20 pe-10">

        
        <!-- Account -->
        
        @if(!auth()->check()) 
        <div class="w-100 text-center">
            <a href="{{route('login')}}" class="text-decoration-none">
                <i class="fa-solid fa-arrow-right-from-bracket h3 p-2 rounded-circle hover"></i>
            </a>
        </div>
        @else
            @include('components.account')
        @endif
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    $('#search-input').on('input', function () {
        var q = this.value;
        $("#search-box ul").html('');
        $.ajax({
            url: "/ajax/search",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            data: {
                search: q,
            },
            async:false,
            dataType: 'json',
            success: function (result) {
                $.each(result, function (key, value) {
                    $("#search-box ul").append(`
                    <li class="w-50 p-2">
                        <a href="{{ URL('/product/`+ value.id +`') }}" class="d-flex align-items-center text-reset text-decoration-none">
                            <img 
                                src="{{ asset('img/` + value.image + `') }}" 
                                style="aspect-ratio: 1 / 1;"
                                class="object-fit-cover w-25"
                            >
                            <div class="ps-2">
                                <div 
                                    style="text-overflow: ellipsis;
                                    display: -webkit-box;
                                    -webkit-box-orient: vertical;
                                    -webkit-line-clamp: 2;
                                    line-height: 14px;      
                                    max-height: 28px;"
                                    class="fs-sm fw-bold text-capitalize my-1 overflow-hidden">`
                                    + value.name +
                                `</div>
                                <p class="fs-sm text-danger fw-bold">` + value.price + ` đ</p>
                            </div>
                        </a>
                    </li>`
                    );
                })
            },
            error: function(error) {
                console.error("AJAX request failed:", error);
            }
        });
    });

})

</script>

