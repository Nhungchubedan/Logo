<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Account;
use App\Models\Voucher;
use App\Models\Payment;
use App\Models\OrderDetail;


class Order extends Model
{
    protected $table = 'order';

    protected $primaryKey = 'id_order';

    protected $fillable = [
        'id_order',
        'id_user',
        'order_time',
        'id_voucher',
        'shipping_fee',
        'delivery_time',
        'total',
        'full_name',
        'phone',
        'address',
        'note',
        'payment_status',
        'order_status',
        'updated_at',
    ];

    public $timestamps = false;

    public function user() {
        return $this->hasOne(Account::class, 'id_user', 'id_user');
    }

    public function voucher() {
        return $this->hasOne(Voucher::class, 'id_voucher', 'id_voucher');
    }

    public function payment() {
        return $this->belongsTo(Payment::class, 'id_order', 'id_order');
    }

    public function orderdetail() {
        return $this->hasMany(Orderdetail::class, 'id_order', 'id_order');
    }

    public function getDiscountCostAttribute() {
        $cost = 0;
        if (isset($this->voucher)) {
            $voucher = $this->voucher->voucher_value / 100 * $this->amount;
            $max = $this->voucher->max;
            $cost = ($max && ($voucher > $max)) ? $max : $voucher;
        }
        return $cost;
    }

    public function getAmountAttribute() {
        $amount = 0;
        $orderdetails = $this->orderdetail;
        foreach ($orderdetails as $orderdetail) {
            $amount += $orderdetail->quantity * $orderdetail->product->newprice;
        }
        return $amount;
    }
}
