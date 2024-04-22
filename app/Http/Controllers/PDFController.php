<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Mpdf;
use App\Models\Order;

class PDFController extends Controller
{
    public function generatePDF(Request $request)
    {
        $order = Order::where('id_order', $request->input('id_order'))->first();

        $html = view('pdf.invoice', [
            'data' => $order
        ])->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        $mpdf->Output('example.pdf', 'D');
    }
}
