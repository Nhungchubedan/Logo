<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Brand;

class Image extends Model
{
    protected $table = 'image';

    protected $primaryKey = 'id_image';

    protected $fillable = [
        'id_image',
        'image_name',
        'image_url',
        'size',
        'type',
        'format'
    ];

    

}
