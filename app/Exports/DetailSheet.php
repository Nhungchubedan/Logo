<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\OrderDetail;


class DetailSheet implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $month;

    public function __construct($year, $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    public function collection()
    {
        if (is_numeric($this->month)) {
            $orderDetails = DB::table('orderdetail AS od')
                ->join('order AS o', 'od.id_order', '=', 'o.id_order')
                ->select('od.id_order', 'od.id_product', 'od.quantity')
                ->whereYear('o.order_time', $this->year)
                ->whereMonth('o.order_time', $this->month)
                ->get();

        } else {
            $orderDetails = DB::table('orderdetail AS od')
                ->join('order AS o', 'od.id_order', '=', 'o.id_order')
                ->select('od.id_order', 'od.id_product', 'od.quantity')
                ->whereYear('o.order_time', $this->year)
                ->get();
        };
        return $orderDetails;
        
    }

    public function headings(): array
    {
        return [
            'Mã đơn hàng',
            'Mã sản phẩm',
            'Số lượng',
        ];
    }

    public function title(): string
    {
        return 'Chi tiết';
    }
}
