<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Voucher extends Model
{
    protected $table = 'voucher';

    protected $primaryKey = 'id_voucher';

    protected $fillable = [
        'id_voucher',
        'voucher_name',
        'voucher_value',
        'max',
        'is_active',
        'start_date',
        'end_date',
        'create_at',
        'update_at'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function getIdVoucherAttribute()
    {
        return $this->attributes['id_voucher']; 
    }

    public function getMaxValueAttribute()
    {
        if ($this->max !== null) {
            return 'Tối Đa '.($this->attributes['max'] / 1000).'K'; 
        }
        return 'Không Giới Hạn';
    }

}
