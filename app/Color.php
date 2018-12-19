<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    /**
     * Get Color parent Project.
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
