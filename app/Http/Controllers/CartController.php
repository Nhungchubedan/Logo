<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Cart;

class CartController extends Controller
{
    public function detail(Request $request)
    {
        $idUser = Auth::user()->id_user;

        // Xử lý yêu cầu POST để cập nhật số lượng
        if ($request->isMethod('post')) {
            switch (true) {
                case $request->has('action'):
                    $idCart = $request->input('id');
                    $action = $request->input('action');
        
                    $cartToUpdate = Cart::where('id_cart', $idCart)->first();
        
                    if ($action === 'minus' && $cartToUpdate->quantity > 1) {
                        $cartToUpdate->quantity--;
                    } else if ($action === 'plus') {
                        $cartToUpdate->quantity++;
                    }
                    $cartToUpdate->save();
                    break;

                case $request->has('add_cart'):
                    $idProducts = $request->input('id');
                    foreach ($idProducts as $idProduct) {
                        $isExist = Cart::where('id_user', $idUser)
                        ->where('id_product', $idProduct)
                        ->exists();
                        
                        if (!$isExist) {
                            Cart::create([
                                'id_user'       => $idUser,
                                'id_product'    => $idProduct,
                                'quantity'      => 1
                            ]); 
                        } else {
                            $existedCart = Cart::where('id_user', $idUser)->where('id_product', $idProduct)->first();
                            $existedCart->quantity++;
                            $existedCart->save();
                        }
                    }
                    toastr()->success('Cập nhập giỏ hàng thành công!');
                    break;
            }
        }

        $cart = Cart::where('id_user', $idUser)->get();

        return view('user.cart.index', compact('cart'));
    }

    public function destroy($id) {
        $cart = Cart::where('id_cart', $id)->first();
        $cart->delete();
        return redirect()->route('cart');
    }
}
