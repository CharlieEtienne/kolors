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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Get User Projects.
     */
    public function projects()
    {
        return $this->hasMany('App\Project');
    }

    /**
     * Get User Palettes.
     */
    public function palettes()
    {
        return $this->hasManyThrough('App\Palette', 'App\Project');
    }

    /**
     * Get User Typos.
     */
    public function typos()
    {
        return $this->hasManyThrough('App\Typo', 'App\Project');
    }
}
