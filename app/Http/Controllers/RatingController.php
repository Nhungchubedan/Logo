<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Rating;
use App\Models\Reply;

class RatingController extends Controller
{
    public function index() {
        $data = Rating::with('orderdetail.product')->get();
        return view('admin.rating', ['data' => $data]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'reply' => 'required|min:20|max:500',
        ]);
        $form = $request->input('form-post');
    
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator->errors())->withInput(['form-post' => $form]);

        } else {
            if ($request->input('action') == 'update') {
                $reply = Reply::where('id_rating', $request->id_rating)->first();
                if ($reply) {
                    $reply->update([
                        'reply' => $request->input('reply'),
                    ]);
                    toastr()->success('Cập nhập phản hồi thành công.');
                } else {
                    toastr()->error('Có lỗi xảy ra.');
                }
                return redirect()->route('admin.rating.index');
            } else {
                Reply::create([
                    'id_rating' => $request->input('id_rating'),
                    'reply' => $request->input('reply'),
                ]);
                toastr()->success('Phản hồi thành công.');
                return redirect()->route('admin.rating.index');
            }
        }
    }
}
