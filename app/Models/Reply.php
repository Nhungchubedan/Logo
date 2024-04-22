<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Rating;

class Reply extends Model
{
    protected $table = 'reply';

    protected $primaryKey = 'id_reply';

    protected $fillable = [
        'id_reply',
        'id_rating',
        'reply',
        'create_at',
        'update_at',
    ];

    public function rating() {
        return $this->hasOne(Rating::class, 'id_rating', 'id_rating');
    }
}
