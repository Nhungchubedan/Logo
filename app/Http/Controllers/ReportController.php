<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Account;
use Carbon\Carbon;
use App\Exports\OrderExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index() {
        $year = Carbon::now()->year;

        // Sơ lược
        $ordersTotal = Order::whereYear('order_time', $year)->count();
        $paymentsTotal = Payment::whereYear('payment_time', $year)->sum('payment_amount');
        $usersTotal = Account::whereYear('created_at', $year)->count();
        $productsTotal = OrderDetail::whereHas('order', function ($query) use ($year) {
                                $query->whereYear('order_time', $year);
                        })->sum('quantity');

        // Biểu đồ chi tiết
        $ordersData = Order::selectRaw('MONTH(order_time) as time, COUNT(*) as total')
                    ->whereYear('order_time', $year)
                    ->groupBy('time')
                    ->orderBy('time')
                    ->get();
        $paymentsData = Payment::selectRaw('MONTH(payment_time) as time, sum(payment_amount) as total')
                    ->whereYear('payment_time', $year)
                    ->groupBy('time')
                    ->orderBy('time')
                    ->get();
        $usersData = Account::selectRaw('MONTH(created_at) as time, COUNT(*) as total')
                    ->whereYear('created_at', $year)
                    ->groupBy('time')
                    ->orderBy('time')
                    ->get();
        $productsData = DB::table('orderdetail AS od')
                    ->join('order AS o', 'od.id_order', '=', 'o.id_order')
                    ->select(DB::raw('MONTH(o.order_time) AS time'), DB::raw('SUM(od.quantity) AS total'))
                    ->whereYear('o.order_time', $year)
                    ->groupBy(DB::raw('MONTH(o.order_time)'))
                    ->orderBy(DB::raw('MONTH(o.order_time)'))
                    ->get();


        return view('admin.report', [
            'ordersData'    => $ordersData,
            'ordersTotal'   => $ordersTotal,
            'paymentsTotal' => $paymentsTotal,
            'paymentsData'  => $paymentsData,
            'usersTotal'    => $usersTotal,
            'usersData'     => $usersData,
            'productsTotal' => $productsTotal,
            'productsData'  => $productsData,
            'time'          => 'Tháng',
            'y'             => $year,
            'm'             => 'hide',
        ]);
    }

    public function store(Request $request) {
        $year = $request->input('year');
        $month = 'hide';

        if ($request->input('month') == 'hide') {
            // Tổng
            $ordersTotal = Order::whereYear('order_time', $year)->count();
            $paymentsTotal = Payment::whereYear('payment_time', $year)->sum('payment_amount');
            $usersTotal = Account::whereYear('created_at', $year)->count();
            $productsTotal = OrderDetail::whereHas('order', function ($query) use ($year) {
                                    $query->whereYear('order_time', $year);
                            })->sum('quantity');

            // Data
            $ordersData = Order::selectRaw('MONTH(order_time) as time, COUNT(*) as total')
                ->whereYear('order_time', $year)
                ->groupBy('time')
                ->orderBy('time')
                ->get();
            $paymentsData = Payment::selectRaw('MONTH(payment_time) as time, sum(payment_amount) as total')
                ->whereYear('payment_time', $year)
                ->groupBy('time')
                ->orderBy('time')
                ->get();
            $usersData = Account::selectRaw('MONTH(created_at) as time, COUNT(*) as total')
                ->whereYear('created_at', $year)
                ->groupBy('time')
                ->orderBy('time')
                ->get();
            $productsData = DB::table('orderdetail AS od')
                ->join('order AS o', 'od.id_order', '=', 'o.id_order')
                ->select(DB::raw('MONTH(o.order_time) AS time'), DB::raw('SUM(od.quantity) AS total'))
                ->whereYear('o.order_time', $year)
                ->groupBy(DB::raw('MONTH(o.order_time)'))
                ->orderBy(DB::raw('MONTH(o.order_time)'))
                ->get();
            $time = 'Tháng';
        } else {
            $month = $request->input('month');
            // Tổng
            $ordersTotal = Order::whereYear('order_time', $year)->whereMonth('order_time', $month)->count();
            $paymentsTotal = Payment::whereYear('payment_time', $year)->whereMonth('payment_time', $month)->sum('payment_amount');
            $usersTotal = Account::whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
            $productsTotal = OrderDetail::whereHas('order', function ($query) use ($year, $month) {
                                        $query->whereYear('order_time', $year)->whereMonth('order_time', $month);
                                })->sum('quantity');


            // Data
            $ordersData = Order::selectRaw('DAY(order_time) as time, COUNT(*) as total')
                ->whereYear('order_time', $year)
                ->whereMonth('order_time', $month)
                ->groupBy('time')
                ->orderBy('time')
                ->get();
            $paymentsData = Payment::selectRaw('DAY(payment_time) as time, sum(payment_amount) as total')
                ->whereYear('payment_time', $year)
                ->whereMonth('payment_time', $month)
                ->groupBy('time')
                ->orderBy('time')
                ->get();
            $usersData = Account::selectRaw('DAY(created_at) as time, COUNT(*) as total')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->groupBy('time')
                ->orderBy('time')
                ->get();
            $productsData = DB::table('orderdetail AS od')
                ->join('order AS o', 'od.id_order', '=', 'o.id_order')
                ->select(DB::raw('DAY(o.order_time) AS time'), DB::raw('SUM(od.quantity) AS total'))
                ->whereYear('o.order_time', $year)
                ->whereMonth('o.order_time', $month)
                ->groupBy(DB::raw('DAY(o.order_time)'))
                ->orderBy(DB::raw('DAY(o.order_time)'))
                ->get();
            $time = 'Ngày';
        };
        return view('admin.report', [
            'ordersData'    => $ordersData,
            'ordersTotal'   => $ordersTotal,
            'paymentsTotal' => $paymentsTotal,
            'paymentsData'  => $paymentsData,
            'usersTotal'    => $usersTotal,
            'usersData'     => $usersData,
            'productsTotal' => $productsTotal,
            'productsData'  => $productsData,
            'time'          => $time,
            'y'             => $year,
            'm'             => $month,
        ]);
    }

    public function export(Request $request) {
        $month = $request->month;
        $year = $request->year;
        return Excel::download(new OrderExport($year, $month), 'orders.xlsx');
    }
}
