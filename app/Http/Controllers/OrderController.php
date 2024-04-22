<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;

use App\Models\Order;
use App\Models\Account;
use App\Models\Voucher;
use App\Models\ProductDetail;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\Rating;
use App\Models\Image;

class OrderController extends Controller
{
    public function index() {
        $data = Order::all();
        return view('admin.order', ['data' => $data]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'id_order' => 'required',
            'confirm' => 'required',
        ]);
        $form = $request->input('form-post');

        $validator->sometimes('reason_other', 'required', function ($input) {
            return $input->get('reason') == 5;
        });
    
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator->errors())->withInput(['form-post' => $form]);

        } else {
            switch ($request->input('confirm')) {
                case 0:
                    $order_status = 'Đã hủy';
                    break;
                case 1:
                    $order_status = 'Đang giao hàng';
                    break;
            };
            if ($request->input('reason')) {
                switch ($request->input('reason')) {
                    case '1':
                        $emailContent = 'Sản phẩm hết hàng.';
                        break;
                    case '2':
                        $emailContent = 'Địa chỉ giao hàng không đủ thông tin.';
                        break;
                    case '3':
                        $emailContent = 'Giao hàng không thể thực hiện.';
                        break;
                    case '4':
                        $emailContent = 'Không thể liên lạc được với khách hàng.';
                        break;
                    case '5':
                        $emailContent = $request->input('reason_other');
                        break;
                }

            }
            $order = Order::find($request->input('id_order'));
            $order->update([
                'order_status' => $order_status,  
            ]);
            if ($request->input('confirm') == 0) {
                $email = $order->user->email;
                Mail::to($email)->send(new OrderMail($emailContent));
            }

            toastr()->success('Xác nhận đơn hàng #'.$order->id_order.' thành công');
            return redirect()->route('admin.order.index');
        }
            
    }

    public function detail(Request $request) {
        if ($request->isMethod('post')) {
            switch (true) {
                case $request->has('cancel-order'):
                    $idOrder = $request->input('id');
                    $order = Order::where('id_order',$idOrder);
                    $order->update([
                        'order_status' => 'Đã hủy'
                    ]);
                    toastr()->success('Đã hủy đơn hàng #'.$idOrder);
                    break;
                case $request->has('recieve-order'):
                    $idOrder = $request->input('id');
                    $order = Order::where('id_order',$idOrder);
                    $order->update([
                        'order_status' => 'Đã giao hàng'
                    ]);
                    $payment = Payment::where('id_order', $idOrder)->first();
                    if ($payment->payment_method === "Tiền mặt") {
                        $payment->update([
                            'payment_time' => Carbon::now(),
                        ]);
                        $order->update([
                            'payment_status' => 'Đã thanh toán'
                        ]);

                    }
                    toastr()->success('Xác nhận đơn hàng thành công!');
                    toastr()->info('Vui lòng đánh giá đơn hàng của bạn ^^');
                    break;

            }
        }

        $sort = $request->input('sort', 'all');
        $idUser = Auth::user()->id_user;

        $orders = Order::query()->select('*')->where('id_user', $idUser);

        switch ($sort) 
        {
            case 'done':
                $displayOrders = $orders->where('order_status', 'Đã giao hàng');
                break;
            case 'cancel':
                $displayOrders = $orders->where('order_status', 'Đã hủy');
                break;
            default:
                $displayOrders = $orders;
                break;
        }

        $displayOrders = $displayOrders->orderBy('order_time', 'desc')->get();

        return view('user.order.index', [
            'order'     => $displayOrders,
        ]);
    }

    public function orderdetail($id) {
        $order = Order::where('id_order', $id)->first();
        return view('user.order.orderdetail', [
            'order' => $order
        ]);
    }

    public function order(Request $request){
        $user = Auth::user();
        $info = $user->info;
        $voucherList = Voucher::active()->get(); 

        if (!$info) {
            toastr()->info('Vui lòng cập nhập địa chỉ trước khi đặt hàng.');
            return redirect()->back();
        } else {
            if ($request->has('add-order')) {
                switch (true) {
                    case $request->has('id-order'):
                        $orderDetails = Order::where('id_order', $request->input('id-order'))->first()->orderdetail;
                        break;
                    case $request->has('id-cart'):
                        $orderDetails = Cart::whereIn('id_cart', $request->input('id-cart'))->get();
                        break;
                    case $request->has('id-product'):
                        $orderDetails[] = ProductDetail::where('id_product', $request->input('id-product'))->first();
                        foreach ($orderDetails as $item) {
                            $item->quantity = $request->input('quantity');
                        }
                        break;
                }
                
                $totalQuantity = 0;
                $totalPayment = 0;
                foreach ($orderDetails as $orderDetail) {
                    $totalPayment += $orderDetail->quantity * $orderDetail->product->newprice;
                    $totalQuantity += $orderDetail->quantity;
                }
                
                $discountCost = 0;
                $shippingFee = ($info->province === 'Hồ Chí Minh' || $info->province === 'Hà Nội') ? 20000 : 30000;
                
                $total = $totalPayment + $shippingFee - $discountCost;
                
                
                $order = [
                    'voucher'       => null,
                    'orderDetails'  => $orderDetails,
                    'totalPayment'  => $totalPayment,
                    'totalQuantity' => $totalQuantity,
                    'discountCost'  => $discountCost,
                    'shippingFee'   => $shippingFee,
                    'total'         => $total
                ];

                session()->put('order', $order);

            } else if ($request->has('add-voucher')) {
                $order = session()->get('order');

                $idVoucher = $request->input('voucher');
                $voucher = Voucher::active()->where('id_voucher', $idVoucher)->first();
                $voucherValue = $voucher->voucher_value;
                $voucherMax = $voucher->max;
                $totalPayment = $order['totalPayment'];
                $shippingFee = ($info->province === 'Hồ Chí Minh' || $info->province === 'Hà Nội') ? 20000 : 30000;

                if ($voucherMax && $voucherValue / 100 * $totalPayment > $voucherMax) {
                    $discountCost = $voucherMax;
                } else {
                    $discountCost = $totalPayment - $voucherValue / 100 * $totalPayment;
                }
                
                $total = $totalPayment + $shippingFee - $discountCost;

                $order['voucher'] = $idVoucher;
                $order['discountCost'] = $discountCost;
                $order['total'] = $total;
                session()->put('order', $order);
            } else {
                if (session()->get('order')) {
                    $order = session()->get('order');
                } else {
                    toastr()->error('Có lỗi xảy ra!');
                    return redirect()->back();
                }
            }
        }
        
        return view('user.order.order', [
            'info'  => $info,
            'idVoucher'     => $order['voucher'],
            'orderdetail'   => $order['orderDetails'],
            'totalPayment'  => $order['totalPayment'],
            'totalQuantity' => $order['totalQuantity'],
            'discountCost'  => $order['discountCost'],
            'shippingFee'   => $order['shippingFee'],
            'total'         => $order['total'],
            'voucher'       => $voucherList,
        ]);
    }

    public function rate(Request $request) {
        $validator = Validator::make($request->all(), [
            'rate.*' => 'required', 
            'review.*' => 'max:500',  
        ]);
    
        if ($validator->fails()) {
            $message = false;
            return back()->withErrors($validator->errors());
        } else {
            $id = $request->input('id', []);
            $rate = $request->input('rate', []);
            $review = $request->input('review', []);
            $image1 = $request->file('image_1', []);
            $image2 = $request->file('image_2', []);
            $image3 = $request->file('image_3', []);

            for ($i = 0; $i < count($id); $i++) {
                $rating = Rating::create([
                    'id_user'           => Auth::user()->id_user,
                    'id_orderdetail'    => $id[$i],
                    'rating'            => $rate[$i],
                    'review'            => $review[$i]
                ]);

                // Image 1
                if (isset($image1[$i])) {
                    $image = Image::create([
                        'image_url' => uniqid('', true) . '.' . $image1[$i]->getClientOriginalExtension(),
                        'size' => $image1[$i]->getSize(),
                    ]);
                    $image1[$i]->move('img/', $image->image_url);

                    $rating->update([
                        'id_image1' => $image->id_image,
                    ]);
                }

                // Image 2
                if (isset($image2[$i])) {
                    $image = Image::create([
                        'image_url' => uniqid('', true) . '.' . $image2[$i]->getClientOriginalExtension(),
                        'size' => $image2[$i]->getSize(),
                    ]);
                    $image2[$i]->move('img/', $image->image_url);

                    $rating->update([
                        'id_image1' => $image->id_image,
                    ]);
                }

                // Image 1
                if (isset($image3[$i])) {
                    $image = Image::create([
                        'image_url' => uniqid('', true) . '.' . $image3[$i]->getClientOriginalExtension(),
                        'size' => $image3[$i]->getSize(),
                    ]);
                    $image3[$i]->move('img/', $image->image_url);

                    $rating->update([
                        'id_image3' => $image->id_image,
                    ]);
                }
                
            };
            toastr()->success('Cám ơn bạn đã đánh giá sản phẩm!');
            return redirect()->route('order');
        }
        
    }

}
