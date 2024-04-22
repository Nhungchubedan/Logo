<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Image;
use App\Models\Product;

class ProductDetail extends Model
{
    protected $table = 'productdetail';

    protected $primaryKey = 'id_productdetail';

    protected $fillable = [
        'id_productdetail',
        'id_product',
        'id_image',
        'introduction',
        'incredient',
        'for',
        'uses',
        'exp',
        'create_at',
        'update_at'
    ];

    public function image() {
        return $this->hasOne(Image::class, 'id_image', 'id_image');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
