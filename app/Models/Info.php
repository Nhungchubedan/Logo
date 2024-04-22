<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Account;

class Info extends Model
{
    protected $table = 'info';

    protected $primaryKey = 'id_info';

    protected $fillable = [
        'id_info',
        'id_user',
        'full_name',
        'phone',
        'type',
        'province',
        'district',
        'commune',
        'detail_address',
        'create_at',
        'update_at'
    ];

    public function user() {
        return $this->hasOne(Account::class, 'id_user', 'id_user');
    }
}
