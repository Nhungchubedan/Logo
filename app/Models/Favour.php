<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Account;
use App\Models\Product;

class Favour extends Model
{
    protected $table = 'favour';

    protected $primaryKey = 'id_favour';
    
    public $incrementing = true;

    protected $fillable = [
        'id_favour',
        'id_user',
        'id_product',
        'create_at',
        'update_at'
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    public function user() {
        return $this->belongsTo(Account::class, 'id_user', 'id_user');
    }
}
