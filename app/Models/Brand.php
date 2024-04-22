<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Image;
use App\Models\Product;

class Brand extends Model
{
    
    protected $table = 'brand';

    protected $primaryKey = 'id_brand';

    protected $fillable = [
        'id_brand',
        'brand_name',
        'id_image',
        'nation',
        'website_url',
        'description',
        'create_at',
        'update_at'
    ];

    public function image() {
        return $this->hasOne(Image::class, 'id_image', 'id_image');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'id_brand', 'id_brand');
    }

    public function getIdBrandAttribute()
    {
        return $this->attributes['id_brand']; 
    }
    
}
