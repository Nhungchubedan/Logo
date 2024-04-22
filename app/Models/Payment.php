<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';

    protected $primaryKey = 'id_payment';

    public $timestamps = false;

    protected $fillable = [
        'id_payment',
        'id_order',
        'payment_amount',
        'payment_time',
        'payment_method',
        'currency'
    ];

}
