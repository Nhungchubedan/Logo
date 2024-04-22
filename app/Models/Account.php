<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Image;
use App\Models\Role;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Account extends Model implements Authenticatable
{
    use AuthenticableTrait;

    protected $table = 'user';

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'id_user',
        'id_role',
        'user_name',
        'email',
        'password',
        'provider',
        'provider_id',
        'confirm',
        'confirmation_code',
        'confirmation_code_expired_in',
        'confirm',
        'status',
        'id_image',
        'image_link',
        'create_at',
        'update_at'
    ];

    public function image() {
        return $this->hasOne(Image::class, 'id_image', 'id_image');
    }

    public function role() {
        return $this->hasOne(Role::class, 'id_role', 'id_role');
    }

    public function info() {
        return $this->belongsTo(Info::class, 'id_user', 'id_user');
    }

    public function getAuthIdentifierName() {
        return 'email'; 
    }

    public function getAuthIdentifier() {
        return $this->email; 
    }

    public function getAuthPassword() {
        return $this->password; 
    }

    public function getRememberToken() {
        return $this->remember_token; 
    }

    public function setRememberToken($value) {
        $this->remember_token = $value; 
    }

    public function getRememberTokenName() {
        return 'remember_token'; 
    }
}
