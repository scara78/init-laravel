<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone_number', 'activated'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'role', 'phone_number', 'activated', 'sockect_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        if ($this->role == 'admin')
        {
            return true;
        }
    }

    public function isUser()
    {
        if ($this->role == 'user')
        {
            return true;
        }
    }

    
    public static function currentSocketUser($socket_token) {
        $socket_user = User::where('socket_token', $socket_token)->first();
        return $socket_user;
    }

    public function setOnlineState($online_state) {
        $this->online_state = $online_state;
        $this->save();
    }
}
