<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Statamic\Facades\User as UserFacade;

class User extends Authenticatable
{
    // Laravel
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // Statamic
        'super' => 'integer',
        'last_login' => 'datetime',
        // Laravel
        'email_verified_at' => 'datetime',
    ];

    public static function findByEmail(string $email)
    {
        return static::where('email', $email)->first();
    }

    public function toStatamicUser()
    {
        return UserFacade::find($this->id);
    }

    public function getNameAttribute()
    {
        return $this->fullName();
    }

    public function fullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
