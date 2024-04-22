<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    public function index() {
        $data = Voucher::where('is_active', 1)->get();
        $date = [];
        foreach ($data as $row) {
            $start_date = Carbon::parse($row->start_date)->format('m/d/Y');
            $end_date = Carbon::parse($row->end_date)->format('m/d/Y');
            $date[] = [
                'start_date' => $start_date,
                'end_date' => $end_date
            ];
        }
        return view('admin.voucher', [
            'data' => $data,
            'date' => $date
        ]);
    }

    public function store(Request $request) {
        if ($request->action == 'delete') {
            $voucher = Voucher::active()->where('id_voucher', $request->input('id_voucher'))->first();
            $voucher->update([
                'is_active' => 0
            ]);
            toastr()->success('Đã xóa bản ghi.');
        } else {
            $validator = Validator::make($request->all(), [
                'id_voucher' => 'required',
                'voucher_name' => 'required|string|max:45',  
                'voucher_value' => 'required|max:45',  
                'start_date' => 'required|date|before:end_date',  
                'end_date' => 'required|date|after:start_date',  
            ]);
            $form = $request->input('form-post');

            if (is_numeric($request->input('max'))) {
                return redirect()->back()->withErrors(['max' => 'Giá trị tối đa phải là kiểu số.'])->withInput(['form-post' => $form]);
            }
        
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput(['form-post' => $form]);
            } else {

                if ($request->action == 'update') {
                    $voucher = Voucher::active()->find($request->input('id_voucher'));

                    $voucher->update([
                        'voucher_name'  => $request->input('voucher_name'),  
                        'max'           => $request->input('max'),  
                        'voucher_value' => $request->input('voucher_value'),  
                        'start_date'    => $request->input('start_date'),  
                        'end_date'      => $request->input('end_date'),
                    ]);
                    $voucher->save();

                    toastr()->success('Cập nhập bản ghi #'.$voucher->id_voucher);
    
                } else {
                    if (Voucher::where('id_voucher', $request->input('id_voucher'))->exists()) {
                        return redirect()->back()->withErrors(['isExisted' => 'Mã đã tồn tại trong hệ thống.'])->withInput(['form-post' => $form]);
                    }
                    $voucher = Voucher::create([
                        'id_voucher'    => $request->input('id_voucher'),
                        'voucher_name'  => $request->input('voucher_name'),  
                        'max'           => $request->input('max'),  
                        'voucher_value' => $request->input('voucher_value'),  
                        'start_date'    => $request->input('start_date'),  
                        'end_date'      => $request->input('end_date'),
                    ]);
    
                    toastr()->success('Thêm mới bản ghi #'.$voucher->id_voucher);
                }
            }
        }
        return redirect()->route('admin.voucher.index');
    }
}
