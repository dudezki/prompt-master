<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\People;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username', 'password', 'person_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'username_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function person()
    {
        return $this->belongsTo(People::class);
    }

    public function getNameAttribute()
    {
        return "{$this->person->first_name} {$this->person->last_name}";
    }

    public function avatars()
    {
        return $this->hasMany(UserAvatar::class);
    }

    public function current_avatar()
    {
        return $this->hasOne(UserAvatar::class)->where('is_current', 1);
    }

    public function getAvatarAttribute()
    {
        return base64_encode($this->current_avatar->avatar);
    }

}
