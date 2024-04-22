
@extends('layouts.admin')
@section('title', 'Quản trị hệ thống')
@section('content')

<div class="admin-content bg-light">
    <p class="fw-bold text-success fs-4">THỐNG KÊ & BÁO CÁO</p>
    <div class="d-flex mt-2 align-items-center justify-content-between">
        <form class="chart d-flex w-75 align-items-center fs-sm position-relative" method="post">
            @csrf
            
            <label class="fw-bold text-dark my-0 me-6">
                <i class="fa-solid fa-calendar-days fs-4"></i>
            </label>
            <select id="yearSelect" name="year">
                @for ($i = 2020; $i <= 2099; $i++)
                <option value="{{ $i }}" <?php echo $i == $y ? 'selected' : '' ?>>
                    {{ $i }}
                </option>
                @endfor
            </select>
            <span class="text-black fs-6">&ensp;,&ensp;</span>
            <select id="monthSelect" name="month" class="text-start">
                <option value="hide">---</option>
                <option value="1" <?php echo ($m == 1) ? 'selected' : ''; ?>>January</option>
                <option value="2" <?php echo ($m == 2) ? 'selected' : ''; ?>>February</option>
                <option value="3" <?php echo ($m == 3) ? 'selected' : ''; ?>>March</option>
                <option value="4" <?php echo ($m == 4) ? 'selected' : ''; ?>>April</option>
                <option value="5" <?php echo ($m == 5) ? 'selected' : ''; ?>>May</option>
                <option value="6" <?php echo ($m == 6) ? 'selected' : ''; ?>>June</option>
                <option value="7" <?php echo ($m == 7) ? 'selected' : ''; ?>>July</option>
                <option value="8" <?php echo ($m == 8) ? 'selected' : ''; ?>>August</option>
                <option value="9" <?php echo ($m == 9) ? 'selected' : ''; ?>>September</option>
                <option value="10" <?php echo ($m == 10) ? 'selected' : ''; ?>>October</option>
                <option value="11" <?php echo ($m == 11) ? 'selected' : ''; ?>>November</option>
                <option value="12" <?php echo ($m == 12) ? 'selected' : ''; ?>>December</option>
            </select> 
        </form>

        <a href="{{ route('admin.report.export', ['year' => $y, 'month' => $m]) }}" class="bg-warning text-decoration-none py-2 px-4 text-white rounded-3">
            <i class="fa-regular fa-file-excel fs-6"></i>&ensp;Export
        </a>
    </div>

    <div style="height:199px;" class="w-100 mt-3 d-flex justify-content-between">
        <div style="width:calc(25% - 16px);" role="button" class="bg-white chart-block shadow rounded-3 overflow-hidden">
            <div class="text-start text-black ps-4 pt-2">
                <p class="fw-bold fs-5">
                    <i class="fa-solid fa-dollar-sign"></i>&ensp;
                    {{ number_format( $paymentsTotal , 0, '', ',') }}
                </p>
                <p class="fs-sm">total income</p>
            </div>
            <canvas id="incomeChart" class="w-100"></canvas>
        </div>
        <div style="width:calc(25% - 16px);" role="button" class="bg-white chart-block shadow rounded-3 overflow-hidden">
            <div class="text-start text-black ps-4 pt-2">
                <p class="fw-bold fs-5">
                    <i class="fa-solid fa-cart-shopping"></i>&ensp;
                    {{ number_format( $ordersTotal , 0, '', ',') }}
                </p>
                <p class="fs-sm">total sales</p>
            </div>
            <canvas id="saleChart" class="w-100"></canvas>
        </div>
        <div style="width:calc(25% - 16px);" role="button" class="bg-white chart-block shadow rounded-3 overflow-hidden">
            <div class="text-start text-black ps-4 pt-2">
                <p class="fw-bold fs-5">
                    <i class="fa-solid fa-user"></i>&ensp;
                    {{ number_format( $usersTotal , 0, '', ',') }}
                </p>
                <p class="fs-sm">members</p>
            </div>
            <canvas id="userChart" class="w-100"></canvas>
        </div>
        <div style="width:calc(25% - 16px);" role="button" class="bg-white chart-block shadow rounded-3 overflow-hidden">
            <div class="text-start text-black ps-4 pt-2">
                <p class="fw-bold fs-5">
                    <i class="fa-solid fa-box-open"></i>&ensp;
                    {{ number_format( $productsTotal , 0, '', ',') }}
                </p>
                <p class="fs-sm">products</p>
            </div>
            <canvas id="productChart" class="w-100"></canvas>
        </div>
    </div>

    <div class="w-100 my-6">
        <p class="fw-bold fs-5 text-success mb-3">CHI TIẾT BIỂU ĐỒ</p>
        <canvas id="myChart" style="width:85%;height:400px;" class="mx-auto"></canvas>
    </div>


    
</div>

<script>
    // Chart 
    function createChart(ctx, data, color) {
        if (data.length > 0) {
            var labels = [];
            var totals = [];
            var xAxes = (time == 'Tháng') ? 12 : getDaysInMonth(m, y);
            for (var i = 1; i <= xAxes; i++) {
                labels.push(i);
                totals.push(0);
            }

            data.forEach(function(row) {
                var timeIndex = parseInt(row.time) - 1;
                totals[timeIndex] = row['total'];
            });

            const config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '',
                        data: totals,
                        borderColor: color,
                        borderWidth: 1,
                        backgroundColor: color,
                        fill: true
                    }]
                },
                options: {
                    responsive: false,
                    scales: {
                        xAxes: [{
                            display: false,
                            gridLines: {
                                color: "rgba(0, 0, 0, 0)",
                            },
                        }],
                        yAxes: [{
                            display: false,
                            gridLines: {
                                color: "rgba(0, 0, 0, 0)",
                                drawBorder: false,
                            },
                        }]
                        
                    },
                    elements: {
                        point:{
                            radius: 0
                        }
                    },
                    plugins: {
                        filler: {
                            propagate: false
                        },
                        title: {
                            display: false
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        callbacks: {
                        label: function(tooltipItem) {
                                return tooltipItem.yLabel;
                            }
                        }
                    }
                }
            }

            return new Chart(ctx, config);
        }

    }

    var ctx1 = document.getElementById('incomeChart').getContext('2d');
    var ctx2 = document.getElementById('saleChart').getContext('2d');
    var ctx3 = document.getElementById('userChart').getContext('2d');
    var ctx4 = document.getElementById('productChart').getContext('2d');
    var ctx = document.getElementById('myChart').getContext('2d');

    var ordersData = {!! json_encode($ordersData) !!};
    var productsData = {!! json_encode($productsData) !!};
    var usersData = {!! json_encode($usersData) !!};
    var paymentsData = {!! json_encode($paymentsData) !!};
    var time = {!! json_encode($time) !!};
    var m = {!! json_encode($m) !!};
    var y = {!! json_encode($y) !!};

    createChart(ctx1, paymentsData, 'pink', time);
    createChart(ctx2, ordersData, 'yellow', time);
    createChart(ctx3, usersData, 'blue', time);
    createChart(ctx4, productsData, 'orange', time);

    let myChart = detailChart(ordersData, 'yellow', time, 'Đơn hàng');

    var chart = document.querySelectorAll('.chart-block');

    document.getElementById('incomeChart').onclick = function() {
        myChart.destroy();
        myChart = detailChart(paymentsData, 'pink', time, 'Thu nhập');
    }

    document.getElementById('productChart').onclick = function() {
        myChart.destroy();
        myChart = detailChart(productsData, 'orange', time, 'Sản phẩm');
    }

    document.getElementById('userChart').onclick = function() {
        myChart.destroy();
        myChart = detailChart(usersData, 'blue', time, 'Tài khoản');
    }

    document.getElementById('saleChart').onclick = function() {
        myChart.destroy();
        myChart = detailChart(ordersData, 'yellow', time, 'Đơn hàng');
    }


    function detailChart(data, color, xlabel, ylabel) {
        var labels = [];
        var totals = [];
        var xAxes = (time == 'Tháng') ? 12 : getDaysInMonth(m, y);
        for (var i = 1; i <= xAxes; i++) {
            labels.push(i);
            totals.push(0);
        }

        data.forEach(function(row) {
            var timeIndex = parseInt(row.time) - 1;
            totals[timeIndex] = row['total'];
        });

        const config = {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: '',
                    backgroundColor: color,
                    borderColor: color,
                    borderWidth: 1,
                    data: totals
                }]
            },
            options: {
                responsive: true,
                scales: {
                    xAxes: [{
                        ticks:{
                            fontColor : "#000",
                            fontSize : 14,
                            beginAtZero: true 
                        },
                        scaleLabel: {
                            display: true,
                            labelString: xlabel,
                            fontColor : "#000",
                            fontSize : 14,
                        },
                        gridLines: { 
                            color: 'transparent', 
                            borderColor: 'black', 
                        },
                        scaleFontSize: 40,
                    }],
                    yAxes: [{
                        ticks:{
                            fontColor : "#000",
                            fontSize : 14,
                            beginAtZero: true 
                        },
                        scaleLabel: {
                            display: true,
                            labelString: ylabel,
                            fontColor : "#000",
                            fontSize : 14,
                        },
                        gridLines: { 
                            color: 'transparent', 
                            borderColor: 'black', 
                        },
                    }],
                    
                },
                plugins: {
                    filler: {
                        propagate: false
                    },
                    title: {
                        display: false
                    }
                },
                legend: {
                    display: false,
                },
                tooltips: {
                    callbacks: {
                    label: function(tooltipItem) {
                            return tooltipItem.yLabel;
                        }
                    }
                },
            }
        }

        return new Chart(ctx, config);

    }

    function getDaysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    }

</script>
@endsection