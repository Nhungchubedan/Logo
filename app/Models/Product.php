<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\OrderDetail;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductDetail;

class Product extends Model
{
    protected $table = 'product';

    protected $primaryKey = 'id_product';

    protected $fillable = [
        'id_product',
        'id_brand',
        'id_category',
        'product_name',
        'unit_price',
        'iventory',
        'discount',
        'status',
        'create_at',
        'update_at'
    ];

    public function orderdetail() {
        return $this->hasMany(OrderDetail::class, 'id_product', 'id_product');
    }

    public function brand() {
        return $this->hasOne(Brand::class, 'id_brand', 'id_brand');
    }

    public function category() {
        return $this->hasOne(Category::class, 'id_category', 'id_category');
    }

    public function details() {
        return $this->hasOne(ProductDetail::class, 'id_product', 'id_product');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getNewPriceAttribute() {
        $oldPrice = $this->attributes['unit_price'];
        $discount = $this->attributes['discount'];
        $newPrice = $oldPrice * (1 - $discount / 100);
        return $newPrice; 
    }
    
    public function getRatingValueAttribute() {
        $idOrderDetail = [];
        foreach ($this->orderdetail as $item) {
            $idOrderDetail[] = $item->idorderdetail;
        }

        if (is_null($idOrderDetail)) {
            return $rating = 0;
        } else {
            $rating = round(Rating::whereIn('id_orderdetail', $idOrderDetail)->avg('rating'), 1);
            $rating = $rating ?? 0;
        }
        return $rating;
    }

}
