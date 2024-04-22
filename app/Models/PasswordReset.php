<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_resets';

    protected $primaryKey = 'email';

    protected $fillable = [
        'id',
        'email',
        'token',
        'created_at',
        'updated_at'
    ];
}
