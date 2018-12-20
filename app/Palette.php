<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Palette extends Model
{
    /**
     * Get Palette parent Project.
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    /**
     * Get Project Colors.
     */
    public function colors()
    {
        return $this->hasMany('App\Color');
    }
}
