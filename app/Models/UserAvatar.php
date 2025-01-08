<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAvatar extends Model
{
    protected $fillable = [
        'user_id',
        'avatar',
        'avatar_type',
        'is_current',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
