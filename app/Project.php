<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Project extends Model
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('my', function (Builder $builder) {
            $builder->where('user_id', auth()->user()->id);
        });
    }
    
    /**
     * Get Project parent User.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get Project Palettes.
     */
    public function palettes()
    {
        return $this->hasMany('App\Palette');
    }
    
    /**
     * Get Project Colors.
     */
    public function colors()
    {
        return $this->hasManyThrough('App\Color', 'App\Palette');
    }

    /**
     * Get Project Typos.
     */
    public function typos()
    {
        return $this->hasMany('App\Typo');
    }
}
