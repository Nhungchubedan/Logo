<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Facades\DB;

class ProductSheet implements FromCollection, WithHeadings, WithTitle
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
            $products = DB::table('product AS p')
                ->join('orderdetail AS od', 'od.id_product', '=', 'p.id_product')
                ->join('order AS o', 'o.id_order', '=', 'od.id_order')
                ->select('p.id_product', 'p.id_brand', 'p.product_name', 'p.unit_price', 'p.discount')
                ->whereYear('o.order_time', $this->year)
                ->whereMonth('o.order_time', $this->month)
                ->get();

        } else {
            $products = DB::table('product AS p')
                ->join('orderdetail AS od', 'od.id_product', '=', 'p.id_product')
                ->join('order AS o', 'o.id_order', '=', 'od.id_order')
                ->select('p.id_product', 'p.id_brand', 'p.product_name', 'p.unit_price', 'p.discount')
                ->whereYear('o.order_time', $this->year)
                ->get();
        };
        return $products;
        
    }

    public function headings(): array
    {
        return [
            'Mã sản phẩm',
            'Mã thương hiệu',
            'Tên sản phẩm',
            'Đơn giá',
            'Giảm giá',
        ];
    }

    public function title(): string
    {
        return 'Sản phẩm';
    }
}
