<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * Get Project parent User.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get Project Colors.
     */
    public function colors()
    {
        return $this->hasMany('App\Color');
    }

    /**
     * Get Project Typos.
     */
    public function typos()
    {
        return $this->hasMany('App\Typo');
    }
}
