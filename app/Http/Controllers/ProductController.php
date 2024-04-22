<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Voucher;
use App\Models\Image;
use App\Models\Rating;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Brand;

class ProductController extends Controller
{
    public function index() {
        $products = Product::where('status', true)->get();
        $brand = Brand::all();
        $category = Category::all();
        $data = [];

        foreach ($products as $product) {
            $details = $product->orderdetail()->get();
            $totalQuantity = $details->sum('quantity');

            $data[] = [
                'product' => $product,
                'totalQuantity' => $totalQuantity,
            ];
        }

        return view('admin.product', [
            'data' => $data,
            'brand' => $brand,
            'category' => $category,
        ]);
    }

    public function store(Request $request) {
        if ($request->action == 'delete') {
            $product = Product::where('id_product', $request->input('id_product'))->first();
            $product->update([
                'status' => 0
            ]);
            toastr()->success('Đã xóa bản ghi.');
        } else {
            $validator = Validator::make($request->all(), [
                'product_name' => 'required|max:255',
                'unit_price' => 'required|numeric',  
                'iventory' => 'required|numeric|min:1|max:1000',  
                'discount' => 'required|numeric|min:0|max:50',  
                'exp' => 'required',  
                'introduction' => 'required|min:50|max:1000',  
                'uses' => 'required|max:500',  
                'incredient' => 'required|max:1000',  
                'for' => 'required|max:500',  
            ]);
            $form = $request->input('form-post');
        
            if ($validator->fails()) {
    
                return redirect()->back()->withErrors($validator->errors())->withInput(['form-post' => $form]);
    
            } else {
                $dataProduct = [
                    'product_name'  => $request->input('product_name'),  
                    'unit_price'    => $request->input('unit_price'),  
                    'iventory'      => $request->input('iventory'),  
                    'discount'      => $request->input('discount'),  
                    'id_brand'      => $request->input('id_brand'),  
                    'id_category'   => $request->input('id_category'),
                ];
                $dataProductDetail = [
                    'exp'           => $request->input('exp'),  
                    'introduction'  => $request->input('introduction'),  
                    'uses'          => $request->input('uses'),  
                    'incredient'    => $request->input('incredient'),  
                    'for'           => $request->input('for'),
                ];
                if ($request->action == 'update') {
                    $product = Product::find($request->input('id_product'));

                    $product->update($dataProduct);
                    $product->details->update($dataProductDetail);

                    if ($request->file('image')) {
                        // Lấy thông tin ảnh minh họa cũ
                        $oldImageId = $product->details->id_image;
                        $oldImage = Image::find($oldImageId); 
            
                        // Lấy ảnh mới
                        $image = $request->file('image');
                        $fileName = uniqid('', true) . '.' . $image->getClientOriginalExtension();
                        $newImage = Image::create([
                            'image_url' => $fileName,
                            'size' => $image->getSize(),
                        ]);
                        $image->move('img/', $fileName);

                        $product->details->update(['id_image' => $newImage->id_image]);
                        $product->details->save();
            
                        // Xóa ảnh cũ
                        $oldImage->delete();
                        unlink('img/'.$oldImage->image_url);
                    }
    
                    toastr()->success('Cập nhập bản ghi #'.$product->id_product);
    
                } else {
                    $product = Product::create($dataProduct);
                    ProductDetail::create([
                        'id_product'    => $product->id_product,
                        'exp'           => $request->input('exp'),  
                        'introduction'  => $request->input('introduction'),  
                        'uses'          => $request->input('uses'),  
                        'id_image'      => 000001,
                        'incredient'    => $request->input('incredient'),  
                        'for'           => $request->input('for'),
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

                        $product->details->update(['id_image' => $newImage->id_image]);
                    }
    
                    toastr()->success('Thêm mới bản ghi #'.$product->id_product);
                }
            }
        }
        return redirect()->route('admin.product.index');
    }

    public function detail($id, Request $request) {
        
        if ($request->isMethod('post')) {
            $idUser = Auth::user()->id_user;
            $idProduct = $request->input('id');

            $isExist = Cart::where('id_user', $idUser)->where('id_product', $idProduct)->exists();

            if (!$isExist) {
                Cart::create([
                    'id_user'       => $idUser,
                    'id_product'    => $idProduct,
                    'quantity'      => 1
                ]);    
            } else {
                $cart = Cart::where('id_user', $idUser)->where('id_product', $idProduct)->first();
                $cart->quantity++;
                $cart->save();
            }
            toastr()->success('Đã thêm sản phẩm và giỏ hàng!');
        }
        $product = Product::where('id_product', $id)->first();
        if (!$product) {
            toastr()->error('Sản phẩm không còn tồn tại!');
            return redirect()->back();
        }
        $voucher = Voucher::active()->orderBy('voucher_value', 'desc')->limit(5)->get();
        $relatedProduct = $this->getRelatedProducts($product);
        
        $idOrderDetail = $product->orderdetail->pluck('id_orderdetail')->toArray();
        $rating = $idOrderDetail
            ? Rating::whereIn('id_orderdetail', $idOrderDetail)->get()
            : collect(); 

        return view('product.detail', [
            'product' => $product,
            'voucher' => $voucher,
            'rating' => $rating,
            'related' => $relatedProduct,
        ]);
    } 

    private function addProductToCart(Request $request) {
        
    }

    private function getRelatedProducts($product) {

        $categoryId = $product->id_category;
        
        $relatedProduct = Product::where('id_category', $categoryId)->take(10)->get();
        $rest = 10 - $relatedProduct->count();
        
        if ($rest > 0) {
            $notRelatedProduct = Product::inRandomOrder()->take($rest)->get();
            $relatedProduct = $relatedProduct->merge($notRelatedProduct);
        }

        return $relatedProduct;
    }

    public function home() {
        $category = Category::with('image')->get();

        $saleProduct = Product::orderBy('discount', 'desc')->limit(10)->get();

        $exclusiveProduct = Product::where('id_brand', 'GUA001')->limit(10)->get();
        
        $topSellingProduct = Product::select('product.*', DB::raw('SUM(orderdetail.quantity) AS total_quantity'))
            ->join('orderdetail', 'product.id_product', '=', 'orderdetail.id_product')
            ->groupBy('product.id_product')
            ->orderBy('total_quantity', 'desc')
            ->limit(10)
            ->get();

        $brand = Brand::select('brand.*', DB::raw('COUNT(product.id_product) AS total_product'))
            ->join('product', 'brand.id_brand', '=', 'product.id_brand')
            ->groupBy('brand.id_brand')
            ->orderBy('total_product', 'desc')
            ->limit(6)
            ->get();
        
        return view('welcome', [
            'category' => $category,
            'sale'     => $saleProduct,
            'exclusive'=> $exclusiveProduct,
            'top'      => $topSellingProduct,
            'brand'    => $brand
        ]);
    }

    public function list(Request $request) {
        try {
            // Lấy loại sản phẩm cần hiển thị: theo thương hiệu || theo danh mục || theo banner
            $condition = null;
            $title = null;
            $collumn = null;
            $operator = null;
            switch (true) {
                case $request->has('category-name'):
                    $condition = $request->input('category-name');
                    $collumn = 'id_category';
                    $operator = '=';
                    $title = Category::find($condition)->category_name;
                    break;
                case $request->has('brand-name'):
                    $condition = $request->input('brand-name');
                    $collumn = 'id_brand';
                    $operator = '=';
                    $title = Brand::find($condition)->brand_name;
                    break;
                case $request->has('banner'):
                    $type = $request->input('banner');
                    switch ($type) {
                        case 'uu-dai-khung':
                            $title = 'Ưu đãi khủng';
                            $collumn = 'discount';
                            $operator = '!=';
                            $condition = 0;
                            break;
                        case 'thuong-hieu-doc-quyen':
                            $title = 'Thương hiệu độc quyền';
                            $collumn = 'id_brand';
                            $operator = '=';
                            $condition = 'GUA001';
                            break;
                        case 'san-pham-ban-chay':
                            $title = 'Sản phẩm bán chạy';
                            $allProduct = Product::query()->select('*')->whereHas('orderdetail');
                            break;
                        default:
                            // Handle invalid 'banner' type (optional)
                    }
                    break;
                case $request->has('q'):
                    $condition = '%' . $request->input('q') . '%';
                    $collumn = 'product_name';
                    $operator = 'like';
                    $title = "Kết quả tìm kiếm của '" . $request->input('q') . "'";
                    break;
            }


            if ($condition !== null) {
                $allProduct = Product::query()
                ->select('*')
                ->where(function ($query) use ($condition, $operator, $collumn) {
                    $query->where($collumn, $operator, $condition);
                });
            }
            
            
            $brand = $this->filterProduct($request, $allProduct);
            $this->sortProduct($request, $allProduct);
            
            // Phân trang
            $page = $request->input('page', 1);
            $displayProduct = $allProduct->paginate(16, ['page' => $page]);

            // Lấy tổng số sản phẩm
            $totalProduct = $allProduct->count();


            return view('product.list', [
                'product'   => $displayProduct,
                'count'     => $totalProduct,
                'title'     => $title,
                'active'    => $page,
                'brand'     => $brand
            ]);
        } catch (Exception $e) {
            return view('errors.generic', ['message' => $errorMessage]);
        }
    }

    private function filterProduct(Request $request, $product) {
        $discount = $request->input('discount', 0);
        $brand = $request->input('brand');
        $minprice = $request->input('minprice');
        $maxprice = $request->input('maxprice');

        $brandsOfProduct = $product->pluck('id_brand')->unique()->values()->toArray();
        $brands = Brand::query()
        ->select('*')
        ->whereIn('id_brand', $brandsOfProduct)
        ->get();

        switch ($discount) {
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
                $product = $product->where('discount', '<=', $discount * 10);
                break;
            case 0:
            default: break;
        }
        
        if ($brand) {
            $product = $product->whereIn('id_brand', $brand);
        }

        if ($minprice) {
            $minprice = min(2000000, max(10000, (int) $minprice));
            $maxprice = max($minprice, min(2000000, (int) $maxprice));
            $prices = [$minprice, $maxprice];
            $product = $product->whereBetween('unit_price', $prices);
        }

        return $brands;
           

    }

    private function sortProduct(Request $request, $product) {
        $sort = $request->input('sort', null);

        switch ($sort) {
            case 'create-at':
                $product->orderBy('created_at', 'desc');
                break;
            case 'desc':
                $product->orderBy('unit_price', 'desc');
                break;
            case 'asc':
                $product->orderBy('unit_price', 'asc');
                break;
            case 'best-sell':
                $product->select('product.*', DB::raw('SUM(orderdetail.quantity) as total_quantity'))
                    ->leftJoin('orderdetail', 'product.id_product', '=', 'orderdetail.id_product')
                    ->groupBy('product.id_product')
                    ->orderBy(DB::raw('SUM(orderdetail.quantity)'), 'desc');

                break;
            default:
                $product->orderBy('id_product', 'asc');
                break;
        }


    }

    public function getSearch(Request $request) {
        $search = $request->search;
        $search = "%".$search."%";
        $data = [];
        $sug = Product::where('product_name', 'like', $search)->limit(6)->get();
        foreach( $sug as $item) {
            $data[] = [
                'id'    => $item->id_product,
                'name'  => $item->product_name,
                'price' => number_format($item->newprice, 0, '', ','),
                'image' => $item->details->image->image_url
            ];
        }
        
        return response()->json($data);
    }

}
