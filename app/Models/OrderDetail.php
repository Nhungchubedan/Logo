<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Order;
use App\Models\Product;
use App\Models\Rating;

class OrderDetail extends Model
{
    protected $table = 'orderdetail';

    protected $primaryKey = 'id_orderdetail';

    protected $fillable = [
        'id_orderdetail',
        'id_product',
        'id_order',
        'quantity',
        'total'
    ];

    public function order() {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    public function rating() {
        return $this->belongsTo(Rating::class, 'id_orderdetail', 'id_orderdetail');
    }

    public function getIdOrderDetailAttribute()
    {
        return $this->attributes['id_orderdetail']; 
    }
}
