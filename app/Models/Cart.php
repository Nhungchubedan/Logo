<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';

    protected $primaryKey = 'id_cart';

    protected $fillable = [
        'id_cart',
        'id_user',
        'id_product',
        'quantity',
        'create_at',
        'update_at'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    
}
