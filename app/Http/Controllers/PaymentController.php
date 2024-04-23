<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\LogoOrderMail;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index() {
        $data = Payment::all();
        return view('admin.payment', [
            'data' => $data
        ]);
    }

    public function pay(Request $request) {
        if (auth()->check()) {
            $paymentMethod = $request->input('paymethod') === 'onl' ? 'Chuyển khoản' : 'Tiền mặt';
            $type = $request->input('type') === 0 ? 'Nhà riêng' : 'Công ty';
            $address = 
                $request->input('address').', '
                .$request->input('commune').', '
                .$request->input('district').', '
                .$request->input('province');
            $order = Order::create([
                'id_user'       => Auth::user()->id_user,
                'order_time'    => Carbon::now(),
                'id_voucher'    => $request->input('voucher'),
                'shipping_fee'  => $request->input('shipping'),
                'total'         => $request->input('total'),
                'note'          => $request->input('note'),
                'full_name'     => $request->input('fullname'),
                'phone'         => $request->input('phone'),
                'address'       => $address,
                'payment_status'=> 'Chưa thanh toán',
                'order_status'  => 'Chờ xác nhận',
                'updated_at'    => Carbon::now(),
            ]); 
            $order->save();
            
            $payment = Payment::create([
                'id_order'          => $order->id_order,
                'payment_amount'    => $order->total,
                'payment_method'    => $paymentMethod,
            ]);
            $payment->save();

            foreach ($request->input('orderdetail') as $item) {
                $item = json_decode($item);
                $orderdetail = Orderdetail::create([
                    'id_order'  => $order->id_order,
                    'id_product'=> $item->product->id_product,
                    'quantity'  => $item->quantity,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ]);
                $orderdetail->save();
            }
            
            if ($paymentMethod === 'Tiền mặt') {
                toastr()->success('Đặt hàng thành công!');
                Mail::to($order->user->email)->send(new LogoOrderMail($order));
                return redirect()->route('order');
            } else {
                $order->update([
                    'order_status' => 'Đã hủy'
                ]);
                $order->save();
                toastr()->success('Đặt hàng thành công! Vui lòng thanh toán đơn hàng.');
                return view('user.order.pay', [
                    'order' => $order,
                ]);
            }
            
        } else {
            toastr()->error('Có lỗi xảy ra!');
        }
        return redirect()->back();
    }

    public function confirmPay(Request $request) {
        $payment = Payment::where('id_order', $request->orderId)->first();
        $order = Order::where('id_order', $request->orderId)->first();
        $order->update([
            'payment_status' => 'Đã thanh toán',
            'order_status'  => 'Chờ xác nhận'
        ]);
        $payment->update([
            'payment_time' => Carbon::now()
        ]);
        Mail::to($order->user->email)->send(new LogoOrderMail($order));
        return response()->json([
            'message'   => 'đã thanh toán'
        ]);
    }

    public function cancelOrder(Request $request) {
        $order = Order::where('id_order', $request->orderId)->first();
        $order->update([
            'payment_status' => 'Đã hủy',
        ]);
        $order->save();
        
        return response()->json([
            'message' => 'thanh toán không thành công, đơn hàng đã được hủy'
        ]);
    }
}
