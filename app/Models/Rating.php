<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Account;
use App\Models\Image;
use App\Models\Reply;
use App\Models\OrderDetail;

class Rating extends Model
{
    protected $table = 'rating';

    protected $primaryKey = 'id_rating';

    protected $fillable = [
        'id_rating',
        'id_user',
        'id_orderdetail',
        'rating',
        'review',
        'create_at',
        'update_at',
        'id_image1',
        'id_image2',
        'id_image3'
    ];

    public function orderdetail() {
        return $this->hasOne(OrderDetail::class, 'id_orderdetail', 'id_orderdetail');
    }

    public function user() {
        return $this->hasOne(Account::class, 'id_user', 'id_user');
    }

    public function image1() {
        return $this->hasOne(Image::class, 'id_image', 'id_image1');
    }

    public function image2() {
        return $this->hasOne(Image::class, 'id_image', 'id_image2');
    }

    public function image3() {
        return $this->hasOne(Image::class, 'id_image', 'id_image3');
    }

    public function reply() {
        return $this->belongsTo(Reply::class, 'id_rating', 'id_rating');
    }

    
}
