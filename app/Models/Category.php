<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Image;

class Category extends Model
{
    protected $table = 'category';

    protected $primaryKey = 'id_category';

    protected $fillable = [
        'id_category',
        'id_parent_category',
        'category_name',
        'id_image',
        'create_at',
        'update_at'
    ];

    public function image() {
        return $this->hasOne(Image::class, 'id_image', 'id_image');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'id_category', 'id_category');
    }

}
