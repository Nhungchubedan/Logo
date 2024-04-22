<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\OrderSheet;
use App\Exports\DetailSheet;
use App\Exports\ProductSheet;

class OrderExport implements WithMultipleSheets
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */

    protected $year;
    protected $month;

    public function __construct($year, $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Sheet Orders
        $sheets[] = new OrderSheet($this->year, $this->month);

        // Sheet OrderDetails
        $sheets[] = new DetailSheet($this->year, $this->month);

        // Sheet Products
        $sheets[] = new ProductSheet($this->year, $this->month);

        return $sheets;
    }
    
}
