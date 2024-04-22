<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Image;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class BrandController extends Controller
{
    public function index(Request $request) {
        $data = Brand::with('image')->get();
        return view('admin.brand', ['data' => $data]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'id_brand' => 'required',
            'brand_name' => 'required',  
            'nation' => 'required',  
            'website_url' => 'string',
            'description' => 'required|min:50|max:500',  
        ]);
        $form = $request->input('form-post');
    
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator->errors())->withInput(['form-post' => $form]);

        } else {
            if ($request->action == 'update') {
                $brand = Brand::find($request->input('id_brand'));
                $brand->update([
                    'brand_name' => $request->input('brand_name'),  
                    'nation' => $request->input('nation'),  
                    'website_url' => $request->input('website_url'),
                    'description' => $request->input('description'), 
                ]);
                if ($request->file('image')) {
                    // Lấy thông tin ảnh minh họa cũ
                    $oldImageId = $brand->id_image;
                    $oldImage = Image::find($oldImageId); 
        
                    // Lấy ảnh mới
                    $image = $request->file('image');
                    $fileName = uniqid('', true) . '.' . $image->getClientOriginalExtension();
                    $newImage = Image::create([
                        'image_url' => $fileName,
                        'size' => $image->getSize(),
                    ]);
                    $image->move('img/', $fileName);
                    $brand->update(['id_image' => $newImage->id_image]);
                    $brand->save();
        
                    // Xóa ảnh cũ
                    $oldImage->delete();
                    unlink('img/'.$oldImage->image_url);
                }

                toastr()->success('Cập nhập bản ghi #'.$brand->id_brand);

            } else {
                
                Brand::create([
                    'id_brand' => $request->input('id_brand'),
                    'brand_name' => $request->input('brand_name'),  
                    'nation' => $request->input('nation'),  
                    'id_image' => null,
                    'website_url' => $request->input('website_url'),
                    'description' => $request->input('description'), 
                    'updated_at' => Carbon::now()
                ]);

                if (!$request->file('image')) {
                    return redirect()->back()->withErrors(['image' => 'Vui lòng nhập hình ảnh.'])->withInput(['form-post' => $form]);
                } else {
                    $image = $request->file('image');
                    $fileName = uniqid('', true) . '.' . $image->getClientOriginalExtension();
                    $newImage = Image::create([
                        'image_url' => $fileName,
                        'size' => $image->getSize(),
                    ]);
                    $image->move('img/', $fileName);
                    $brand = Brand::where('id_brand', $request->input('id_brand'));
                    $brand->update(['id_image' => $newImage->id_image]);
                }

                toastr()->success('Thêm mới bản ghi #'.$brand->id_brand);
            }
        }
        return redirect()->route('admin.brand.index');
    }

    public function destroy($id) {
        $brand = Brand::where('id_brand', $id)->first();
        $product[] = $brand->product;
        if (count($product) > 0) {
            foreach($product as $item) {
                $item->update([
                    'id_brand' => null,
                ]);
            }
            toastr()->warning('Tồn tại sản phẩm thuộc thương hiệu được xóa.');
        } 
        $brand->delete();
        toastr()->success('Đã xóa bản ghi.');
        return redirect()->route('admin.brand.index');
    }

    public function list(Request $request) {
        $sort = $request->input('sort', 'asc');
        $page = $request->input('page', 1);

        if ($request->has('q')) {
            $condition = '%' . $request->input('q') . '%';
            $brand = Brand::query()->select('*')->where('brand_name', 'like', $condition);
        } else {
            $brand = Brand::all();
        }
        
        $brand = $brand->orderBy('id_brand', $sort)->paginate(15, ['page' => $page]);

        $totalBrand = $brand->count();
        
        return view('brand.index', [
            'brand' => $brand,
            'count' => $totalBrand,
            'active' => $page,
        ]);
            
        
    }

    
}
