<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        '_token',
        'email_verified_at',
        'password',        
        'role',        
        'family_name',
        'cell_phone',
        'interval',
        'five',
        'ten',
        'twenty',
        'thirty',
        'over',
        'is_reg',
        'reg_num',
        'trk_num',
        'file_name',
        'len',
        'access_token',
        'round',
        'stop',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
    ];

    public function products() {
        return $this->hasMany(
            Product::class,
            'user_id'
        );
    }

    public function machines() {
        return $this->hasMany(
            Machine::class,
            'user_id'
        );
    }
}
