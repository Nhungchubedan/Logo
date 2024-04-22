<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;
use App\Models\Image;

class CategoryController extends Controller
{
    public function index() {
        $data = Category::with('image')->get();
        return view('admin.category', ['data' => $data]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required',  
        ]);
        $form = $request->input('form-post');
    
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator->errors())->withInput(['form-post' => $form]);

        } else {
            if ($request->action == 'update') {
                $category = Category::find($request->input('id_category'));
                $category->update([
                    'category_name' => $request->input('category_name'),  
                ]);
                if ($request->file('image')) {
                    // Lấy thông tin ảnh minh họa cũ
                    $oldImageId = $category->id_image;
                    $oldImage = Image::find($oldImageId); 
        
                    // Lấy ảnh mới
                    $image = $request->file('image');
                    $fileName = uniqid('', true) . '.' . $image->getClientOriginalExtension();
                    $newImage = Image::create([
                        'image_url' => $fileName,
                        'size' => $image->getSize(),
                    ]);
                    $image->move('img/', $fileName);
                    $category->update(['id_image' => $newImage->id_image]);
                    $category->save();
        
                    // Xóa ảnh cũ
                    $oldImage->delete();
                    unlink('img/'.$oldImage->image_url);
                }

                toastr()->success('Cập nhập bản ghi #'.$category->id_category);

            } else {
                
                $category = Category::create([
                    'category_name' => $request->input('category_name'),  
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
                    $category->update(['id_image' => $newImage->id_image]);
                }

                toastr()->success('Thêm mới bản ghi #'.$category->id_category);
            }
        }
        return redirect()->route('admin.category.index');
    }

    public function destroy($id) {
        $category = Category::where('id_category', $id)->first();

        if ($category->product != null) {
            $products = (!is_array($category->product)) ? [$category->product] : $category->product;
            foreach($products as $item) {
                $item->update([
                    'id_category' => null,
                ]);
            }
            toastr()->warning('Tồn tại sản phẩm thuộc danh mục được xóa.');
        }
        $category->delete();
        toastr()->success('Đã xóa bản ghi.');
        return redirect()->route('admin.category.index');
    }
}
