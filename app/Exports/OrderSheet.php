<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Order;


class OrderSheet implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $month;
    protected $year;

    public function __construct($year, $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    public function collection()
    {
        
        if (is_numeric($this->month)) {
            $orders = Order::query()
            ->select('id_order', 'full_name', 'order_time', 'shipping_fee', 'id_voucher', 'total', 'phone', 'address', 'order_status', 'payment_status')
            ->whereYear('order_time', $this->year)
            ->whereMonth('order_time', $this->month)
            ->get();

        } else {
            $orders = Order::query()
            ->select('id_order', 'full_name', 'order_time', 'shipping_fee', 'id_voucher', 'total', 'phone', 'address', 'order_status', 'payment_status')
            ->whereYear('order_time', $this->year)
            ->get();
        };
        return $orders;
        
    }
    
    public function headings(): array
    {
        return [
            'Mã đơn hàng',
            'Tên khách hàng',
            'Ngày đặt',
            'Phí vận chuyển',
            'Mã giảm giá',
            'Thành tiền',
            'SĐT',
            'Địa chỉ',
            'Trạng thái đơn hàng',
            'Thanh toán'
        ];
    }

    public function title(): string
    {
        return 'Đơn hàng';
    }
}
