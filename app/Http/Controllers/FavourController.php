<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Favour;

class FavourController extends Controller
{
    public function detail(Request $request) {
        $idUser = Auth::user()->id_user;
        if ($request->isMethod('post')) {
            $idProduct = $request->input('id');
            try {
                $isExist = Favour::where('id_user', $idUser)
                    ->where('id_product', $idProduct)
                    ->exists();

                if (!$isExist) {
                    Favour::create([
                        'id_user' => $idUser,
                        'id_product' => $idProduct,
                    ]);
                    toastr()->success('Đã thêm sản phẩm vào danh sách yêu thích!');
                } else {
                    toastr()->info('Sản phẩm đã tồn tại trong danh sách yêu thích.');
                }

            } catch (\Exception $e) {
                toastr()->error('Có lỗi xảy ra!');
                return redirect()->back();
            }
        }
        $favour = Favour::where('id_user', $idUser)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('user.favour.index', compact('favour')); 
    }

    public function destroy($id) {
        $favour = Favour::where('id_favour', $id)->first();
        $favour->delete();
        return redirect()->route('favour');
    }
}
